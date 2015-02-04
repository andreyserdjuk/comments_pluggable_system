<?php

namespace CommentsPluggableSystem\Observers;

use CommentsPluggableSystem\Form;

class SubmitSaverObserver
{
    public function __invoke($eventName, Form $form)
    {
        $comment = $form->getNewComment();
        $dbh = $form->getConnection();

        // todo: edit comment
        // todo: approve comment

        $sth = $dbh->prepare('INSERT INTO comments(table_id,subject_id,title,content,author,created_at,status) VALUES(:table_id,:subject_id,:title,:content,:author,:created_at,:status)');
        $sth->bindValue(':table_id', $form->getCommentSubject()->getTableId(), \PDO::PARAM_INT);
        $sth->bindValue(':subject_id', $form->getCommentSubject()->getSubjectId(), \PDO::PARAM_INT);
        $sth->bindValue(':title', $comment->getTitle(), \PDO::PARAM_STR);
        $sth->bindValue(':content', $comment->getContent(), \PDO::PARAM_STR);
        $sth->bindValue(':author', $comment->getAuthor(), \PDO::PARAM_STR);
        $sth->bindValue(':created_at', $comment->getDateTime()->format('Y-m-d H:i:s'), \PDO::PARAM_INT);
        $sth->bindValue(':status', $comment->getStatus(), \PDO::PARAM_INT);

        // todo: handle errors during comment saving
        $sth->execute();

        $comment->setId($dbh->lastInsertId());
    }
}