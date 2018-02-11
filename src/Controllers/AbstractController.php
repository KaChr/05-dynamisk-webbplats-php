<?php

namespace Blog\Controllers;

use Blog\Core\Request;

abstract class AbstractController
{
    protected $request;
    protected $view;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function render(string $viewPath, array $paramsToInclude): string
    {
        extract($paramsToInclude);

        ob_start();

        include 'templates/navigation.html';
        include 'templates/header.html';
        include $viewPath;
        include 'templates/footer.html';

        $renderedView = ob_get_clean();

        return $renderedView;
    }

    protected function redirect(string $url)
    {
        ob_start();
        header('Location: ' . $url);
        ob_end_flush();
        die();
    }

}