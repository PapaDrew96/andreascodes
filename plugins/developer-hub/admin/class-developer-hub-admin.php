<?php
// Correctly include the CPT tab class file at the top
include_once plugin_dir_path(__FILE__) . 'tabs/class-devhub-tab-cpt.php';
include_once plugin_dir_path(__FILE__) . 'tabs/class-devhub-tab-acf.php';
include_once plugin_dir_path(__FILE__) . 'tabs/class-devhub-tab-visualizer.php';
include_once plugin_dir_path(__FILE__) . 'tabs/class-devhub-tab-assets.php';
include_once plugin_dir_path(__FILE__) . 'tabs/class-devhub-tab-tools.php';


class Developer_Hub_Admin {

    private $plugin_name;
    private $version;
    private $tabs = [];

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // Load tab classes
        $this->tabs['cpt'] = new DevHub_Tab_CPT();
        $this->tabs['acf'] = new DevHub_Tab_ACF();
        $this->tabs['visualizer'] = new DevHub_Tab_Visualizer();
        $this->tabs['assets'] = new DevHub_Tab_Assets();
        $this->tabs['tools'] = new DevHub_Tab_Tools();
    }

    public function add_admin_menu() {
        add_menu_page(
            __( 'Developer Hub', 'developer-hub' ),
            __( 'Developer Hub', 'developer-hub' ),
            'manage_options',
            'developer-hub',
            [ $this, 'render_developer_ui' ],
            'dashicons-admin-tools',
            3
        );
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'css/developer-hub-admin.css',
            [],
            $this->version,
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/developer-hub-admin.js',
            ['jquery'],
            $this->version,
            true
        );

        wp_localize_script($this->plugin_name, 'devHub', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('devhub_nonce')
        ]);

		wp_localize_script('devhub-tools', 'devHubTools', [
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('devhub_nonce')
		]);

    }

    public function render_developer_ui() { ?>
        <div class="wrap developer-hub-wrap">
            <h1>Developer Hub</h1>
            <?php $this->render_tabs_nav(); ?>
            <?php foreach ($this->tabs as $tab) {
                $tab->render_tab_content();
            } ?>
        </div>
    <?php }

    private function render_tabs_nav() { ?>
        <nav class="devhub-tabs">
            <a href="#" class="tab-link active" data-tab="cpt">CPT & Taxonomies</a>
            <a href="#" class="tab-link" data-tab="acf">ACF Tools</a>
            <a href="#" class="tab-link" data-tab="visualizer">Visualizer</a>
            <a href="#" class="tab-link" data-tab="assets">Assets</a>
            <a href="#" class="tab-link" data-tab="tools">Tools</a>
        </nav>
    <?php }
}
