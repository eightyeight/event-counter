<?php

use MongoDB\Client;
use EventCounter\EventCounter;

class EventCounterTest extends PHPUnit_Framework_TestCase
{
    public function testCounter()
    {
        $collection = (new Client())->events_counter->events;
        $collection->drop();

        $collection->insertMany([
            [
                'event_ts' => strtotime('-1 second')
            ],
            [
                'event_ts' => strtotime('-1 minute')
            ],
            [
                'event_ts' => strtotime('-1 hour')
            ],
        ]);

        $counter = new EventCounter();

        $this->assertEquals(1, $counter->countLastMinuteEvents());
        $this->assertEquals(2, $counter->countLastHourEvents());
        $this->assertEquals(3, $counter->countLastDayEvents());
    }

    public function testCounterRuntime()
    {
        $collection = (new Client())->events_counter->events;
        $collection->drop();

        $counter = new EventCounter();

        $startTime = microtime(true);

        for($i = 0; $i < 10000; $i++) {
            $counter->eventTriggered();
        }

        $endTime = $startTime - microtime(true);

        $this->assertLessThanOrEqual(1, $endTime);
    }
}
