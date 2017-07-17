<?php

namespace Controller;

use Core\View;
use Model\Post;
use Model\User;

class UserController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function loginAction()
    {
        if (!empty($_POST['email'])) {
            $userEmail = $_POST['email'];
            $userPassword = md5($_POST['password']);

            $user = new User();
            $user->getUserByEmail($userEmail);

            if ($user->email === $userEmail && $user->password === $userPassword) {
                session_start(/*['cookie_lifetime' => 86400]*/);
                $_SESSION["user"]["id"] = $user->id;
                $_SESSION["user"]["name"] = $user->name;
                $_SESSION["user"]["email"] = $user->email;
                header('Location: http://mymvc/');
                exit;
            } else {
                $renderArray = [
                    'message' => "email or password is not correct"
                ];
                $this->view->render('login.php', $renderArray);
                exit;
            }

        } else {
            $this->view->render('login.php', $dataArray = [/*myData*/]);
            exit;
        }
    }

    public function logoutAction()
    {
        session_start();
        session_unset();
        echo "LogOut";
    }

    public function registerAction()
    {
        if (!empty($_POST['email'])) {
            $userName = $_POST['name'];
            $userEmail = $_POST['email'];
            $userPassword = md5($_POST['password']);

            $user = new User();
            $user->getUserByEmail($userEmail);
            if (empty($user->content)) {
                $user->model->insertDataInTable(
                    'user',
                    ['name' => $userName, 'email' => $userEmail, 'password' => $userPassword]
                );

                $this->loginAction($userEmail, $userPassword);
            } else {
                $renderArray = ['message' => 'this user already exists'];
                $this->view->render('register.php', $renderArray);
                exit;
            }
        } else {
            $this->view->render('register.php', $dataArray = [/*myData*/]);
            exit;
        }
    }
}
