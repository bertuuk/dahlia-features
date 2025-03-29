<?php
function dahlia_features_enqueue_admin_scripts($hook) {
     // Limita la carga del script a las páginas relevantes del administrador (por ejemplo, edición de términos).
     if (!in_array($hook, array('term.php', 'edit-tags.php'))) {
        return;
    }

    $icon_classes = array();

    // Verifica si el plugin contes-subscription está activo
    if (is_plugin_active('contes-subscription/contes-subscription.php')) {
        // Directorio de los iconos dentro del plugin contes-subscription
        $plugin_icon_path = WP_PLUGIN_DIR . '/contes-subscription/assets/icons/';

        if (is_dir($plugin_icon_path)) {
            $icon_files = array_diff(scandir($plugin_icon_path), array('.', '..')); // Ignorar directorios . y ..

            // Generar la lista de iconos basada en los nombres de archivo
            $icon_classes = array_map(function ($file) {
                return pathinfo($file, PATHINFO_FILENAME); // Usar el nombre del archivo sin extensión
            }, $icon_files);
        }
    } else {
        // Si el plugin no está activo, mostrar un mensaje de advertencia en el panel de administración
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p>';
            _e('El plugin "contes-subscription" no está activo. Algunos iconos pueden no estar disponibles.', 'dahlia-features');
            echo '</p></div>';
        });
    }

    // Encolar la biblioteca de medios de WordPress
    wp_enqueue_media();

    // Cargar el archivo JavaScript (React)
    wp_enqueue_script(
        'dahlia-features-main',
        plugins_url('build/main.dahliafeat.bundle.js', __DIR__),
        array('wp-element', 'wp-components', 'wp-data', 'wp-i18n'), // Dependencias de WordPress
        filemtime(plugin_dir_path(__DIR__) . 'build/main.dahliafeat.bundle.js'),
        true
    );

     // Obtener la imagen de la categoría para la previsualización
     $term_id = isset($_GET['tag_ID']) ? intval($_GET['tag_ID']) : 0;
     $image_id = get_term_meta($term_id, 'dahlia_category_image', true);
     $image_url = $image_id ? wp_get_attachment_url($image_id) : '';

    // Pasar datos de PHP a JS
    wp_localize_script('dahlia-features-main', 'dahliaFeatures', array(
        'icons' => $icon_classes, // Pasar las clases de los iconos al JS
        'imagePreview' => $image_url,
    ));

    // Cargar el archivo CSS
    wp_enqueue_style(
        'dahlia-features-main-styles',
        plugins_url('build/style.dahliafeat.bundle.css', __DIR__),
        array(),
        filemtime(plugin_dir_path(__DIR__) . 'build/style.dahliafeat.bundle.css')
    );
}
add_action('admin_enqueue_scripts', 'dahlia_features_enqueue_admin_scripts');

