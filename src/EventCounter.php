<?php 

namespace EventCounter;

use MongoDB\Client;

/**
 * Class EventCounter
 * @package EventCounter
 */
class EventCounter implements EventCounterInterface
{
    /**
     * @inheritdoc
     */
    public function eventTriggered()
    {
        $collection = $this->getCollection();
        $collection->insertOne([
            'event_ts' => time()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function countLastMinuteEvents(): int
    {
        $lastMinuteTs = strtotime("-1 minute");

        return $this->getEventsCount($lastMinuteTs);
    }

    /**
     * @inheritdoc
     */
    public function countLastHourEvents(): int
    {
        $lastMinuteTs = strtotime("-1 hour");

        return $this->getEventsCount($lastMinuteTs);
    }

    /**
     * @inheritdoc
     */
    public function countLastDayEvents(): int
    {
        $lastMinuteTs = strtotime("-1 day");

        return $this->getEventsCount($lastMinuteTs);
    }

    /**
     * @return \MongoDB\Collection
     */
    private function getCollection()
    {
        return (new Client())->events_counter->events;
    }

    /**
     * @param int $timestamp
     * @return int
     */
    private function getEventsCount(int $timestamp): int
    {
        $collection = $this->getCollection();

        $result = $collection->count([
            'event_ts' => [
                '$gt' => $timestamp
            ]
        ]);

        return $result;
    }
}