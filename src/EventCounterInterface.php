<?php

namespace EventCounter;

/**
 * Interface EventCounterInterface
 * @package EventCounter
 */
interface EventCounterInterface
{
    /**
     * @return void
     */
    public function eventTriggered();

    /**
     * @return int
     */
    public function countLastMinuteEvents(): int;

    /**
     * @return int
     */
    public function countLastHourEvents(): int;

    /**
     * @return int
     */
    public function countLastDayEvents(): int;
}