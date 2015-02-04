<?php

namespace CommentsPluggableSystem\Interfaces;

interface SubjectInterface
{
    /**
     * Notify all observers
     * @return void
     */
    public function notify();

    public function attach(\SplObserver $observer);

    public function detach(\SplObserver $observer);
}