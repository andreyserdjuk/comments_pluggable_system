<?php

class mockPDO extends PDO
{
    public function __construct()
    {}

    public function prepare($query)
    {
        return new Sth($query);
    }

    public function lastInsertId()
    {
        return 1;
    }
}

/**
 * Class Sth - PDOStatement stub
 */
class Sth
{
    private $currentQuery;

    private $fetchData = [
        'SELECT observer_name, event_name from observers ORDER BY event_name, observer_priority DESC' => [
            'CommentsPluggableSystem\Observers\SubmitValidatorObserver' => 'form.on_submit',
            'CommentsPluggableSystem\Observers\SubmitFilterObserver' => 'form.on_submit',
            'CommentsPluggableSystem\Observers\SubmitCreatorObserver' => 'form.on_submit',
            'CommentsPluggableSystem\Observers\SubmitSaverObserver' => 'form.on_submit'
        ],
        'SELECT * from comments where table_id = :table_id and subject_id = :subject_id' => [
            [
                'id' => 1,
                'subject_id' => 123,
                'table_id' => 1,
                'title' => 'Default title',
                'author' => 'Example author',
                'content' => 'I like comments',
                'created_at' => '2015-Feb-04 02:05:15',
                'status' => 1
            ],
            [
                'id' => 2,
                'subject_id' => 123,
                'table_id' => 1,
                'title' => 'Second title',
                'author' => 'Another author',
                'content' => 'I don\'t like comments',
                'created_at' => '2015-Feb-04 02:05:15',
                'status' => 2
            ]
        ],
        'SELECT smile_code, img_src from smileys' => [
            ':)' => 'smile1.jpg',
            ':(' => 'smile2.jpg',
            ';)' => 'smile3.jpg'
        ]
    ];


    public function __construct($query)
    {
        $this->currentQuery = $query;
    }

    public function execute()
    {}

    public function fetchAll()
    {
        return isset($this->fetchData[$this->currentQuery])? $this->fetchData[$this->currentQuery] : null;
    }

    public function bindValue()
    {}

    public function bindParam()
    {}
}


class Post implements \CommentsPluggableSystem\Interfaces\CommentSubjectInterface
{
    const TABLE_UNIQUE_ID = 1;

    /**
     * @var \CommentsPluggableSystem\Form
     */
    private $form;

    /**
     * @var int current Post record id
     */
    private $id;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSubjectId()
    {
        return $this->id;
    }

    /**
     * @see CommentSubjectInterface::getTableId()
     */
    public function getTableId()
    {
        return self::TABLE_UNIQUE_ID;
    }

    public function submitComment()
    {
        $this->form->submit($_POST);
    }

    public function getComments()
    {
        return $this->form->getComments();
    }
}
