<?php

namespace App\Responses;

class JsonResponse extends SuccessResponse
{
    public function __construct(string $content)
    {
        $this->setHeader('Content-Type', 'application/json');
        parent::__construct($content, 200);
    }
}