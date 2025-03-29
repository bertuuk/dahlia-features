<?php

// Agregar el campo del selector de iconos al editor de categorías
function dahlia_features_add_category_icon_field($tag) {
    // Obtener el valor guardado (si existe)
    $icon = get_term_meta($tag->term_id, 'dahlia_category_icon', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="dahlia-category-icon"><?php _e('Category Icon', 'dahlia-features'); ?></label>
        </th>
        <td>
            <div id="dahlia-category-icon-selector" 
                 data-term-id="<?php echo esc_attr($tag->term_id); ?>" 
                 data-icon="<?php echo esc_attr($icon); ?>">
            </div>
            <input type="hidden" name="dahlia_category_icon" id="dahlia-category-icon" value="<?php echo esc_attr($icon); ?>" />
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'dahlia_features_add_category_icon_field');

// Guardar el valor del icono al guardar la categoría
function dahlia_features_save_category_icon_field($term_id) {
    if (isset($_POST['dahlia_category_icon'])) {
        update_term_meta($term_id, 'dahlia_category_icon', sanitize_text_field($_POST['dahlia_category_icon']));
    }
}
add_action('edited_category', 'dahlia_features_save_category_icon_field');

// Agregar una columna al listado de categorías para mostrar el icono
function dahlia_features_add_icon_column($columns) {
    $columns['category_icon'] = __('Icon', 'dahlia-features');
    return $columns;
}
add_filter('manage_edit-category_columns', 'dahlia_features_add_icon_column');

function dahlia_features_show_icon_column($content, $column_name, $term_id) {
    if ('category_icon' === $column_name) {
        $icon = get_term_meta($term_id, 'dahlia_category_icon', true);
        if ($icon) {
            $content = "<i class='dahlia-icon dahlia-{$icon}'></i>";
        }
    }
    return $content;
}
add_filter('manage_category_custom_column', 'dahlia_features_show_icon_column', 10, 3);
