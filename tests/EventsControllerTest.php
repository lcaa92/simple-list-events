<?php

use PHPUnit\Framework\TestCase;
use Controllers\EventsController;
use Responses\SuccessResponse;

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
