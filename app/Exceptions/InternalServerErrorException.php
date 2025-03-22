<?php

namespace App\Exceptions;

use Exception;

class InternalServerErrorException extends Exception
{
    /**
     * Create a new internal server error exception instance.
     *
     * @param  string  $message
     * @param  array  $trace
     * @return void
     */
    public function __construct($message = 'Internal server error.', $trace = null)
    {
        $this->trace = $trace;
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
        if(isset($this->trace)) {
            return response()->json(['error' => 'internal_server_error', 'message' => $this->getMessage(), 'trace' => $this->trace], 500);
        }
        else {
            return response()->json(['error' => 'internal_server_error', 'message' => $this->getMessage()], 500);
        }
    }
} 