<?php

namespace CommentsPluggableSystem\Events;

use CommentsPluggableSystem\Interfaces\EventInterface;

class SubmitEvent implements EventInterface
{
    const NAME = 'form.on_submit';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}