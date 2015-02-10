<?php

namespace CommentsPluggableSystem\CommentSystemUseCase;

require __DIR__ . '/../vendor/autoload.php';

use CommentsPluggableSystem\Comment;
use CommentsPluggableSystem\CommentsTemplatePresenter;
use CommentsPluggableSystem\Form;

/**
 * Let it we have some post and we want to init our comments form
 */
$post = new Post();
$post->setId(134);

/**
 * Form needs any instance of CommentSubjectInterface, which may have comments
 */
$form = Form::init($post, new \PDO('mysql:dbname=testdb;host=127.0.0.1', 'root', 12345));
$form->handleSubmit();

// ugly, I know, but I don't know what detail is more significant in my "Backend Task.pdf"
// not ready yet echo $form->renderErrors(); and/or bind callback - for more flexible using
if($errors = $form->getErrors()) {
    foreach ($errors as $error) {
        echo "<div style='color:red'>$error</div>";
    }
}

echo $form->renderInputForm();
echo $form->renderComments();


/**
 * submit $_POST content analogue
 */
//$form->submit([
//    Comment::API_KEY_TITLE => 'comments title',
//    Comment::API_KEY_CONTENT => 'use case content',
//    Comment::API_KEY_AUTHOR => 'example author'
//]);

/** @var Comment $coment */
//foreach ($form->getComments() as $coment) {
//    echo $coment->getAuthor() . "|"
//        . $coment->getTitle() . "|"
//        . $coment->getContent() . "|"
//        . $coment->getDateTime()->format('Y-M-d H:i:s')
//        . PHP_EOL;
//}
