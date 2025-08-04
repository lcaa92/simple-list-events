<?php

namespace responses;

abstract class Response
{
    protected string $content;
    protected int $statusCode;
    protected array $headers = [];

    public function __construct(string $content, int $statusCode)
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send(): void
    {
        // Set the HTTP status code
        http_response_code($this->statusCode);

        // Set the headers
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        // Output the content
        echo $this->content;
    }
}