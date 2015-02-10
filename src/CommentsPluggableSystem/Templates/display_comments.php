<?php if($comments = $this->getComments()): ?>
<ul id="comments" itemscope itemtype="http://schema.org/UserComments">
    <?php
    /** @var \CommentsPluggableSystem\Comment $comment */
    foreach($comments as $comment): ?>
    <li class="comment">
        <div itemprop="name" class="author"><span itemprop="commentTime"><?= $comment->getDateTime()->format('Y-m-d H:i:s') ?></span>, <?= $comment->getAuthor() ?>:</div>
        <div itemprop="commentText" class="content"><p><?= $comment->getContent() ?></p></div>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>