<?php

namespace App\Exceptions;

use Exception;

class ApplicaitonHeaderException extends Exception
{
    /**
     * Create a new applicaiton header exception instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = 'The Accept: application/json header is required for this API.')
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
        return response()->json(['error' => 'header_applicaiton_header', 'message' => $this->getMessage()], 406);
    }
} 