<?php

namespace Blog\Domain\Posts;

use Blog\Domain\Entry;

class Uppfinning extends Entry
{
    public function getType()
    {
        return 'Uppfinning';
    }
}