<?php
/*
Plugin Name: Precios por Ciudad - Paraguay
Description: Plugin que muestra precios correspondientes a ciudades de Paraguay en WooCommerce.
Version: 1.0
Author: Hector
*/

// Agregar campo de selección de ciudad en la página de edición de producto
function precios_ciudad_product_field() {
    $ciudades = obtener_ciudades_paraguay();

    echo '<div class="options_group">';
    woocommerce_wp_select(
        array(
            'id'          => 'ciudad_producto',
            'label'       => 'Ciudad',
            'description' => 'Seleccione la ciudad para agregar el precio correspondiente.',
            'options'     => $ciudades,
        )
    );
    echo '</div>';
}
add_action('woocommerce_product_options_pricing', 'precios_ciudad_product_field');

// Agregar campo de precio adicional para cada ciudad en la página de edición de producto
function precios_ciudad_precio_adicional_field() {
    global $post;

    $ciudades = obtener_ciudades_paraguay();
    $precios_adicionales = get_post_meta($post->ID, 'precios_adicionales', true);

    echo '<div class="options_group">';
    foreach ($ciudades as $ciudad_key => $ciudad) {
        $precio_adicional = isset($precios_adicionales[$ciudad_key]) ? floatval($precios_adicionales[$ciudad_key]) : '';
        woocommerce_wp_text_input(
            array(
                'id'          => 'precio_adicional[' . $ciudad_key . ']',
                'label'       => 'Precio Adicional para ' . $ciudad,
                'placeholder' => 'Ingrese el precio adicional',
                'desc_tip'    => 'true',
                'description' => 'Este precio se sumará al precio base del producto para la ciudad seleccionada.',
                'type'        => 'number',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min'  => '0',
                ),
                'value'       => $precio_adicional,
            )
        );
    }
    echo '</div>';
}
add_action('woocommerce_product_options_pricing', 'precios_ciudad_precio_adicional_field');

// Guardar el precio adicional para cada ciudad al guardar el producto
function precios_ciudad_save_product($product_id) {
    $ciudades = obtener_ciudades_paraguay();
    $precios_adicionales = array();

    foreach ($ciudades as $ciudad_key => $ciudad) {
        $precio_adicional = isset($_POST['precio_adicional'][$ciudad_key]) ? wc_clean(wp_unslash($_POST['precio_adicional'][$ciudad_key])) : '';

        if (!empty($precio_adicional)) {
            $precios_adicionales[$ciudad_key] = $precio_adicional;
        }
    }

    update_post_meta($product_id, 'precios_adicionales', $precios_adicionales);
}
add_action('woocommerce_process_product_meta', 'precios_ciudad_save_product');



// Mostrar el precio correspondiente a la ciudad seleccionada en la página de producto
function precios_ciudad_display_product() {
    global $product;

    $ciudad_cliente = obtener_ciudad_geolocalizacion();
    $precios_adicionales = get_post_meta($product->get_id(), 'precios_adicionales', true);
    $precio_adicional = isset($precios_adicionales[$ciudad_cliente]) ? floatval($precios_adicionales[$ciudad_cliente]) : '';

    if (!empty($ciudad_cliente) && !empty($precio_adicional)) {
        WC()->session->set('precio_adicional', $precio_adicional); // Guardar el precio adicional en la sesión

        echo '<div class="precio-adicional">';
        echo '<strong>Precio para ' . $ciudad_cliente . ':</strong> ' . wc_price($precio_adicional);
        echo '</div>';
    }
}

// Ocultar el precio normal y mostrar solo el precio adicional correspondiente a la ciudad
function precios_ciudad_hide_prices() {
    global $product;

    $ciudad_cliente = obtener_ciudad_geolocalizacion();
    $precio_adicional_session = WC()->session->get('precio_adicional');

    if (!empty($ciudad_cliente) && !empty($precio_adicional_session)) {
        echo '<style>';
        echo '.price { display: none; }'; // Ocultar el precio normal
        echo '.precio-adicional { display: block !important; }'; // Mostrar el precio adicional
        echo '</style>';
    }
}

