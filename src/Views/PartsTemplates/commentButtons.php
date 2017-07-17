<div class="col-md-offset-1">
    <?php session_start(); ?>
    <?php if ($_SESSION['user']['id'] === $comments['comment_user_id']): ?>
        <button class='btn btn-danger btn-sm delete'>remove</button>
        <button class='btn btn-warning btn-sm edit'>edit</button>
    <?php endif; ?>
    <button class='btn btn-primary btn-sm reply'>reply</button>
</div>

