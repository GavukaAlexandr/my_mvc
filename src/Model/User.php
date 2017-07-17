<?php

namespace Model;

use Core\BaseModel;

class User extends BaseModel
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $post;

    public function getUserByEmail(string $email)
    {
        $user = $this->model->getByField('user', 'email', $email);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->post = $user->post;
    }
}
