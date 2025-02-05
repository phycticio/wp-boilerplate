<?php

if(!function_exists('app_validate_required')) {
    function app_validate_required($required_fields, $fields) : array {
        $success = true;
        $message = '';
        foreach ($required_fields as $key => $label) {
            if (empty($fields[$key])) {
                $success = false;
                if (is_array($label)) {
                    $message = $label['required'];
                    break;
                }
                $message = sprintf(__('The %s field is required.'), $label);
            }
        }
        return array(
            'success' => $success,
            'message' => $message,
        );
    }
}