// Ocultar el precio y mostrar el precio adicional si la ciudad coincide
add_filter('woocommerce_get_price_html', 'ocultar_precio_y_mostrar_precio_adicional', 10, 2);
function ocultar_precio_y_mostrar_precio_adicional($price, $product) {
    $ciudad_cliente = obtener_ciudad_geolocalizacion();
    $precios_adicionales = get_post_meta($product->get_id(), 'precios_adicionales', true);
    $precio_adicional = isset($precios_adicionales[$ciudad_cliente]) ? floatval($precios_adicionales[$ciudad_cliente]) : '';

    if (!empty($ciudad_cliente) && !empty($precio_adicional)) {
        $nuevo_precio =  $precio_adicional;
        return wc_price($nuevo_precio);
    } else {
        return $price; // Mostrar el precio normal si no hay precio adicional para la ciudad
    }
}

// Utilizar el precio adicional al agregar al carrito
add_action('woocommerce_before_calculate_totals', 'utilizar_precio_adicional_en_carrito');
function utilizar_precio_adicional_en_carrito($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $ciudad_cliente = obtener_ciudad_geolocalizacion();
        $precios_adicionales = get_post_meta($product->get_id(), 'precios_adicionales', true);
        $precio_adicional = isset($precios_adicionales[$ciudad_cliente]) ? floatval($precios_adicionales[$ciudad_cliente]) : '';

        if (!empty($ciudad_cliente) && !empty($precio_adicional)) {
            $nuevo_precio =  $precio_adicional;
            $cart_item['data']->set_price($nuevo_precio);
        }
    }
}

// Obtener las ciudades de Paraguay
function obtener_ciudades_paraguay() {
    // Aquí puedes implementar la lógica para obtener las ciudades de Paraguay.
    // Por simplicidad, aquí se muestra un ejemplo con algunas ciudades.

    $ciudades = array(
        'Asunción' => 'Asunción',
        'Ciudad del Este' => 'Ciudad del Este',
        'Encarnación' => 'Encarnación',
        'Luque' => 'Luque',
        'San Lorenzo' => 'San Lorenzo',
        'Lambaré' => 'Lambaré',
        'Fernando de la Mora' => 'Fernando de la Mora',
        'Capiatá' => 'Capiatá',
        'Mariano Roque Alonso' => 'Mariano Roque Alonso',
        'Ñemby' => 'Ñemby',
        'Villa Elisa' => 'Villa Elisa',
        'Itauguá' => 'Itauguá',
        'Limpio' => 'Limpio',
        'Caaguazú' => 'Caaguazú',
        'Pedro Juan Caballero' => 'Pedro Juan Caballero',
    );

    return $ciudades;
}

// Obtener la ciudad geolocalizada del cliente en Paraguay utilizando la base de datos GeoLite2-City de MaxMind
function obtener_ciudad_geolocalizacion() {
    $ip = $_SERVER['REMOTE_ADDR'];
    //$database = '/home/propuestagrafica/public_html/mielhome/wp-content/uploads/GeoLite2-City.mmdb';
    // Obtener la ruta del directorio de contenido (wp-content)
    $uploads_dir = wp_upload_dir();
    $uploads_path = $uploads_dir['basedir'];

    // Nombre del archivo GeoLite2-City.mmdb
    $filename = 'GeoLite2-City.mmdb';

    // Construir la ruta completa del archivo
    $database = $uploads_path . '/' . $filename;

    if (class_exists('GeoIp2\Database\Reader')) {
        try {
            $reader = new GeoIp2\Database\Reader($database);
            $record = $reader->city($ip);

            if ($record && isset($record->country->isoCode) && $record->country->isoCode === 'PY') {
                return $record->city->name;
            }
        } catch (Exception $e) {
            // Manejar cualquier error que ocurra al leer la base de datos
        }
    }

    return '';
}
