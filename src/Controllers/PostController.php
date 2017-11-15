<?php

namespace Blog\Controllers;

use Blog\Models\PostModel;
use Blog\Exceptions\NotFoundException;
// use Blog\Controllers\AbstractController;

class PostController extends AbstractController
{
    const PAGE_LENGTH = 10;

    public function getAllWithPage($page): string
    {
        // instansiera PostModel
        $page = (int)$page;
        $postModel = new PostModel();
        $posts = $postModel->getAllWithPage($page, self::PAGE_LENGTH);

        $properties = [
            'posts' => $posts,
            'currentPage' => $page,
            'lastPage' => count($posts) < self::PAGE_LENGTH
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getAll(): string
    {
        return $this->getAllWithPage(1);
    }


    public function getOne(int $id) {
        $postModel = new PostModel();
        $post = $postModel->getOne($id);

        $properties = [
            'post' => $post[0]
        ];

        return $this->render('views/post.php', $properties);
    }
}