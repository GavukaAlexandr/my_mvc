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
        $stmt = $this->model->dbh->prepare
        ("
SELECT
  post.id                   AS post_id,
  post.title                AS post_title,
  post.content              AS post_content,
  post_user.id              AS post_user_id,
  post_user.name            AS post_user_name,


  comment.id                AS comment_id,
  comment.content           AS comment_content,
  comment.parent_comment_id AS parent_comment_id,
  comment_user.id           AS comment_user_id,
  comment_user.name         AS comment_user_name
FROM post AS post
  LEFT JOIN user AS post_user ON post_user.id = post.user_id
  LEFT JOIN comment AS comment ON comment.post_id = post.id
  LEFT JOIN user AS comment_user ON comment_user.id = comment.user_id
");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $orderedPosts = $this->orderingPostsAndComments($data);

        foreach ($orderedPosts as $index => $post) {
            if (key_exists('comments', $post)) {
                $orderedPosts[$index]['comments'] = $this->buildCommentsTree($post['comments']);
            }
        }

        return $orderedPosts;
    }

    private function orderingPostsAndComments($data)
    {
        $posts = [];
        $postId = [];

        foreach ($data as $row) {
            if ((int) $row['post_id'] === (int) array_search($row['post_id'], $postId)) {
            } else {
                $posts[$row['post_id']] = [
                    'post_id' => $row['post_id'],
                    'post_title' => $row['post_title'],
                    'post_content' => $row['post_content'],
                    'post_user_id' => $row['post_user_id'],
                    'post_user_name' => $row['post_user_name'],
                ];
            }

            if ($row['comment_id'] !== null) {
                $posts[$row['post_id']]['comments'][$row['comment_id']] = [
                    'comment_id' => $row['comment_id'],
                    'comment_content' => $row['comment_content'],
                    'parent_comment_id' => $row['parent_comment_id'],
                    'comment_user_id' => $row['comment_user_id'],
                    'comment_user_name' => $row['comment_user_name'],
                ];
            }

            $postId[$row['post_id']] = $row['post_id'];
        }

        return $posts;
    }

    protected function buildCommentsTree(array $comments, $parentId = 0)
    {
        $branch = array();
        foreach ($comments as $comment) {
            if ($comment['parent_comment_id'] == $parentId) {
                $children = $this->buildCommentsTree($comments, $comment['comment_id']);
                if ($children) {
                    $comment['children'] = $children;
                }
                $branch[] = $comment;
            }
        }

        return $branch;
    }
}
