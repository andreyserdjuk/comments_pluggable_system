<?php

namespace CommentsPluggableSystem;
use CommentsPluggableSystem\Events\SubmitEvent;
use CommentsPluggableSystem\Exceptions\InvalidFormException;
use CommentsPluggableSystem\Interfaces\CommentInterface;
use CommentsPluggableSystem\Interfaces\CommentsTemplatePresenterInterface;
use CommentsPluggableSystem\Interfaces\CommentSubjectInterface;

/**
 * Class Form
 *
 * Display comments of CommentSubjectInterface and submit a new comment
 */
class Form extends EventManager
{
    use ForceSingletonTrait;

    const STATUS_BLANK = 1;
    const STATUS_VALID = 2;
    const STATUS_INVALID = 3;

    /**
     * Form validation status
     *
     * @var int
     */
    private $status = self::STATUS_BLANK;

    /**
     * @var array $_POST or custom array
     */
    private $postData;

    /**
     * @var Comment
     */
    private $newComment;

    /**
     * @var \PDO
     */
    private $dbh;

    /**
     * @var CommentSubjectInterface
     */
    private $commentSubject;

    /**
     * @var array of messages
     */
    private $errors = [];

    /**
     * @var CommentsTemplatePresenter
     */
    private $commentsTemplate;


    private $inputFormTemplate;

    /**
     * The Form instance can exist only with commented subject
     *
     * @param CommentSubjectInterface $commentSubject
     * @param \PDO $dbh database connection handle
     * @return Form
     */
    public static function init(CommentSubjectInterface $commentSubject, \PDO $dbh)
    {
        if (!self::$instance) {
            self::$instance = new self;
            self::$instance->commentSubject = $commentSubject;
            self::$instance->dbh = $dbh;
        }
        return self::$instance;
    }

    /**
     * Get initialized Form instance
     *
     * @return Form
     * @throw RuntimeException
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            throw new \RuntimeException('The Form class is not initialized yet.');
        }
        return self::$instance;
    }

    /**
     * Submit Form
     *
     * @param array $postData $_POST or custom array
     */
    public function submit($postData)
    {
        $this->postData = $postData;

        $this->loadObservers();

        try {
            $this->fireEvent(SubmitEvent::NAME);
        } catch(InvalidFormException $e) {

        }
    }

    public function handleSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->submit($_POST);
        }
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function setPostData($postData)
    {
        $this->postData = $postData;
    }

    /**
     * @return CommentInterface
     */
    public function getNewComment()
    {
        return $this->newComment;
    }

    public function setNewComment(CommentInterface $comment)
    {
        $this->newComment = $comment;
    }

    /**
     * @return array of Comment
     */
    public function getComments()
    {
        $sth = $this->dbh->prepare('SELECT * from comments where table_id = :table_id and subject_id = :subject_id ORDER BY created_at DESC');
        $sth->bindValue(':table_id', $this->commentSubject->getTableId());
        $sth->bindValue(':subject_id', $this->commentSubject->getSubjectId());
        $sth->execute();

        return CommentHydrator::fetchObject($sth->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function renderComments()
    {
        if (!($this->commentsTemplate instanceof CommentsTemplatePresenterInterface)) {
            $this->setCommentsTemplate(new CommentsTemplatePresenter());
        }

        $this->commentsTemplate->setComments($this->getComments());
        return $this->commentsTemplate->render();
    }

    public function renderInputForm()
    {
        if (!($this->inputFormTemplate instanceof InputFormTemplatePresenter)) {
            $this->inputFormTemplate = new InputFormTemplatePresenter();
        }

        return $this->inputFormTemplate->render();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->status === self::STATUS_VALID;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        if ($status === self::STATUS_VALID || $status === self::STATUS_INVALID) {
            $this->status = $status;
        } else {
            throw new \InvalidArgumentException('Wrong STATUS const value passed');
        }
    }

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->dbh;
    }

    /**
     * @return CommentSubjectInterface
     */
    public function getCommentSubject()
    {
        return $this->commentSubject;
    }

    /**
     * Load observers from db
     */
    private function loadObservers()
    {
        /** @var \PDOStatement $sth */
        $sth = self::$instance->dbh->prepare('SELECT observer_name, event_name from observers ORDER BY event_name, observer_priority DESC');
        $sth->execute();

        foreach ($sth->fetchAll(\PDO::FETCH_KEY_PAIR) as $observer => $eventName) {
            self::$instance->addObserver($eventName, new $observer);
        }
    }

    /**
     * @param CommentsTemplatePresenterInterface $commentsTemplate
     */
    public function setCommentsTemplate(CommentsTemplatePresenterInterface $commentsTemplate)
    {
        $this->commentsTemplate = $commentsTemplate;
    }
}
