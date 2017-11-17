<?php

namespace Blog\Controllers;

use Blog\Models\PostModel;
use Blog\Exceptions\NotFoundException;

class PostController extends AbstractController
{
    const PAGE_LENGTH = 3;

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

    public function search(): string
    {
        $searchString = $this->request->getParams()->getString('search');

        $postModel = new PostModel();
        $posts = $postModel->search($searchString);

        $properties = [
            'posts' => $posts,
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getByType(string $type)
    {
        $postModel = new Postmodel();
        $posts = $postModel->getByType($type);

        $properties = [
            'posts' => $posts
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getByUser(string $author) {
        $postModel = new PostModel();
        $posts = $postModel->getByUser($author);

        $properties = [
            'posts' => $posts
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function createPost() {

        if ($this->request->isPost()) {
            $params = $this->request->getParams();
            $postModel = new PostModel();
             
            $postId = $postModel->createPost(
                $params->get('title'),
                $params->get('author'),
                $params->get('text'),
                $params->get('type')
            );
    
            return $this->redirect('/post/' . $postId);
        }

        return $this->render('views/makePost.php', []);

    }
}