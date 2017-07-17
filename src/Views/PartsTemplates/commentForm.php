<div class="create-comment comment-comment">
    <div class="media-left photo-block">
        <img class="media-object user-photo" src="/frontend/img/user_photo.png" alt="...">
    </div>
    <form id="<?php echo "comment_" . $comments['comment_id']; ?>" method="post" action="/create-comment" name="comment" class="col-md-offset-2">
        <label for="comment">Comment:</label>
        <textarea form="<?php echo "comment_" . $comments['comment_id']; ?>" title="comment" class="input form-control"
                  name="message" rows="3" cols="50"></textarea>
        <input form="<?php echo "comment_" . $comments['comment_id']; ?>" type="hidden" name="post_id" value="<?php echo $GLOBALS['postId']; ?>">
        <input form="<?php echo "comment_" . $comments['comment_id']; ?>" type="hidden" name="comment_parent_id" value="<?php echo $comments['comment_id']; ?>">
        <button type="submit" id="submit" class="btn btn-default">Submit</button>
    </form>
</div>
