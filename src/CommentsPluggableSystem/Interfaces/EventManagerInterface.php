<?php

namespace CommentsPluggableSystem\Interfaces;

interface EventManagerInterface
{
    /**
     * Notify all observers about the Event
     *
     * @param string $eventName
     * @return void
     */
    public function fireEvent($eventName);

    /**
     * Attach observer, that will be fired on some event
     * Observer should have some execution priority but I have
     * skipped this option, replaced it with sorting by priority
     * field in table db.
     * Moreover Symfony EventDispatcher has the same functionality
     * with sorting observers (or observers) inside EventDispatcher.
     *
     * @param string $eventName The name of event
     * @param callable $observer The observer of some event (closure or class with __call() method)
     * @return void
     */
    public function addObserver($eventName, callable $observer);

    /**
     * Detach attached observer from event
     *
     * @param string $eventName
     * @param callable $observer The observer of some event (closure or class with __call() method)
     * @return void
     */
    public function removeObserver($eventName, callable $observer);

    /**
     * Get array of observers, bound with event name
     *
     * @param $eventName
     * @return array of callable observers
     */
    public function getObservers($eventName);
}
