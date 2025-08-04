<?php

namespace services;

/**
 * Class DataService
 *
 * Handles loading and retrieving event data from a CSV file.
 */
class DataService
{
    /**
     * @var array $events Array of events loaded from CSV.
     */
    protected $events = [];

    /**
     * DataService constructor.
     * Loads events from the CSV file on instantiation.
     */
    function __construct() {
        $this->loadEvents();
    }

    /**
     * Loads events from the seeds.csv file into the $events property.
     *
     * @return void
     */
    protected function loadEvents()
    {
        $file = fopen('seeds.csv', 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            $this->events[] = [
                'event_name'=> $line[0],
                'location' => $line[1],
                'address' => sprintf('%s %s', $line[2], $line[3])
            ];
        }
    }

    /**
     * Retrieves all events or a specific event by ID.
     *
     * @param int|null $id Optional event index.
     * @return array|mixed Returns all events if $id is null, otherwise returns the event at the given index or null if event does not exist;
     */
    public function getEvents(int $id = null): array|null
    {
        if(!isset($id)){
            return $this->events;
        }

        return $this->events[$id - 1];
    }
}