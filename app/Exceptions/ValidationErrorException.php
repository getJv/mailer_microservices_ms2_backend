<?php

namespace App\Exceptions;

use Exception;

class ValidationErrorException extends Exception
{

    public function render($request)
    {
        return response()->json([
            'errors' => [
                'code'  => 422,
                'title' => 'Validation Error',
                'detail' => 'Invalid or missing parameters',
                'meta' => json_decode($this->getMessage())
            ]
        ], 422);
    }
}
