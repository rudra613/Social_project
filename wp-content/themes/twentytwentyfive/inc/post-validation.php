<?php
function mytheme_enqueue_scripts() {
    wp_enqueue_script(
        'jwt-login-js',
        get_template_directory_uri() . '/assets/js/jwt-login.js',
        array('jquery'),
        '1.0',
        true
    );

    wp_localize_script('jwt-login-js', 'jwtData', array(
        'token_url' => home_url('/wp-json/jwt-auth/v1/token'),
        'posts_url' => home_url('/wp-json/wp/v2/posts'),
    ));
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');

//restrict direct access 
add_filter('rest_authentication_errors', function ($result) {
    if (!empty($result)) {
        return $result;
    }

    $route = $_SERVER['REQUEST_URI'];
    // Allow token endpoint for login
    if (strpos($route, '/wp-json/jwt-auth/v1/token') !== false) {
        return $result;
    }

    // Only allow if Authorization: Bearer ... header is present
    $headers = getallheaders();
    if (!isset($headers['Authorization']) || stripos($headers['Authorization'], 'Bearer ') !== 0) {
        return new WP_Error('jwt_auth_no_auth_header', 'Authorization header not found.', array('status' => 403));
    }

    return $result;
});

?>