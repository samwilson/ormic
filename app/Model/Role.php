<?php namespace Ormic\Model;

class Role extends Base
{

    const ADMIN_ID = 1;

    public $fillable = array('name');

    public function users()
    {
        return $this->belongsToMany('Ormic\Model\User');
    }

    public function canCreate()
    {
        $isAdmin = (isset($this->user) && $this->user->isAdmin());
        $isFirst = self::count() == 0;
        return ($isAdmin || $isFirst);
    }
}
