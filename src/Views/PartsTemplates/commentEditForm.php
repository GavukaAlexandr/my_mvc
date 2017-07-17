<div class="create-comment edit-comment">
    <div class="media-left photo-block">
        <img class="media-object user-photo" src="/frontend/img/user_photo.png" alt="...">
    </div>
    <form id="<?php echo $editForm = "edit_" . $comments['comment_id']; ?>" method="post" action="/update-comment" name="comment" class="col-md-offset-2">
        <label for="comment">Comment:</label>
        <textarea form="<?php echo $editForm; ?>" title="comment" class="input form-control"
                  name="message" rows="3" cols="50"><?php echo $comments['comment_content']; ?></textarea>
        <input form="<?php echo $editForm; ?>" type="hidden" name="post_id" value="<?php echo $GLOBALS['postId']; ?>">
        <input form="<?php echo $editForm; ?>" type="hidden" name="comment_id" value="<?php echo $comments['comment_id']; ?>">
        <input form="<?php echo $editForm; ?>" type="hidden" name="parent_comment_id" value="<?php echo $comments['parent_comment_id']; ?>">
        <button type="submit" id="submit" class="btn btn-default">Submit</button>
    </form>
</div>
