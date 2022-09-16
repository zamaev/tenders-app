<?php

namespace App\Exceptions;

use Exception;

class NotTenderFieldException extends Exception
{
    public function render($request)
    {
        if ($request->is('api/*')) {
            return response()->json([
                'message' => "Unknown field '{$this->getMessage()}'.",
            ], 406);
        }
    }
}
