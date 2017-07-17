<?php

namespace Controller;

use Core\View;
use Model\Comment;
use Model\Post;
use Model\User;

class AppController
{
    private $view;

    //todo In future need created BaseController.
    public function __construct()
    {
        $this->view = new View();
    }

    public function indexAction()
    {
        //todo get data and render template
        $post = new Post();
        $allPost = $post->getPosts();

        $this->view->render('index.php', $allPost);
    }

    public function createCommentAction()
    {
        session_start();
        $user = $_SESSION['user']['id'];
        $postId = $_POST['post_id'];
        $commentParentId = $_POST['comment_parent_id'];
        $message = $_POST['message'];

        $comment = new Comment();
        $comment->model->insertDataInTable(
            'comment',
            [
                'post_id' => $postId,
                'user_id' => $user,
                'content' => $message,
                'parent_comment_id' => $commentParentId]
        );

        header('Location: http://mymvc/');
        exit;
    }

    public function removeCommentAction()
    {

    }

    public function postAction($endPointUri)
    {
        echo "<h1>Post created $endPointUri</h1>";
    }
}
