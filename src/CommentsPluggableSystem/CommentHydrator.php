<?php

namespace CommentsPluggableSystem;

class CommentHydrator
{
    /**
     * @param $data
     * @return Comment
     */
    public static function fetchObject($data)
    {
        $comments = [];

        foreach ($data as $row) {
            $comment = new Comment();
            $comment->setId($row[Comment::DB_KEY_ID]);
            $comment->setSubjectId($row[Comment::DB_KEY_SUBJECT_ID]);
            $comment->setTableId($row[Comment::DB_KEY_TABLE_ID]);
            $comment->setTitle($row[Comment::DB_KEY_TITLE]);
            $comment->setAuthor($row[Comment::DB_KEY_AUTHOR]);
            $comment->setContent($row[Comment::DB_KEY_CONTENT]);
            $comment->setDateTime(new \DateTime($row[Comment::DB_KEY_TIMESTAMP]));
            $comment->setStatus($row[Comment::DB_KEY_STATUS]);
            $comments[] = $comment;
        }

        return $comments;
    }
}