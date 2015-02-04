<?php

namespace CommentsPluggableSystem\CommentSystemUseCase;

require __DIR__ . '/../vendor/autoload.php';

use CommentsPluggableSystem\Comment;
use CommentsPluggableSystem\Form;

$post = new Post();
$post->setId(134);

$form = Form::init($post, new \PDO('mysql:dbname=testdb;host=127.0.0.1', 'root', 12345));

$form->submit([
    Comment::API_KEY_TITLE => 'comments title',
    Comment::API_KEY_CONTENT => 'use case content',
    Comment::API_KEY_AUTHOR => 'example author'
]);

/** @var Comment $coment */
foreach ($form->getComments() as $coment) {
    echo $coment->getAuthor() . "|"
        . $coment->getTitle() . "|"
        . $coment->getContent() . "|"
        . $coment->getDateTime()->format('Y-M-d H:i:s')
        . PHP_EOL;
}
