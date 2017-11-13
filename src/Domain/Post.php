<?php

namespace Blog\Domain;

class Post {
    
    private $post_nr;
    private $post_title;
    private $post_author;
    private $post_date;
    private $post_tags;
    private $post_text;

    public function getNumber(): int
    {
        return $this->post_nr;
    }

    public function getTitle(): string
    {
        return $this->post_title;
    }

    public function getAuthor(): string
    {
        return $this->post_author;
    }

    public function getDate()
    {
        return $this->post_date;
    }

    public function getTags(): string
    {
        return $this->post_tags ?? '';
    }

    public function getText(): string
    {
        return $this->post_text;
    }
}
