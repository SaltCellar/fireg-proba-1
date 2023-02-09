<?php
namespace App\Helpers;
class Response {

    public static function modelNotExistError(string $name = null) : array {
        return [
            'error' => true,
            'error_message' => ( $name ? : '' ) . 'Model not found on ID!',
        ];
    }

}
