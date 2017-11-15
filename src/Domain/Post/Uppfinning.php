<?php

namespace Blog\Domain\Post;

use Blog\Domain\Post;
use Blog\Domain\Entry;

class Uppfinning extends Entry implements Post 
{
    public function getType()
    {
        return 'Uppfinning';
    }
}