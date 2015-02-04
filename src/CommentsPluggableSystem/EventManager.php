<?php

namespace CommentsPluggableSystem;

use CommentsPluggableSystem\Interfaces\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    /**
     * @var array
     */
    protected $observers = [];


    /**
     * @see EventManagerInterface::fireEvent()
     * @param $eventName
     */
    public function fireEvent($eventName)
    {
        foreach ($this->getObservers($eventName) as $observer) {
            call_user_func($observer, $eventName, $this);
        }
    }

    /**
     * @see EventManagerInterface::getObservers()
     * @param string $eventName
     * @return array
     */
    public function getObservers($eventName)
    {
        return isset($this->observers[$eventName])? $this->observers[$eventName] : [];
    }

    /**
     * @see EventManagerInterface::addObserver()
     * @param string $eventName
     * @param callable $observer
     */
    public function addObserver($eventName, callable $observer)
    {
        $this->observers[$eventName][] = $observer;
    }

    /**
     * @see EventManagerInterface::removeObserver()
     * @param string $eventName
     * @param callable $observer
     */
    public function removeObserver($eventName, callable $observer)
    {
        $listeners = $this->getObservers($eventName);

        $key = array_search($observer, $listeners, true);
        if (false !== $key) {
            unset($this->observers[$eventName][$key]);
        }
    }
}
