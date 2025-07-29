<?php

class DevHub_Tab_Assets {

    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_devhub_get_assets', [$this, 'get_assets']);
        add_action('wp_ajax_devhub_dequeue_asset', [$this, 'dequeue_asset']);
    }

    public function enqueue_assets($hook) {
        if ($hook !== 'toplevel_page_developer-hub') return;

        wp_enqueue_script(
            'devhub-assets',
            plugin_dir_url(__FILE__) . '../js/devhub-assets.js',
            ['jquery'],
            '1.0',
            true
        );

        wp_localize_script('devhub-assets', 'devHubAssets', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('devhub_nonce')
        ]);
    }

    public function render_tab_content() { ?>
        <div class="tab-content" id="tab-assets">
            <h2>Assets Manager</h2>
            
            <!-- Filters -->
            <div id="assets-filters" style="margin-bottom:15px;">
                <select id="filter-type">
                    <option value="">All Types</option>
                    <option value="CSS">CSS</option>
                    <option value="JS">JS</option>
                    <option value="image">Images</option>
                    <option value="font">Fonts</option>
                </select>
                <select id="filter-origin">
                    <option value="">All Origins</option>
                    <option value="theme">Theme</option>
                    <option value="plugin">Plugin</option>
                    <option value="core">WordPress Core</option>
                    <option value="external">External</option>
                </select>
                <select id="filter-context">
                    <option value="">All Contexts</option>
                    <option value="frontend">Frontend</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="text" id="filter-search" placeholder="Search handle or file..." />
                <select id="filter-size">
                    <option value="">Any Size</option>
                    <option value="50">> 50KB</option>
                    <option value="100">> 100KB</option>
                    <option value="250">> 250KB</option>
                    <option value="500">> 500KB</option>
                </select>
                <button class="button" id="reload-assets">Reload</button>
            </div>

            <!-- Table -->
            <table class="widefat" id="assets-table">
                <thead>
                    <tr>
                        <th>Type</th><th>Handle</th><th>Source</th><th>Origin</th>
                        <th>Dependencies</th><th>Size</th><th>Context</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="8">Loading assets...</td></tr>
                </tbody>
            </table>
        </div>
    <?php 
    }


    public function get_assets() {
        check_ajax_referer('devhub_nonce', 'nonce');
        global $wp_styles, $wp_scripts;

        $assets = [];

        // CSS
        foreach ($wp_styles->registered as $handle => $style) {
            $assets[] = [
                'type'   => 'CSS',
                'handle' => $handle,
                'src'    => $style->src,
                'origin' => $this->detect_origin($style->src),
                'deps'   => implode(', ', $style->deps),
                'size'   => $this->get_file_size($style->src),
                'context'=> $this->detect_context($handle)
            ];
        }

        // JS
        foreach ($wp_scripts->registered as $handle => $script) {
            $assets[] = [
                'type'   => 'JS',
                'handle' => $handle,
                'src'    => $script->src,
                'origin' => $this->detect_origin($script->src),
                'deps'   => implode(', ', $script->deps),
                'size'   => $this->get_file_size($script->src),
                'context'=> $this->detect_context($handle)
            ];
        }

        wp_send_json_success($assets);
    }

        private function detect_origin($src) {
            if (strpos($src, content_url('themes')) !== false) return 'theme';
            if (strpos($src, content_url('plugins')) !== false) return 'plugin';
            if (strpos($src, includes_url()) !== false) return 'core';
            if (strpos($src, site_url()) === false) return 'external';
            return 'unknown';
        }

        private function detect_context($handle) {
            // Simple approach, later improve with $wp_styles/$wp_scripts queue locations
            return is_admin() ? 'admin' : 'frontend';
        }



    public function dequeue_asset() {
        check_ajax_referer('devhub_nonce', 'nonce');

        $handle = sanitize_text_field($_POST['handle']);
        $type = sanitize_text_field($_POST['type']);

        if ($type === 'CSS') {
            wp_dequeue_style($handle);
        } else {
            wp_dequeue_script($handle);
        }

        wp_send_json_success(['message' => "Asset $handle dequeued"]);
    }

    private function get_file_size($src) {
        $path = ABSPATH . str_replace(site_url('/'), '', $src);
        if (file_exists($path)) {
            return size_format(filesize($path));
        }
        return '-';
    }
}
