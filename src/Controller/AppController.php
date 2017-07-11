<?php

namespace Controller;

use Core\View;
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
        $getPosts = $post->getPosts();

        $renderArray = [];
        $this->view->render('index.php', $renderArray);
    }

    public function postAction($endPointUri)
    {
        echo "<h1>Post created $endPointUri</h1>";
    }
}
