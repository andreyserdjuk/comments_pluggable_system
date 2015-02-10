<?php

namespace CommentsPluggableSystem;

use CommentsPluggableSystem\Interfaces\CommentInterface;

class Comment implements CommentInterface
{
    const STATUS_PENDING = 1;
    const STATUS_CONFIRMED = 2;

    const API_KEY_ID = 'comment_id';
    const API_KEY_TITLE = 'comment_title';
    const API_KEY_AUTHOR = 'comment_author';
    const API_KEY_CONTENT = 'comment_body';
    const API_KEY_DATE = 'comment_date';
    const API_KEY_STATUS = 'comment_status';

    const DB_KEY_ID = 'id';
    const DB_KEY_SUBJECT_ID = 'subject_id';
    const DB_KEY_TABLE_ID = 'table_id';
    const DB_KEY_TITLE = 'title';
    const DB_KEY_AUTHOR = 'author';
    const DB_KEY_CONTENT = 'content';
    const DB_KEY_TIMESTAMP = 'created_at';
    const DB_KEY_STATUS = 'status';

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $tableId;

    /**
     * @var
     */
    private $subjectId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $dateTime;

    /**
     * @var int
     */
    private $status;


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return new \DateTime('@' . $this->dateTime);
    }

    public function setDateTime(\DateTime $dateTime)
    {
        /** @var int dateTime */
        $this->dateTime = $dateTime->getTimestamp();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * @param int $tableId
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }

    /**
     * @return mixed
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    /**
     * @param mixed $subjectId
     */
    public function setSubjectId($subjectId)
    {
        $this->subjectId = $subjectId;
    }

    /*public static function extractPostData($postData)
    {
        if (isset($postData[self::API_KEY_AUTHOR])
            && isset($postData[self::API_KEY_TITLE])
            && isset($postData[self::API_KEY_CONTENT])
        ) {
            return [
                self::API_KEY_AUTHOR => $postData[self::API_KEY_AUTHOR],
                self::API_KEY_TITLE => $postData[self::API_KEY_TITLE],
                self::API_KEY_CONTENT => $postData[self::API_KEY_CONTENT],
            ];
        }
    }*/
}