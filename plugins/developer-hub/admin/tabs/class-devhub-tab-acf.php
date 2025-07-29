<?php

class DevHub_Tab_ACF {

    public function __construct() {
        // No hooks needed yet (we're only displaying data)
    }

    /**
     * Render the ACF tab content
     */
    public function render_tab_content() { ?>
        <div class="tab-content" id="tab-acf">
            <h2>ACF Tools</h2>
            <p>Browse and debug ACF field groups and fields.</p>

            <?php if (!function_exists('acf_get_field_groups')): ?>
                <div class="notice notice-warning">
                    <p>ACF is not active. Install and activate Advanced Custom Fields to use this section.</p>
                </div>
            <?php else: ?>
                <?php $this->render_field_groups(); ?>
            <?php endif; ?>
        </div>
    <?php }

    /**
     * Render all field groups
     */
    private function render_field_groups() {
        $field_groups = acf_get_field_groups();

        if (empty($field_groups)): ?>
            <p>No ACF field groups found.</p>
            <?php return;
        endif; ?>

        <table class="widefat" id="acf-groups-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Key</th>
                    <th>Location</th>
                    <th>Fields</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($field_groups as $group): 
                    $fields = acf_get_fields($group['key']); ?>
                    <tr>
                        <td><?php echo esc_html($group['title']); ?></td>
                        <td><code><?php echo esc_html($group['key']); ?></code></td>
                        <td>
                            <?php
                            if (!empty($group['location'])) {
                                foreach ($group['location'] as $or) {
                                    foreach ($or as $rule) {
                                        echo esc_html($rule['param'] . ' ' . $rule['operator'] . ' ' . $rule['value']) . '<br>';
                                    }
                                }
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        <td><?php echo $fields ? count($fields) : 0; ?></td>
                        <td><?php echo isset($group['active']) && $group['active'] ? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <a class="button" href="<?php echo admin_url('post.php?post=' . $group['ID'] . '&action=edit'); ?>">Edit</a>
                            <button class="button view-fields" data-key="<?php echo esc_attr($group['key']); ?>">View Fields</button>
                            <button class="button export-group" data-key="<?php echo esc_attr($group['key']); ?>">Export PHP</button>
                        </td>
                    </tr>
                    <tr class="acf-fields-row" id="fields-<?php echo esc_attr($group['key']); ?>" style="display:none;">
                        <td colspan="6">
                            <?php $this->render_fields_table($fields); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php }

    /**
     * Render fields table for a group
     */
    private function render_fields_table($fields) {
        if (empty($fields)): ?>
            <p>No fields in this group.</p>
            <?php return;
        endif; ?>

        <table class="widefat">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Key</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fields as $field): ?>
                    <tr>
                        <td><?php echo esc_html($field['label']); ?></td>
                        <td><code><?php echo esc_html($field['name']); ?></code></td>
                        <td><?php echo esc_html($field['type']); ?></td>
                        <td><code><?php echo esc_html($field['key']); ?></code></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php }
}
