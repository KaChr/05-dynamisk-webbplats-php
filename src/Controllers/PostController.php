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
        // $posts = $postModel->getAllWithPage($page, self::PAGE_LENGTH);
        $posts = $postModel->getAllWithTags($page, self::PAGE_LENGTH);
        $tags = $postModel->getAllTags();

        $properties = [
            'tags' => $tags,
            'posts' => $posts,
            'currentPage' => $page,
            'lastPage' => count($posts) < self::PAGE_LENGTH
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getAll(): string
    {
        return $this->getAllWithPage(1);

        // $postModel = new PostModel();

        // $posts = $postModel->getAllWithTags();

        // var_dump($posts);
        // die;
    }

    public function getOne(int $id) {
        $postModel = new PostModel();
        $post = $postModel->getOne($id);
        $tags = $postModel->getAllTags();

        $properties = [
            'tags' => $tags,
            'post' => $post[0]
        ];

        return $this->render('views/post.php', $properties);
    }

    public function search(): string
    {
        $searchString = $this->request->getParams()->getString('search');

        $postModel = new PostModel();
        $posts = $postModel->search($searchString);
        $tags = $postModel->getAllTags();

        $properties = [
            'tags' => $tags,
            'posts' => $posts
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getByType(string $type)
    {
        $postModel = new Postmodel();
        $posts = $postModel->getByType($type);
        $tags = $postModel->getAllTags();

        $properties = [
            'tags' => $tags,
            'posts' => $posts
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getByTag(int $postId)
    {
        $postModel = new PostModel();
        $posts = $postModel->getByTags($postId);
        $tags = $postModel->getAllTags();

        $properties = [
            'tags' => $tags,
            'posts' => $posts
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function getByUser(string $author) {
        $postModel = new PostModel();
        $posts = $postModel->getByUser($author);
        $tags = $postModel->getAllTags();

        $properties = [
            'tags' => $tags,
            'posts' => $posts
        ];

        return $this->render('views/posts.php', $properties);
    }

    public function createPost() {

        if ($this->request->isPost()) {
            $params = $this->request->getParams();
            $postModel = new PostModel();
            $tags = $postModel->getAllTags();

             
            $postId = $postModel->createPost(
                $params->get('title'),
                $params->get('author'),
                $params->get('text'),
                $params->get('type'),
                $params->get('tags')
            );
    
            return $this->redirect('/post/' . $postId);
        }

        $postModel = new PostModel();

        $tags = $postModel->getAllTags(); 

        return $this->render('views/makePost.php', ['tags' => $tags]);

    }

    public function editPost() {
        
        if ($this->request->isPost()) {
            $params = $this->request->getParams();
            $postModel = new PostModel();
                
            $postId = $postModel->editPost(
                $params->get('id'),
                $params->get('title'),
                $params->get('author'),
                $params->get('text'),
                $params->get('type'),
                $params->get('tags')
            );
    
            return $this->redirect('/');
        }

        return $this->redirect('/');

    }

    public function deletePost() {
        if ($this->request->isPost()) {
            $params = $this->request->getParams();
            $postModel = new PostModel();

            $postModel->deletePost($params->get('post_id'));
        }

        return $this->redirect('/');
    }
}