<?php

namespace CommentsPluggableSystem\CommentSystemUseCase;

use CommentsPluggableSystem\Interfaces\CommentSubjectInterface;

class Post implements CommentSubjectInterface
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
