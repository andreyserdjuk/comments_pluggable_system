<?php

namespace CommentsPluggableSystem\Interfaces;

/**
 * Interface CommentSubjectInterface
 *
 * Post, photo, video or another subject, that can be commented
 * Commented subject should implement this interface to identify own comments
 */
interface CommentSubjectInterface
{
    /**
     * Unique id of Comment's subject (id of the post, video, photo etc.)
     *
     * @return int|string
     */
    public function getSubjectId();

    /**
     * Unique id of Subject's table - prevent id's conflict in comment's table
     *
     * @return int
     */
    public function getTableId();
}