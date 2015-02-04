<?php

namespace CommentsPluggableSystem\Interfaces;

interface CommentInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getAuthor();

    public function setAuthor($author);

    public function getContent();

    public function setContent($body);

    public function getDateTime();

    public function setDateTime(\DateTime $dateTime);

    public function getStatus();

    public function setStatus($status);
}