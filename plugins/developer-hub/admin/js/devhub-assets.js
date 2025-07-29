jQuery(document).ready(function($) {
    let allAssets = [];

    function applyFilters() {
        const type = $('#filter-type').val();
        const origin = $('#filter-origin').val();
        const context = $('#filter-context').val();
        const search = $('#filter-search').val().toLowerCase();
        const size = $('#filter-size').val();

        const filtered = allAssets.filter(asset => {
            if (type && asset.type !== type && !(type === 'image' && asset.src.match(/\.(png|jpg|jpeg|gif|svg)$/i)) && !(type === 'font' && asset.src.match(/\.(woff2?|ttf|otf|eot)$/i))) return false;
            if (origin && asset.origin !== origin) return false;
            if (context && asset.context !== context) return false;
            if (search && !asset.handle.toLowerCase().includes(search) && !asset.src.toLowerCase().includes(search)) return false;
            if (size && parseInt(asset.size) < parseInt(size) * 1024) return false; // KB threshold
            return true;
        });

        renderTable(filtered);
    }

    function renderTable(assets) {
        if (!assets.length) {
            $('#assets-table tbody').html('<tr><td colspan="8">No assets found.</td></tr>');
            return;
        }

        let rows = '';
        assets.forEach(asset => {
            rows += `
                <tr>
                    <td>${asset.type}</td>
                    <td>${asset.handle}</td>
                    <td>${asset.src || '-'}</td>
                    <td>${asset.origin}</td>
                    <td>${asset.deps || '-'}</td>
                    <td>${asset.size || '-'}</td>
                    <td>${asset.context}</td>
                    <td>
                        <button class="button dequeue-asset" data-handle="${asset.handle}" data-type="${asset.type}">Dequeue</button>
                    </td>
                </tr>`;
        });
        $('#assets-table tbody').html(rows);
    }

    function loadAssets() {
        $('#assets-table tbody').html('<tr><td colspan="8">Loading...</td></tr>');
        $.post(devHubAssets.ajaxUrl, { action: 'devhub_get_assets', nonce: devHubAssets.nonce }, function(res) {
            if (!res.success) return;
            allAssets = res.data;
            applyFilters();
        });
    }

    // Event listeners
    $('#reload-assets').on('click', loadAssets);
    $('#filter-type, #filter-origin, #filter-context, #filter-size').on('change', applyFilters);
    $('#filter-search').on('keyup', applyFilters);

    // Dequeue button
    $(document).on('click', '.dequeue-asset', function() {
        const handle = $(this).data('handle');
        const type = $(this).data('type');
        $.post(devHubAssets.ajaxUrl, {
            action: 'devhub_dequeue_asset',
            handle, type,
            nonce: devHubAssets.nonce
        }, function(res) {
            alert(res.data.message);
            loadAssets();
        });
    });

    loadAssets();
});
