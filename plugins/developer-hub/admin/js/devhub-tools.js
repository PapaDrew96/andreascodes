jQuery(document).ready(function($) {

    // --- Load Transients ---
    function loadTransients(search = '') {
        $.post(devHubTools.ajaxUrl, { action: 'devhub_get_transients', nonce: devHubTools.nonce, search }, function(res) {
            if (res.success) $('#transient-results').html(res.data.html);
        });
    }

    // Initial load
    loadTransients();

    $('#transient-search').on('input', function() {
        loadTransients($(this).val());
    });

    // Select all checkbox
    $(document).on('change', '#select-all-transients', function() {
        $('#transient-results input[type="checkbox"]').prop('checked', this.checked);
    });

    // Bulk delete
    $('#bulk-transients-form').on('submit', function(e) {
        e.preventDefault();
        let items = [];
        $('#transient-results input[type="checkbox"]:checked').each(function() {
            items.push($(this).val());
        });
        if (items.length === 0) {
            alert('Select at least one transient');
            return;
        }
        $.post(devHubTools.ajaxUrl, { action: 'devhub_bulk_delete_transients', nonce: devHubTools.nonce, items }, function(res) {
            alert(res.data.message);
            loadTransients();
        });
    });

    // Delete single transient
    $(document).on('click', '.delete-transient', function() {
        const name = $(this).data('name');
        $.post(devHubTools.ajaxUrl, { action: 'devhub_delete_transient', nonce: devHubTools.nonce, name }, function(res) {
            alert(res.data.message);
            loadTransients();
        });
    });

    $('#clear-transients').on('click', function() {
        $.post(devHubTools.ajaxUrl, { action: 'devhub_clear_transients', nonce: devHubTools.nonce }, function(res) {
            alert(res.data.message);
            loadTransients();
        });
    });

    // --- DB ---
    function loadDBStatus() {
        $.post(devHubTools.ajaxUrl, { action: 'devhub_get_db_status', nonce: devHubTools.nonce }, function(res) {
            if (res.success) $('#db-status').html(res.data.html);
        });
    }
    loadDBStatus();

    $(document).on('click', '.optimize-table', function() {
        const table = $(this).data('table');
        $.post(devHubTools.ajaxUrl, { action: 'devhub_optimize_table', nonce: devHubTools.nonce, table }, function(res) {
            alert(res.data.message);
            loadDBStatus();
        });
    });

    $('#db-search').on('input', function() {
        const filter = $(this).val().toLowerCase();
        $('#db-status table tbody tr').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    // --- System Info ---
    function loadSystemInfo() {
        $.post(devHubTools.ajaxUrl, { action: 'devhub_system_info', nonce: devHubTools.nonce }, function(res) {
            if (res.success) {
                let html = '<ul>';
                $.each(res.data.info, function(key, value) {
                    html += `<li><strong>${key}:</strong> ${value}</li>`;
                });
                html += '</ul>';
                $('#system-info').html(html);
            }
        });
    }
    loadSystemInfo();

    $('#download-system-info').on('click', function() {
        const text = $('#system-info').text();
        const blob = new Blob([text], { type: 'text/plain' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'system-info.txt';
        a.click();
    });

    // --- Maintenance ---
    $('#toggle-maintenance').on('click', function() {
        $.post(devHubTools.ajaxUrl, { action: 'devhub_toggle_maintenance', nonce: devHubTools.nonce }, function(res) {
            alert(res.data.message);
        });
    });

    $('#force-logout').on('click', function() {
        $.post(devHubTools.ajaxUrl, { action: 'devhub_force_logout', nonce: devHubTools.nonce }, function(res) {
            alert(res.data.message);
        });
    });

    $('#flush-rewrites').on('click', function() {
        $.post(devHubTools.ajaxUrl, { action: 'devhub_flush_rewrites', nonce: devHubTools.nonce }, function(res) {
            alert(res.data.message);
        });
    });
});
