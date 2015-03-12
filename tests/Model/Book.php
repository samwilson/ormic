<?php namespace Ormic\Tests\Model;

class Book extends \Ormic\Model\Base {

    public function author()
    {
        return $this->belongsTo('Ormic\Tests\Model\Author');
    }

}
