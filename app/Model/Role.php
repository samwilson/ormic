<?php

namespace Ormic\Model;

class Role extends Base
{

    const ADMIN_ID = 1;

    public $fillable = array('name');

    public function users()
    {
        return $this->belongsToMany('Ormic\Model\User');
    }
}
