<?php

/**
 * Adds a media field to the category editor.
 *
 * This function displays a custom field in the category editor to allow
 * the selection of an image via the WordPress Media Library.
 *
 * @param WP_Term $tag The term object of the category being edited.
 * @return void
 */
function dahlia_features_add_category_image_field($tag) {
    // Retrieve the saved image ID, if available.
    $image = get_term_meta($tag->term_id, 'dahlia_category_image', true);
    $image_url = $image ? wp_get_attachment_url($image) : '';
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="dahlia-category-image"><?php _e('Category Image', 'dahlia-features'); ?></label>
        </th>
        <td>
            <!-- Preview of the selected image -->
            <div id="dahlia-category-image-selector" data-value="<?php echo esc_attr($image); ?>"></div>
            
            <!-- Hidden input to store the selected image ID -->
            <input type="hidden" name="dahlia_category_image" id="dahlia-category-image" value="<?php echo esc_attr($image); ?>" />
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'dahlia_features_add_category_image_field');

/**
 * Saves the selected image for the category.
 *
 * This function is triggered when a category is saved and updates
 * the term meta with the selected image ID.
 *
 * @param int $term_id The ID of the term being saved.
 * @return void
 */
function dahlia_features_save_category_image_field($term_id) {
    if (isset($_POST['dahlia_category_image'])) {
        // Save the image ID as term meta
        update_term_meta($term_id, 'dahlia_category_image', absint($_POST['dahlia_category_image']));
    }
}
add_action('edited_category', 'dahlia_features_save_category_image_field');

/**
 * Adds a new column to the category list table for the image.
 *
 * This function registers an additional column in the category
 * list table to display the image associated with each category.
 *
 * @param array $columns An associative array of column names.
 * @return array Updated array of column names.
 */
function dahlia_features_add_image_column($columns) {
    $columns['category_image'] = __('Image', 'dahlia-features');
    return $columns;
}
add_filter('manage_edit-category_columns', 'dahlia_features_add_image_column');

/**
 * Renders the image in the custom column of the category list table.
 *
 * This function displays the image associated with the category in the
 * new column added by `dahlia_features_add_image_column`.
 *
 * @param string $content The column content to display.
 * @param string $column_name The name of the column being rendered.
 * @param int $term_id The ID of the term being displayed.
 * @return string The content to display in the column.
 */
function dahlia_features_show_image_column($content, $column_name, $term_id) {
    if ('category_image' === $column_name) {
        // Retrieve the image ID saved for the term
        $image = get_term_meta($term_id, 'dahlia_category_image', true);
        if ($image) {
            // Get the URL of the image and render it
            $image_url = wp_get_attachment_url($image);
            if ($image_url) {
                $content = "<img src='" . esc_url($image_url) . "' alt='' style='width: 50px; height: auto;' />";
            }
        }
    }
    return $content;
}
add_filter('manage_category_custom_column', 'dahlia_features_show_image_column', 10, 3);