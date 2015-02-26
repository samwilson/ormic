<?php namespace Ormic\Model;

class Column {

    private $model;
    private $name;
    private $info;
    private $type;
    private $size;
    private $unique;
    private $nullable;

    function __construct($model, $name, $info)
    {

        $this->model = $model;
        $this->name = $name;
        $this->info = $info;
        if (isset($info->Null))
        {
            $this->nullable = strtoupper($info->Null) === 'YES';
        }
        if (isset($info->notnull))
        {
            $this->nullable = $info->notnull === '0';
        }
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function nullable()
    {
        return $this->nullable;
    }

}
