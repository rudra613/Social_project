<?php
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/post-validation.php';

//check validate token
add_action('rest_api_init', function () {
    register_rest_route('jwt-auth/v1', '/validate', array(
        'methods'  => 'GET',
        'callback' => function () {
            return new WP_REST_Response(array(
                'code' => 'jwt_auth_valid_token',
                'data' => array('status' => 200)
            ), 200);
        },
        'permission_callback' => function () {
            return is_user_logged_in();
        }
    ));
});
