<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;
use App\Responses\SuccessResponse;

class HomeControllerTest extends TestCase
{
    public function setUp(): void
    {
        $this->controller = new HomeController();
    }

    public function testIndexReturnsExpectedValue()
    {
        $result = $this->controller->index();
        $this->assertInstanceOf(SuccessResponse::class, $result);
        $this->assertNotEmpty($result);
    }
}
