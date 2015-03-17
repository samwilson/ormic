<?php namespace Ormic\Tests\Model;

class Author extends \Ormic\Model\Base
{

    public function books()
    {
        return $this->hasMany('Ormic\Tests\Model\Book');
    }
}
