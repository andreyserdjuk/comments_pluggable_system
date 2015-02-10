<style>
    .form-block {
        padding-bottom: 10px;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    .form-block>label {
        display: block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }
    .form-input {
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>

<form method="post">
    <div class="form-block">
        <label for="comment_author">Author</label>
        <input type="text" class="form-input" name="comment_author" id="comment_author">
    </div>
    <div class="form-block">
        <label for="comment_title">Title</label>
        <input type="text" class="form-input" name="comment_title" id="comment_title">
    </div>
    <div class="form-block">
        <label for="comment_body">Your comment</label>
        <textarea name="comment_body" class="form-input" id="comment_body"></textarea>
    </div>
    <input type="submit">
</form>
