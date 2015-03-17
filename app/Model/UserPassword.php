<?php namespace Ormic\Model;

class UserPassword extends Base
{

    public function user()
    {
        return $this->belongsTo('Ormic\\Model\\User');
    }
}
