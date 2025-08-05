<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\EventsController;
use App\Responses\SuccessResponse;

class EventsControllerTest extends TestCase
{
    public function setUp(): void
    {
        $this->controller = new EventsController();
    }

    public function testIndexReturnsEventsList()
    {
        $result = $this->controller->index();
        $this->assertInstanceOf(SuccessResponse::class, $result);
    }
}
