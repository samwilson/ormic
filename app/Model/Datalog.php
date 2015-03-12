<?php namespace Ormic\Model;

class Datalog extends Base {

    protected $table = 'datalog';

    /**
     * Everyone can create datalog entries.
     * @return true
     */
    public function canCreate()
    {
        return true;
    }

}
