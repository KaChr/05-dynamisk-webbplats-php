<?php

namespace Blog\Controllers;

use Blog\Models\PostModel;

use Blog\Controllers\AbstractController;

class PostController extends AbstractController
{

    public function getAll(): string
    {
        // instansiera PostModel
        $postModel = new PostModel();
        $posts = $postModel->getAll();

        $properties = [
            'posts' => $posts
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getOne($id) {
        $postModel = new PostModel();
        $post = $postModel->getOne($id);

        $properties = [
            'posts' => $post
        ];

        return $this->render('views/post.php', $properties);
    }
}