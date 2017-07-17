<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous"
    >
    <link rel="stylesheet" href="/frontend/css/main.css" type="text/css">
</head>
<body class="container-fluid">
<div class="row">
    <header class="col-md-12 navbar-inverse header"><?php if (!empty($_SESSION['user']['name'])) {
            echo $_SESSION['user']['name'];
        } ?></header>
    <articles class="col-md-10 col-md-offset-1">
        <?php if (!empty($data)): ?>
            <?php foreach ($data as $post): ?>
                <?php $GLOBALS['postId'] = $post['post_id']; ?>
                <div class="article">
                    <?php if (!empty($post)): ?>
                        <div class="title"><h2><?php echo $post['post_title']; ?></h2></div>
                        <div class="body-article"><?php echo $post['post_content']; ?></div>
                        <div class="create-comment">
                            <div class="media-left photo-block">
                                <img class="media-object user-photo" src="/frontend/img/user_photo.png" alt="...">
                            </div>
                            <form id="<?php echo $post['post_id'] ?>" method="post" action="/create-comment" name="comment" class="col-md-offset-2">
                                <label for="comment">Comment:</label>
                                <textarea form="<?php echo $post['post_id'] ?>" title="comment" class="input form-control"
                                          name="message" rows="3" cols="50"></textarea>
                                <input form="<?php echo $post['post_id'] ?>" type="hidden" name="post_id" value="<?php echo $post['post_id'] ?>">
                                <button type="submit" id="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($post['comments'])): ?>
                        <ul class="media-list comments">
                            <?php include_once 'src/Views/PartsTemplates/renderComment.php'; ?>
                            <?php foreach ($post['comments'] as $comments): ?>
                                <?php recursiveRenderComment($comments); ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </articles>
</div>
<script src="/frontend/js/main.js"></script>
</body>
</html>
