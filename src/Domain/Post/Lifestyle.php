<?php

namespace Blog\Domain\Post;

use Blog\Domain\Post;
use Blog\Domain\Entry;

class Lifestyle extends Entry implements Post 
{
    public function getType()
    {
        return 'Livsstil';
    }
}