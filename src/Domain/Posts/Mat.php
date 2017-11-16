<?php

namespace Blog\Domain\Posts;

use Blog\Domain\Entry;

class Mat extends Entry
{
    public function getType()
    {
        return 'Mat';
    }
}