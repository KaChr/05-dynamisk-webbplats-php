<?php

namespace Blog\Domain\Posts;

use Blog\Domain\Entry;

class Fundering extends Entry 
{
    public function getType()
    {
        return 'Fundering';
    }
}