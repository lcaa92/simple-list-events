<?php

use PHPUnit\Framework\TestCase;
use Controllers\HomeController;

class HomeControllerTest extends TestCase
{
    public function setUp(): void
    {
        $this->controller = new HomeController();
    }

    public function testIndexReturnsExpectedValue()
    {
        $result = $this->controller->index();
        $this->assertNotEmpty($result);
    }
}
