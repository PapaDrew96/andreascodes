<?php

class DevHub_Tab_Visualizer {

    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_devhub_get_visualizer_data', [$this, 'get_visualizer_data']);
    }

    public function enqueue_assets($hook) {
        if ($hook !== 'toplevel_page_developer-hub') return;

        // Cytoscape core
        wp_enqueue_script(
            'cytoscape',
            'https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.27.0/cytoscape.min.js',
            [],
            '3.27.0',
            true
        );

        // Correct path to our visualizer JS
        wp_enqueue_script(
            'devhub-visualizer',
            plugin_dir_url(dirname(__FILE__)) . 'js/devhub-visualizer.js',
            ['jquery', 'cytoscape'],
            '1.2',
            true
        );

        wp_localize_script('devhub-visualizer', 'devHubVisualizer', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('devhub_nonce')
        ]);
    }

    public function render_tab_content() { ?>
        <div class="tab-content" id="tab-visualizer">
            <h2>Project Structure Visualizer</h2>
            
            <div id="visualizer-toolbar">
                <button class="button" id="reload-graph">Reload</button>
                <button class="button" id="export-graph">Export PNG</button>
                <div id="layer-filters">
                    <label><input type="checkbox" class="layer-toggle" value="cpt" checked> CPTs</label>
                    <label><input type="checkbox" class="layer-toggle" value="taxonomy" checked> Taxonomies</label>
                    <label><input type="checkbox" class="layer-toggle" value="page" checked> Pages</label>
                    <label><input type="checkbox" class="layer-toggle" value="template" checked> Templates</label>
                    <label><input type="checkbox" class="layer-toggle" value="part" checked> Template Parts</label>
                    <label><input type="checkbox" class="layer-toggle" value="acf" checked> ACF Groups</label>
                </div>
            </div>

            <div id="visualizer-graph" style="height: 650px; background: #f7f7f7; margin-top: 15px; border: 1px solid #ddd;"></div>
        </div>
    <?php }

    private function node_exists($id, $nodes) {
        foreach ($nodes as $node) {
            if ($node['data']['id'] === $id) return true;
        }
        return false;
    }

        public function get_visualizer_data() {
    check_ajax_referer('devhub_nonce', 'nonce');

    $nodes = [];
    $edges = [];

    // 1. CPTs
    $cpts = get_post_types([], 'objects');
    foreach ($cpts as $slug => $cpt) {
        $nodes[] = ['data' => [
            'id' => "cpt_$slug",
            'label' => "CPT: {$cpt->labels->name}",
            'type' => 'cpt'
        ]];
    }

    // 2. Taxonomies
    $taxonomies = get_taxonomies([], 'objects');
    foreach ($taxonomies as $slug => $tax) {
        $nodes[] = ['data' => [
            'id' => "tax_$slug",
            'label' => "Tax: {$tax->labels->name}",
            'type' => 'taxonomy'
        ]];

        foreach ($tax->object_type as $cpt) {
            $edges[] = ['data' => [
                'source' => "cpt_$cpt",
                'target' => "tax_$slug"
            ]];
        }
    }

    // 3. Pages + Templates
    $pages = get_posts(['post_type' => 'page', 'posts_per_page' => -1]);
    $page_templates = [];
    foreach ($pages as $page) {
        $template = get_page_template_slug($page->ID) ?: 'page.php';
        $template_id = sanitize_title($template);

        $nodes[] = ['data' => [
            'id' => "page_{$page->ID}",
            'label' => "Page: {$page->post_title}",
            'type' => 'page'
        ]];

        // Ensure each template is only added once
        if (!isset($page_templates[$template_id])) {
            $nodes[] = ['data' => [
                'id' => "template_$template_id",
                'label' => "Template: $template",
                'type' => 'template'
            ]];
            $page_templates[$template_id] = [];
        }

        // Add page to template mapping
        $page_templates[$template_id][] = "page_{$page->ID}";

        // Connect page → template
        $edges[] = ['data' => [
            'source' => "page_{$page->ID}",
            'target' => "template_$template_id"
        ]];
    }

    // 4. Template Parts → Templates + Pages
    $parts_dir = get_theme_file_path('template-parts');
    if (is_dir($parts_dir)) {
        $files = glob($parts_dir . '/**/*.php');
        foreach ($files as $file) {
            $slug = basename($file, '.php');
            $part_id = "part_$slug";

            // Add node for part
            $nodes[] = ['data' => [
                'id' => $part_id,
                'label' => "Part: $slug.php",
                'type' => 'part'
            ]];

            // Check each template and connect part → template + part → pages
            foreach (glob(get_template_directory() . '/*.php') as $template_file) {
                $template_name = basename($template_file);
                $template_id = sanitize_title($template_name);

                // Does this template file include the template part?
                $contents = file_get_contents($template_file);
                if (strpos($contents, "get_template_part('template-parts/$slug") !== false ||
                    strpos($contents, "get_template_part(\"template-parts/$slug") !== false) {

                    // Connect part → template
                    $edges[] = ['data' => [
                        'source' => $part_id,
                        'target' => "template_$template_id"
                    ]];

                    // Connect part → all pages using this template
                    if (!empty($page_templates[$template_id])) {
                        foreach ($page_templates[$template_id] as $page_node_id) {
                            $edges[] = ['data' => [
                                'source' => $part_id,
                                'target' => $page_node_id
                            ]];
                        }
                    }
                }
            }
        }
    }

    // 5. ACF Field Groups (unchanged)
    if (function_exists('acf_get_field_groups')) {
        $groups = acf_get_field_groups();
        foreach ($groups as $group) {
            $group_id = "acf_{$group['key']}";
            $nodes[] = ['data' => [
                'id' => $group_id,
                'label' => "ACF: {$group['title']}",
                'type' => 'acf'
            ]];

            if (!empty($group['location'])) {
                foreach ($group['location'] as $or) {
                    foreach ($or as $rule) {
                        $target = '';
                        if ($rule['param'] === 'post_type') {
                            $target = "cpt_{$rule['value']}";
                        } elseif ($rule['param'] === 'page_template') {
                            $target = "template_{$rule['value']}";
                        } elseif ($rule['param'] === 'taxonomy') {
                            $target = "tax_{$rule['value']}";
                        }

                        if ($target) {
                            $edges[] = ['data' => [
                                'source' => $group_id,
                                'target' => $target
                            ]];
                        }
                    }
                }
            }
        }
    }

    wp_send_json_success(['nodes' => $nodes, 'edges' => $edges]);
}


}
