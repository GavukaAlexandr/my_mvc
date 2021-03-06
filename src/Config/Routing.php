<?php

namespace Config;

class Routing
{
    public $routes = [
        '/$' => 'app/index',
        'post/([0-9]+)' => "app/post",
        'register' => 'user/register',
        'login' => 'user/login',
        'logout' => 'user/logout',
        'create-comment' => 'app/createComment',
        'remove-comment' => 'app/removeComment',
        'update-comment' => 'app/updateComment',
//        '' => '',
    ];
}
