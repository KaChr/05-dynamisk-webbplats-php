<?php
namespace Blog\Controllers;

use Blog\Exceptions\NotFoundException;

use Blog\Models\PostModel;

class DefaultController extends AbstractController
{
    public function start(): string
    {
        $postModel = new PostModel();

        $tags = $postModel->getAllTags();

        $properties = [
            'tags' => $tags,
            'title' => 'This is the title of the blog'
        ];

        return $this->render('views/layout.php', $properties);
    }
}