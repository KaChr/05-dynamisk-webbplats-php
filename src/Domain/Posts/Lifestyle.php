<?php

namespace Blog\Domain\Posts;

use Blog\Domain\Entry;

class Lifestyle extends Entry
{
    public function getType()
    {
        return 'Livsstil';
    }
}