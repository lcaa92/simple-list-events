<?php

namespace App\Responses;

class ErrorResponse extends Response
{
    public function __construct(string $content, int $statusCode = 404)
    {
        parent::__construct($content, $statusCode);
    }
}