<?php

namespace CommentsPluggableSystem\Observers;

use CommentsPluggableSystem\Comment;
use CommentsPluggableSystem\Form;

/**
 * Class SubmitFilterObserver
 *
 * Replace's smiles with corresponding images of the smileys
 *
 * P.S. I don't like this idea, it makes a mess in db.
 * todo: discuss questions:
 * What if we want redesign smiles?
 * What about smileys like ☹ ☺?
 *
 * I'd like to leave smiles as is and replace them by JavaScript
 * or alternatively do the same by output filter.
 */
class SubmitFilterObserver
{
    public function __invoke($eventName, Form $form)
    {
        /** @var array $postData [title => comment's title, content => comments content, author_email => author@use-case.com ] */
        $postData = $form->getPostData();

        $postData[Comment::API_KEY_CONTENT] = self::filterSmiles($form->getConnection(), $postData[Comment::API_KEY_CONTENT]);

        $form->setPostData($postData);
    }

    private static function filterSmiles(\PDO $dbh, $body)
    {
        $sth = $dbh->prepare('SELECT smile_code, img_src from smileys');
        $sth->execute();

        foreach ($sth->fetchAll(\PDO::FETCH_KEY_PAIR) as $smileCode => $imgSrc) {
            $body = str_replace($smileCode, '<img src="' . $imgSrc . '" alt="' . $smileCode . '">', $body);
        }

        return $body;
    }
}
