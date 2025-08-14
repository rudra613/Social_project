<?php
/*
Plugin Name: Protect Posts with JWT
Description: Restrict WP REST API post access to only authenticated users with JWT.
Version: 1.0
*/

add_filter('rest_authentication_errors', function ($result) {
    if (!empty($result)) {
        return $result;
    }

   
    $protected_routes = [
        '/wp/v2/posts',
        '/wp/v2/posts/',
    ];

    $path = $_SERVER['REQUEST_URI'];
    foreach ($protected_routes as $route) {
        if (strpos($path, $route) !== false) {
            if (!is_user_logged_in()) {
                return new WP_Error('jwt_missing', 'JWT token required', ['status' => 403]);
            }
        }
    }

    return $result;
});
