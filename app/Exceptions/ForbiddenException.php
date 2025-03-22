<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    /**
     * Create a new forbidden exception instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = 'The user does not have the permissions to perform this action.')
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
        return response()->json(['error' => 'forbidden', 'message' => $this->getMessage()], 403);
    }
} 