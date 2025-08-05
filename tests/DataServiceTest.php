<?php

use PHPUnit\Framework\TestCase;
use App\Services\DataService;

class DataServiceTest extends TestCase
{
    public function setUp(): void
    {
        $this->service = new DataService();
    }

    public function testLoadEventsPopulatesEventsArray()
    {
        $events = $this->service->getEvents();
        $this->assertIsArray($events);
        $this->assertNotEmpty($events);
        $this->assertArrayHasKey('event_name', $events[0]);
        $this->assertArrayHasKey('location', $events[0]);
        $this->assertArrayHasKey('address', $events[0]);
    }

    public function testGetEventsReturnsSingleEventById()
    {
        $events = $this->service->getEvents();
        $event = $this->service->getEvents(1);
        $this->assertEquals($events[0], $event);
    }

    public function testGetEventsNullForInvalidId()
    {
        $this->assertNull($this->service->getEvents(999));
    }

     public function testGetEventsWithNullReturnsAll()
    {
        $service = new DataService();
        $events = $service->getEvents(null);
        $this->assertIsArray($events);
        $this->assertNotEmpty($events);
    }

    public function testEmptyCsvReturnsEmptyArray()
    {
        $fileNameTest = __DIR__ . '/' . 'seeds_test.csv';
        file_put_contents($fileNameTest, '');
        $service = new DataService(
            csvFile: $fileNameTest
        );
        $events = $service->getEvents();
        $this->assertIsArray($events);
        unlink($fileNameTest);
    }
}
