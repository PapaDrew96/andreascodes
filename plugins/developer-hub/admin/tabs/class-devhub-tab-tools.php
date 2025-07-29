<?php
class DevHub_Tab_Tools {

    public function __construct() {
        // AJAX Hooks
        add_action('wp_ajax_devhub_flush_rewrites', [$this, 'flush_rewrites']);
        add_action('wp_ajax_devhub_get_transients', [$this, 'get_transients']);
        add_action('wp_ajax_devhub_clear_transients', [$this, 'clear_transients']);
        add_action('wp_ajax_devhub_delete_transient', [$this, 'delete_transient']);
        add_action('wp_ajax_devhub_bulk_delete_transients', [$this, 'bulk_delete_transients']);
        add_action('wp_ajax_devhub_get_db_status', [$this, 'get_db_status']);
        add_action('wp_ajax_devhub_optimize_table', [$this, 'optimize_table']);
        add_action('wp_ajax_devhub_system_info', [$this, 'system_info']);
        add_action('wp_ajax_devhub_toggle_maintenance', [$this, 'toggle_maintenance']);
        add_action('wp_ajax_devhub_force_logout', [$this, 'force_logout']);
    }

    public function render_tab_content() { ?>
        <div class="tab-content" id="tab-tools">
            <h2>Developer Tools</h2>

            <!-- CACHE -->
            <div class="tools-section">
                <h3>Cache & Debugging</h3>
                <button class="button" id="flush-rewrites">Flush Rewrite Rules</button>
                <button class="button" id="clear-transients">Clear All Transients</button>

                <div id="transients-list" style="margin-top: 15px;">
                    <h4>Existing Transients</h4>
                    <input type="text" id="transient-search" placeholder="Search transients..." style="width: 300px;">
                    <form id="bulk-transients-form">
                        <div id="transient-results"></div>
                        <button type="submit" class="button button-primary" id="bulk-delete">Delete Selected</button>
                    </form>
                </div>
            </div>

            <!-- DATABASE -->
            <div class="tools-section">
                <h3>Database Status</h3>
                <input type="text" id="db-search" placeholder="Search tables..." style="width: 300px;">
                <div id="db-status">Loading...</div>
            </div>

            <!-- SYSTEM INFO -->
            <div class="tools-section">
                <h3>System Info</h3>
                <div id="system-info"></div>
                <button class="button" id="download-system-info">Download Report</button>
            </div>

            <!-- MAINTENANCE -->
            <div class="tools-section">
                <h3>Maintenance & Security</h3>
                <button class="button" id="toggle-maintenance">Toggle Maintenance Mode</button>
                <button class="button" id="force-logout">Force Logout All Users</button>
            </div>
        </div>
    <?php }

    /** Flush rewrite rules **/
    public function flush_rewrites() {
        check_ajax_referer('devhub_nonce', 'nonce');
        flush_rewrite_rules();
        wp_send_json_success(['message' => 'Rewrite rules flushed successfully']);
    }

    /** Transients **/
    public function get_transients() {
        global $wpdb;
        check_ajax_referer('devhub_nonce', 'nonce');
        $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
        $like = $search ? $wpdb->esc_like($search) : '';
        $query = "SELECT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_%'";
        if ($like) $query .= " AND option_name LIKE '%$like%'";
        $transients = $wpdb->get_col($query);

        ob_start(); ?>
        <table class="widefat">
            <thead><tr>
                <th><input type="checkbox" id="select-all-transients"></th>
                <th>Transient Name</th>
                <th>Actions</th>
            </tr></thead>
            <tbody>
            <?php if (!empty($transients)): ?>
                <?php foreach ($transients as $t): ?>
                    <tr>
                        <td><input type="checkbox" name="transients[]" value="<?php echo esc_attr($t); ?>"></td>
                        <td><?php echo esc_html($t); ?></td>
                        <td><button type="button" class="button delete-transient" data-name="<?php echo esc_attr($t); ?>">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">No transients found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php $html = ob_get_clean();
        wp_send_json_success(['html' => $html]);
    }

    public function clear_transients() {
        global $wpdb;
        check_ajax_referer('devhub_nonce', 'nonce');
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'");
        wp_send_json_success(['message' => 'All transients cleared']);
    }

    public function delete_transient() {
        check_ajax_referer('devhub_nonce', 'nonce');
        $name = sanitize_text_field($_POST['name']);
        delete_transient(str_replace('_transient_', '', $name));
        wp_send_json_success(['message' => "Transient deleted"]);
    }

    public function bulk_delete_transients() {
        check_ajax_referer('devhub_nonce', 'nonce');
        $items = isset($_POST['items']) ? (array) $_POST['items'] : [];
        foreach ($items as $name) {
            delete_transient(str_replace('_transient_', '', sanitize_text_field($name)));
        }
        wp_send_json_success(['message' => count($items) . " transients deleted"]);
    }

    /** Database **/
    public function get_db_status() {
        global $wpdb;
        check_ajax_referer('devhub_nonce', 'nonce');
        $tables = $wpdb->get_results("SHOW TABLE STATUS");
        ob_start(); ?>
        <table class="widefat">
            <thead><tr><th>Table</th><th>Rows</th><th>Size</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td><?php echo esc_html($table->Name); ?></td>
                        <td><?php echo esc_html($table->Rows); ?></td>
                        <td><?php echo size_format($table->Data_length + $table->Index_length); ?></td>
                        <td><button type="button" class="button optimize-table" data-table="<?php echo esc_attr($table->Name); ?>">Optimize</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php $html = ob_get_clean();
        wp_send_json_success(['html' => $html]);
    }

    public function optimize_table() {
        global $wpdb;
        check_ajax_referer('devhub_nonce', 'nonce');
        $table = sanitize_text_field($_POST['table']);
        $wpdb->query("OPTIMIZE TABLE $table");
        wp_send_json_success(['message' => "$table optimized"]);
    }

    /** System Info **/
    public function system_info() {
        check_ajax_referer('devhub_nonce', 'nonce');
        global $wpdb;
        $info = [
            'PHP Version' => phpversion(),
            'WP Version' => get_bloginfo('version'),
            'Theme' => wp_get_theme()->get('Name'),
            'Active Plugins' => count(get_option('active_plugins')),
            'Memory Limit' => ini_get('memory_limit'),
            'Max Execution Time' => ini_get('max_execution_time') . 's',
            'DB Size' => size_format($wpdb->get_var("SELECT SUM(data_length + index_length) FROM information_schema.TABLES WHERE table_schema = '{$wpdb->dbname}'"))
        ];
        wp_send_json_success(['info' => $info]);
    }

    /** Maintenance **/
    public function toggle_maintenance() {
        check_ajax_referer('devhub_nonce', 'nonce');
        $enabled = get_option('devhub_maintenance', false);
        update_option('devhub_maintenance', !$enabled);
        wp_send_json_success(['message' => !$enabled ? 'Maintenance mode enabled' : 'Maintenance mode disabled']);
    }

    public function force_logout() {
        check_ajax_referer('devhub_nonce', 'nonce');
        $users = get_users();
        foreach ($users as $user) {
            wp_destroy_current_session();
        }
        wp_send_json_success(['message' => 'All users logged out']);
    }
}
