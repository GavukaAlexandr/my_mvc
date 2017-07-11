<?php

namespace Core;

class Security
{
    public function run()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $result = $_SERVER['REQUEST_URI'];

            //todo In future remodel in preg_much for access rules
            switch ($result) {
                case "/login":
                    break;
                case '/logout':
                    break;
                case '/register':
                    break;
                default :
                    session_start();
                    if (isset($_SESSION['user'])) {
                        print "User " . $_SESSION['user']['name'] . " authenticated";
                    } else {
                        header('Location: http://localhost:8000/login');
                        exit;
                    }
            }
        }
    }
}
