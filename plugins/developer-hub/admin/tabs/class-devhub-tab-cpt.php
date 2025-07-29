<?php

class DevHub_Tab_CPT {

    public function __construct() {
        // Hooks
        add_action('init', [$this, 'register_cpts_and_taxonomies']);
        add_action('wp_ajax_devhub_save_cpt', [$this, 'save_cpt']);
        add_action('wp_ajax_devhub_save_taxonomy', [$this, 'save_taxonomy']);
    }

    /**
     * Render the entire CPT & Taxonomies tab
     */
    public function render_tab_content() { ?>
        <div class="tab-content active" id="tab-cpt">
            <h2>CPT & Taxonomies Manager</h2>

            <nav class="sub-tabs">
                <a href="#" class="sub-tab-link active" data-subtab="cpts">Custom Post Types</a>
                <a href="#" class="sub-tab-link" data-subtab="taxonomies">Taxonomies</a>
                <a href="#" class="sub-tab-link" data-subtab="code">Code Generator</a>
            </nav>

            <!-- CPT Section -->
            <div class="sub-tab-content active" id="subtab-cpts">
                <div class="cpt-form-container">
                    <h3>Register New Custom Post Type</h3>
                    <?php $this->render_cpt_form(); ?>
                </div>
                <div class="cpt-list-container">
                    <h3>Existing Custom Post Types</h3>
                    <?php $this->render_cpt_table(); ?>
                </div>
            </div>

            <!-- Taxonomy Section -->
            <div class="sub-tab-content" id="subtab-taxonomies">
                <div class="tax-form-container">
                    <h3>Register New Taxonomy</h3>
                    <?php $this->render_taxonomy_form(); ?>
                </div>
                <div class="tax-list-container">
                    <h3>Existing Taxonomies</h3>
                    <?php $this->render_taxonomy_table(); ?>
                </div>
            </div>

            <!-- Code Generator Section -->
            <div class="sub-tab-content" id="subtab-code">
                <h3>Code Generator</h3>
                <div id="generated-code-container">
                    <p>Select a CPT or Taxonomy to view the code.</p>
                </div>
            </div>
        </div>
    <?php }

    /**
     * Render CPT registration form
     */
    private function render_cpt_form() { ?>
        <form id="devhub-cpt-form">
            <table class="form-table">
                <tr>
                    <th><label for="cpt_name">Name (Plural)</label></th>
                    <td><input type="text" id="cpt_name" name="cpt_name" required /></td>
                </tr>
                <tr>
                    <th><label for="cpt_singular">Name (Singular)</label></th>
                    <td><input type="text" id="cpt_singular" name="cpt_singular" required /></td>
                </tr>
                <tr>
                    <th><label for="cpt_slug">Slug</label></th>
                    <td><input type="text" id="cpt_slug" name="cpt_slug" required /></td>
                </tr>
                <tr>
                    <th>Visibility</th>
                    <td>
                        <label><input type="checkbox" name="public" value="1" checked /> Public</label><br>
                        <label><input type="checkbox" name="show_ui" value="1" checked /> Show in admin</label><br>
                        <label><input type="checkbox" name="show_in_menu" value="1" checked /> Show in menu</label>
                    </td>
                </tr>
                <tr>
                    <th>Supports</th>
                    <td>
                        <label><input type="checkbox" name="supports[]" value="title" checked /> Title</label>
                        <label><input type="checkbox" name="supports[]" value="editor" checked /> Editor</label>
                        <label><input type="checkbox" name="supports[]" value="thumbnail" /> Thumbnail</label>
                        <label><input type="checkbox" name="supports[]" value="excerpt" /> Excerpt</label>
                        <label><input type="checkbox" name="supports[]" value="custom-fields" /> Custom Fields</label>
                    </td>
                </tr>
                <tr>
                    <th>Archives & Rewrite</th>
                    <td>
                        <label><input type="checkbox" name="has_archive" value="1" checked /> Has archive</label><br>
                        <label>Archive slug: <input type="text" name="archive_slug" /></label><br>
                        <label>Rewrite slug: <input type="text" name="rewrite_slug" /></label><br>
                        <label><input type="checkbox" name="rewrite_with_front" value="1" checked /> With front</label>
                    </td>
                </tr>
                <tr>
                    <th>REST API</th>
                    <td>
                        <label><input type="checkbox" name="show_in_rest" value="1" checked /> Show in REST API</label>
                    </td>
                </tr>
            </table>
            <p><button type="submit" class="button button-primary">Save Custom Post Type</button></p>
        </form>
    <?php }

