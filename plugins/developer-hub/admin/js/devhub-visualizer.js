jQuery(document).ready(function ($) {
    let cy;

    function loadGraph() {
        $.post(devHubVisualizer.ajaxUrl, {
            action: 'devhub_get_visualizer_data',
            nonce: devHubVisualizer.nonce
        }, function (res) {
            if (!res.success) {
                console.error('Visualizer data load failed');
                return;
            }

            const { nodes, edges } = res.data;

            // ✅ Validate edges to avoid "nonexistent source/target"
            const nodeIds = nodes.map(n => n.data.id);
            const validEdges = edges.filter(edge => {
                return nodeIds.includes(edge.data.source) && nodeIds.includes(edge.data.target);
            });

            cy = cytoscape({
                container: document.getElementById('visualizer-graph'),
                elements: [...nodes, ...validEdges],
                style: [
                    { selector: 'node[type="cpt"]', style: { 'background-color': '#0073aa', 'label': 'data(label)', 'color': '#000', 'text-valign': 'center', 'text-halign': 'center', 'font-size': '11px' }},
                    { selector: 'node[type="taxonomy"]', style: { 'background-color': '#ffb900', 'label': 'data(label)', 'color': '#000', 'text-valign': 'center', 'text-halign': 'center', 'font-size': '11px' }},
                    { selector: 'node[type="page"]', style: { 'background-color': '#46b450', 'label': 'data(label)', 'color': '#000', 'text-valign': 'center', 'text-halign': 'center', 'font-size': '11px' }},
                    { selector: 'node[type="template"]', style: { 'background-color': '#555d66', 'label': 'data(label)', 'color': '#000', 'text-valign': 'center', 'text-halign': 'center', 'font-size': '11px' }},
                    { selector: 'node[type="part"]', style: { 'background-color': '#d63638', 'label': 'data(label)', 'color': '#000', 'text-valign': 'center', 'text-halign': 'center', 'font-size': '11px' }},
                    { selector: 'node[type="acf"]', style: { 'background-color': '#8f42ff', 'label': 'data(label)', 'color': '#000', 'text-valign': 'center', 'text-halign': 'center', 'font-size': '11px' }},
                    { selector: 'edge', style: { 'width': 2, 'line-color': '#ccc', 'target-arrow-color': '#ccc', 'target-arrow-shape': 'triangle' }}
                ],
                layout: { name: 'cose', animate: true }
            });

            cy.on('tap', 'node', function (evt) {
                console.log('Node clicked:', evt.target.data());
                alert('Node: ' + evt.target.data('label'));
            });
        });
    }

    // Toggle layer filters
    $(document).on('change', '.layer-toggle', function () {
        const type = $(this).val();
        const checked = $(this).is(':checked');
        if (!cy) return;

        // ✅ Hide/show nodes and related edges
        cy.$(`node[type="${type}"], edge[source ^= "${type}_"], edge[target ^= "${type}_"]`)
          .style('display', checked ? 'element' : 'none');
    });

    // Reload graph
    $('#reload-graph').on('click', loadGraph);

    // Export PNG
    $('#export-graph').on('click', function () {
        if (!cy) return;
        const png = cy.png();
        const a = document.createElement('a');
        a.href = png;
        a.download = 'visualizer.png';
        a.click();
    });

    loadGraph();
});
