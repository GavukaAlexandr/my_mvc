<?php

namespace Model;

use Core\BaseModel;

class Post extends BaseModel
{
    public $id;
    public $title;
    public $content;
    public $userId;
    public $commentId;

    public function getPosts()
    {
        $post = $this->model->getAllDataInTable('post');
        //todo prepare data for template
    }
}
