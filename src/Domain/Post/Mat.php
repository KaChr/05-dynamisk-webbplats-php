<?php

namespace Blog\Domain\Post;

use Blog\Domain\Post;
use Blog\Domain\Entry;

class Mat extends Entry implements Post 
{
    public function getType()
    {
        return 'Mat';
    }
}