<?php

namespace CommentsPluggableSystem;

use CommentsPluggableSystem\Interfaces\CommentsTemplatePresenterInterface;

class CommentsTemplatePresenter extends BaseTemplate implements CommentsTemplatePresenterInterface
{
    /**
     * @var array
     */
    private $comments;

    /**
     * @var string
     */
    private $templateName;


    public function __construct($templatePath=null, $templateName=null)
    {
        parent::__construct($templatePath);
        $this->templateName = $templateName? $templateName : 'display_comments.php';
    }

    /**
     * @param array $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }


    protected function getTemplateName()
    {
        return $this->templateName;
    }
}