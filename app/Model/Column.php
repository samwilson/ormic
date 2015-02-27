<?php namespace Ormic\Model;

class Column {

    private $model;
    private $name;
    private $info;
    private $type;
    private $size;
    private $unique;
    private $nullable;
    private $increments;

    function __construct($model, $name, $info)
    {
        $this->model = $model;
        $this->name = $name;
        $this->info = $info;

        // Nullable.
        if (isset($info->Null))
        {
            $this->nullable = strtoupper($info->Null) === 'YES';
        }
        if (isset($info->notnull))
        {
            $this->nullable = $info->notnull === '0';
        }

        // Increments.
        if (isset($info->Extra))
        {
            $this->increments = (strpos($info->Extra, 'auto_increment') !== false);
        }
//        if (isset($info->notnull))
//        {
//            $this->nullable = $info->notnull === '0';
//        }
    }

    function increments()
    {
        return $this->increments;
    }

    /**
     * A column is 'required' if it's not nullable and doesn't auto-increment.
     * @uses Column::nullable()
     * @uses Column::increments()
     * @return type
     */
    public function isRequired()
    {
        return (!$this->nullable() && !$this->increments());
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
