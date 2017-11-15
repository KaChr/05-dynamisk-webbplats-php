<?php

namespace Blog\Domain\Post;

use Blog\Domain\Post;
use Blog\Domain\Entry;

class Fundering extends Entry implements Post 
{
    public function getType()
    {
        return 'Fundering';
    }
}