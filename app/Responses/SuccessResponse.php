<?php

namespace App\Responses;

class SuccessResponse extends Response
{
    public function __construct(string $content)
    {
        parent::__construct($content, 200);
    }
}