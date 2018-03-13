<?php

namespace Blog\Domain;

class Entry {

    private $post_nr;
    private $post_title;
    private $post_author;
    private $post_author_fullname;
    private $post_date;
    private $tags = [];
    private $post_text;
    private $type;

    public function getNumber(): int
    {
        return $this->post_nr;
    }

    public function getTitle(): string
    {
        return $this->post_title;
    }

    public function getAuthorId(): int
    {
        return $this->post_author;
    }

    public function getAuthor(): string
    {
        return $this->post_author_fullname;
    }

    public function getDate()
    {
        return $this->post_date;
    }

    public function getTags(): string
    {
        return $this->post_tags ?? '';
    }

    public function getTagsAsArray(): array {
        if (!empty ($this->tags)) {
            return explode(',', $this->tags);
        }

        return [];

    }

    public function getText(): string
    {
        return $this->post_text;
    }

    public function getType(): string
    {
        return $this->type ?? '';
    }
}
