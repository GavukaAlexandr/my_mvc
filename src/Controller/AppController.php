<?php

namespace Controller;

class AppController
{
    public function indexAction()
    {
        echo "<h1>indexAction created</h1>";
    }

    public function postAction($endPointUri)
    {
        echo "<h1>Post created $endPointUri</h1>";
    }
}
