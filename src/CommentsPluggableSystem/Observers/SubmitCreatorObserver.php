<?php

namespace CommentsPluggableSystem\Observers;

use CommentsPluggableSystem\Comment;
use CommentsPluggableSystem\Exceptions\InvalidFormException;
use CommentsPluggableSystem\Form;

/**
 * Class SubmitCreatorObserver
 *
 * Creates a new Comment instance
 */
class SubmitCreatorObserver
{
    public function __invoke($eventName, Form $form)
    {
        if (!$form->isValid()) {
            $msg = 'Form data is invalid.';

            $errors = $form->getErrors();
            if(!empty($errors)) {
                $msg .= ' Errors: ' . implode(',', $errors);
            }

            throw new InvalidFormException($msg);
        }

        $postData = $form->getPostData();

        $comment = new Comment();
        $comment->setTitle($postData[Comment::API_KEY_TITLE]);
        $comment->setContent($postData[Comment::API_KEY_CONTENT]);
        $comment->setAuthor($postData[Comment::API_KEY_AUTHOR]);
        $comment->setDateTime(new \DateTime());
        $comment->setStatus(Comment::STATUS_PENDING);
        $comment->setTableId($form->getCommentSubject()->getTableId());
        $comment->setSubjectId($form->getCommentSubject()->getSubjectId());

        $form->setNewComment($comment);
    }
}