<?php

namespace App\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    /**
     * Create a new bad request exception instance.
     *
     * @param  string|array  $messages
     * @return void
     */
    public function __construct($messages = ['Bad request.'])
    {
        $this->messages = is_array($messages) && count($messages) === 1 ? array_slice($messages, 0, 1) : $messages;
        parent::__construct('Bad request.');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json(['error' => 'bad_request', 'message' => $this->messages], 400);
    }
} 