<?php

namespace CommentsPluggableSystem\Observers;

use CommentsPluggableSystem\Comment;
use CommentsPluggableSystem\Form;

/**
 * Class SubmitValidatorObserver
 *
 * Define Form valid or not
 */
class SubmitValidatorObserver
{
    private static $rules = [
        Comment::API_KEY_TITLE => '/^[\w\d\s]{0,160}$/u',
        Comment::API_KEY_CONTENT => '/^[\w\d\s\.\,\"\'\:\)\(]{0,512}$/u',
        Comment::API_KEY_AUTHOR => '/^[\w\d\s]{0,20}$/u'
    ];

    public function __invoke($eventName, Form $form)
    {
        /** @var array $postData, use-case: [title => 'use-case title', content => 'use-case content', author_email => 'author@use-case.com'] */
        $postData = $form->getPostData();

        $errors = [];
        foreach (self::$rules as $key => $regex) {
            if (isset($postData[$key])) {
                if (!preg_match($regex, $postData[$key])) {
                    $errors[] = 'Invalid form field: ' . $key . ', value: ' . $postData[$key];
                }
            } else {
                $errors[] = 'Missed data for field: ' . $key;
            }
        }

        $form->setErrors($errors);

        $formStatusValue = empty($errors)? Form::STATUS_VALID : Form::STATUS_INVALID;

        $form->setStatus($formStatusValue);
    }
}