<?php

namespace App\Hooks\User;

class Api {
    public static function register_rest_route() : void {
        register_rest_route('app/v1', '/users', array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => self::get_user_data(...),
            'permission_callback' => function () {
                return true;
            }
        ));
    }

    public static function get_user_data(\WP_REST_Request $request) : \WP_REST_Response {
        $results = get_users();

        $response = array(
            'results' => array(),
            'count' => count_users(),
        );

        if($response['count'] === 0) {
            return rest_ensure_response($response);
        }

        foreach($results as $user_data) {
            $response['results'][] = array(
                'firstName' => $user_data->user_firstname,
                'lastName' => $user_data->user_lastname,
                'email' => $user_data->user_email,
                'roles' => '',
            );
        }

        $response['count'] = count_users();

        return rest_ensure_response($response);
    }
}