    /**
     * Render CPT list table
     */
    private function render_cpt_table() {
        // Fetch all CPTs
        $all_cpts = get_post_types([], 'objects');
        $devhub_cpts = get_option('devhub_cpts', []);

        ?>
        <div class="cpt-filter-bar" style="margin-bottom: 10px;">
            <label><input type="radio" name="cpt_filter" value="all" checked> All</label>
            <label><input type="radio" name="cpt_filter" value="core"> Core</label>
            <label><input type="radio" name="cpt_filter" value="external"> External</label>
            <label><input type="radio" name="cpt_filter" value="devhub"> DevHub</label>
        </div>

        <table class="widefat" id="cpt-table">
            <thead>
                <tr>
                    <th>Name</th><th>Slug</th><th>Public</th><th>Has Archive</th><th>REST</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_cpts as $slug => $post_type): 
                    $is_core = in_array($slug, ['post', 'page', 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'wp_block', 'wp_template', 'wp_template_part']);
                    $is_devhub = isset($devhub_cpts[$slug]);
                    ?>
                    <tr 
                        data-type="<?php 
                            echo $is_core ? 'core' : ($is_devhub ? 'devhub' : 'external'); 
                        ?>">
                        <td><?php echo esc_html($post_type->labels->name); ?></td>
                        <td><?php echo esc_html($slug); ?></td>
                        <td><?php echo $post_type->public ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $post_type->has_archive ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $post_type->show_in_rest ? 'Yes' : 'No'; ?></td>
                        <td>
                            <?php if ($is_devhub): ?>
                                <button class="button view-code" data-slug="<?php echo esc_attr($slug); ?>">View Code</button>
                                <button class="button delete-cpt" data-slug="<?php echo esc_attr($slug); ?>">Delete</button>
                            <?php else: ?>
                                <span class="description"><?php echo $is_core ? 'Core' : 'External'; ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }



    
        /**
     * Render Taxonomy registration form
     */
    private function render_taxonomy_form() { 
        $cpts = get_post_types([], 'objects'); ?>
        <form id="devhub-tax-form">
            <table class="form-table">
                <tr>
                    <th><label for="tax_name">Name (Plural)</label></th>
                    <td><input type="text" id="tax_name" name="tax_name" required /></td>
                </tr>
                <tr>
                    <th><label for="tax_singular">Name (Singular)</label></th>
                    <td><input type="text" id="tax_singular" name="tax_singular" required /></td>
                </tr>
                <tr>
                    <th><label for="tax_slug">Slug</label></th>
                    <td><input type="text" id="tax_slug" name="tax_slug" required /></td>
                </tr>
                <tr>
                    <th>Attach to CPTs</th>
                    <td>
                        <?php foreach ($cpts as $cpt): ?>
                            <label><input type="checkbox" name="object_type[]" value="<?php echo esc_attr($cpt->name); ?>" /> <?php echo esc_html($cpt->labels->name); ?></label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <th>Options</th>
                    <td>
                        <label><input type="checkbox" name="public" value="1" checked /> Public</label><br>
                        <label><input type="checkbox" name="hierarchical" value="1" /> Hierarchical</label><br>
                        <label><input type="checkbox" name="show_ui" value="1" checked /> Show in admin</label>
                    </td>
                </tr>
                <tr>
                    <th>Rewrite & REST</th>
                    <td>
                        <label>Rewrite slug: <input type="text" name="rewrite_slug" /></label><br>
                        <label><input type="checkbox" name="show_in_rest" value="1" checked /> Show in REST API</label>
                    </td>
                </tr>
            </table>
            <p><button type="submit" class="button button-primary">Save Taxonomy</button></p>
        </form>
    <?php }

    /**
     * Render Taxonomy list table
     */
    private function render_taxonomy_table() {
        $all_taxonomies = get_taxonomies([], 'objects');
        $devhub_taxonomies = get_option('devhub_taxonomies', []);

        ?>
        <div class="tax-filter-bar" style="margin-bottom: 10px;">
            <label><input type="radio" name="tax_filter" value="all" checked> All</label>
            <label><input type="radio" name="tax_filter" value="core"> Core</label>
            <label><input type="radio" name="tax_filter" value="external"> External</label>
            <label><input type="radio" name="tax_filter" value="devhub"> DevHub</label>
        </div>

        <table class="widefat" id="tax-table">
            <thead>
                <tr>
                    <th>Name</th><th>Slug</th><th>Hierarchical</th><th>Associated CPTs</th><th>Public</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_taxonomies as $slug => $taxonomy): 
                    $is_core = in_array($slug, ['category', 'post_tag', 'nav_menu', 'link_category']);
                    $is_devhub = isset($devhub_taxonomies[$slug]);
                    ?>
                    <tr 
                        data-type="<?php 
                            echo $is_core ? 'core' : ($is_devhub ? 'devhub' : 'external'); 
                        ?>">
                        <td><?php echo esc_html($taxonomy->labels->name); ?></td>
                        <td><?php echo esc_html($slug); ?></td>
                        <td><?php echo $taxonomy->hierarchical ? 'Yes' : 'No'; ?></td>
                        <td><?php echo !empty($taxonomy->object_type) ? implode(', ', $taxonomy->object_type) : '-'; ?></td>
                        <td><?php echo $taxonomy->public ? 'Yes' : 'No'; ?></td>
                        <td>
                            <?php if ($is_devhub): ?>
                                <button class="button view-code" data-slug="<?php echo esc_attr($slug); ?>">View Code</button>
                                <button class="button delete-tax" data-slug="<?php echo esc_attr($slug); ?>">Delete</button>
                            <?php else: ?>
                                <span class="description"><?php echo $is_core ? 'Core' : 'External'; ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }



    /**
     * Save CPT via AJAX
     */
    public function save_cpt() {
        check_ajax_referer('devhub_nonce', 'nonce');

        $cpts = get_option('devhub_cpts', []);
        $slug = sanitize_key($_POST['cpt_slug']);
        $cpts[$slug] = $_POST;
        update_option('devhub_cpts', $cpts);

        wp_send_json_success(['message' => 'CPT saved successfully!']);
    }

    /**
     * Save Taxonomy via AJAX
     */
    public function save_taxonomy() {
        check_ajax_referer('devhub_nonce', 'nonce');

        $taxes = get_option('devhub_taxonomies', []);
        $slug = sanitize_key($_POST['tax_slug']);
        $taxes[$slug] = $_POST;
        update_option('devhub_taxonomies', $taxes);

        wp_send_json_success(['message' => 'Taxonomy saved successfully!']);
    }

    /**
     * Auto-register saved CPTs and Taxonomies
     */
    public function register_cpts_and_taxonomies() {
        $cpts = get_option('devhub_cpts', []);
        foreach ($cpts as $slug => $args) {
            register_post_type($slug, [
                'label' => $args['cpt_name'],
                'labels' => ['singular_name' => $args['cpt_singular']],
                'public' => isset($args['public']),
                'show_ui' => isset($args['show_ui']),
                'show_in_menu' => isset($args['show_in_menu']),
                'supports' => $args['supports'] ?? [],
                'has_archive' => isset($args['has_archive']),
                'rewrite' => [
                    'slug' => $args['rewrite_slug'] ?? $slug,
                    'with_front' => isset($args['rewrite_with_front'])
                ],
                'show_in_rest' => isset($args['show_in_rest'])
            ]);
        }

        $taxes = get_option('devhub_taxonomies', []);
        foreach ($taxes as $slug => $args) {
            register_taxonomy($slug, $args['object_type'] ?? [], [
                'label' => $args['tax_name'],
                'labels' => ['singular_name' => $args['tax_singular']],
                'public' => isset($args['public']),
                'hierarchical' => isset($args['hierarchical']),
                'show_ui' => isset($args['show_ui']),
                'rewrite' => ['slug' => $args['rewrite_slug'] ?? $slug],
                'show_in_rest' => isset($args['show_in_rest'])
            ]);
        }
    }
}
