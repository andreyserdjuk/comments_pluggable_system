<?php

namespace Tests;

use CommentsPluggableSystem\Comment;
use CommentsPluggableSystem\Form;
use CommentsPluggableSystem\Events\SubmitEvent;

class FormTest extends \PHPUnit_Framework_TestCase
{
    public $validCommentTitle = 'test title of the comment';
    public $invalidCommentTitle = 'test title# of the comment';
    public $validCommentAuthor = 'Author Example';
    public $invalidCommentAuthor = 'Author+Example';
    public $validCommentContent = 'This is nice content.';
    public $invalidCommentContent = 'This is nice// content.';

    /**
     * @dataProvider formProvider
     */
    public function testObserverAttaching($form)
    {
        $observer = $this->getMock('Observer', ['__invoke']);
        $observer
            ->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->anything(),
                $form
            )
        ;

        $form->addObserver(SubmitEvent::NAME, $observer);
        $form->fireEvent(SubmitEvent::NAME);
    }

    /**
     * @dataProvider formProvider
     */
    public function testGetComments($form)
    {
        /** Form $form */
        $comments = $form->getComments();
        $this->assertEquals(2, count($comments));
        $this->assertInstanceOf('\CommentsPluggableSystem\Comment', current($comments));
    }

    /**
     * Test form validation results
     * Test created comment
     *
     * @dataProvider formProvider
     */
    public function testSubmitValidForm($form)
    {
        $form->submit([
            Comment::API_KEY_TITLE => $this->validCommentTitle,
            Comment::API_KEY_AUTHOR => $this->validCommentAuthor,
            Comment::API_KEY_CONTENT => $this->validCommentContent
        ]);

        $this->assertEmpty($form->getErrors());
        $this->assertTrue($form->isValid());

        /** @var Comment $comment */
        $comment = $form->getNewComment();

        $this->assertInstanceOf('\CommentsPluggableSystem\Comment', $comment);

        $this->assertEquals($comment->getSubjectId(), 123);

        $this->assertEquals($comment->getTableId(), \Post::TABLE_UNIQUE_ID);

        $this->assertEquals($comment->getId(), 1);

        $this->assertEquals($comment->getTitle(), $this->validCommentTitle);

        $this->assertEquals($comment->getAuthor(), $this->validCommentAuthor);

        $this->assertEquals($comment->getContent(), $this->validCommentContent);
    }

    /**
     * Error in author field
     *
     * @dataProvider formProvider
     * @expectedException \CommentsPluggableSystem\Exceptions\InvalidFormException
     */
    public function testSubmitInvalidFormAuthor($form)
    {
        $form->submit([
            Comment::API_KEY_TITLE => $this->validCommentTitle,
            Comment::API_KEY_AUTHOR => $this->invalidCommentAuthor,
            Comment::API_KEY_CONTENT => $this->validCommentContent
        ]);
    }

    /**
     * Error in title field
     *
     * @dataProvider formProvider
     * @expectedException \CommentsPluggableSystem\Exceptions\InvalidFormException
     */
    public function testSubmitInvalidFormTitle($form)
    {
        $form->submit([
            Comment::API_KEY_TITLE => $this->invalidCommentTitle,
            Comment::API_KEY_AUTHOR => $this->validCommentAuthor,
            Comment::API_KEY_CONTENT => $this->validCommentContent
        ]);
    }


    /**
     * Error in content field
     *
     * @dataProvider formProvider
     * @expectedException \CommentsPluggableSystem\Exceptions\InvalidFormException
     */
    public function testSubmitInvalidFormContent($form)
    {
        $form->submit([
            Comment::API_KEY_TITLE => $this->validCommentTitle,
            Comment::API_KEY_AUTHOR => $this->validCommentAuthor,
            Comment::API_KEY_CONTENT => $this->invalidCommentContent
        ]);
    }

    public function formProvider()
    {
        // $commentSubjectMock = $this->getMock('\CommentsPluggableSystem\Interfaces\CommentSubjectInterface');
        $commentSubjectMock = new \Post();
        $commentSubjectMock->setId(123);

        $form = Form::init($commentSubjectMock, new \mockPDO());

        return [[$form]];
    }


    // does not work properly
    public function pdoProvider()
    {
        /*$fetchAllMock = $this
            ->getMockBuilder('stdClass')
            ->setMethods(['execute', 'fetchAll'])
            ->getMock()
            ->expects($this->once())->method('fetchAll')
            ->will($this->returnValue([]));

        $pdo = $this
            ->getMockBuilder('PDO')
            ->disableOriginalConstructor()
            ->setMethods(['prepare'])
            ->getMock()
            ->expects($this->once())
            ->method('prepare')
            ->with($this->any())
            ->will($this->returnValue($fetchAllMock));

        return [[$pdo]];*/
    }
}
