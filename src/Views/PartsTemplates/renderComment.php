<?php
function recursiveRenderComment($comments)
{
    if ($comments['comment_id'] > null){
        render($comments);
    } else {
        /** foreach children comments*/
        foreach ($comments as $comment){
            recursiveRenderComment($comment);
        }
    }
}

function render($comments)
{
    echo "<li class=\"media\">";
    echo "<div class=\"media-left\"><img class=\"media-object user-photo\" src=\"/frontend/img/user_photo.png\" alt=\"...\"></div>";
    echo "<div class=\"media-body\">";
    echo "<h4 class=\"media-heading\">" . $comments['comment_user_name'] . "</h4>";
    echo $comments['comment_content'];
    echo "</div>";
    include 'src/Views/PartsTemplates/commentButtons.php';

    include 'src/Views/PartsTemplates/commentForm.php';
    include 'src/Views/PartsTemplates/commentEditForm.php';
    if (array_key_exists('children', $comments)) {
        echo "<ul>";
        recursiveRenderComment($comments['children']);
        echo "</ul>";
    }
    echo "</li>";
}
?>
