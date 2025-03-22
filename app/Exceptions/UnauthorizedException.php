<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    /**
     * Create a new unauthorized exception instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = 'Unauthorized.')
    {
        parent::__construct($message);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json(['error' => 'unauthorized', 'message' => $this->getMessage()], 401);
    }
} 