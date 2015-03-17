<?php namespace Ormic\Model;

use Illuminate\Support\Facades\DB;
use Watson\Validating\ValidatingTrait;

abstract class Base extends \Illuminate\Database\Eloquent\Model {

    use ValidatingTrait;

    /** @var boolean */
    public $timestamps = false;

    /** @var array|string */
    protected static $hasOne = array();

    /** @var array|string */
    protected $hasMany = array();

    /** @var array|Column */
    protected $columns;

    /** @var User */
    protected $user;

    /** @var array|string */
    protected $rules;
    protected static $datalogObserver;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

//        if (is_null(self::$datalogObserver))
//        {
//            self::$datalogObserver = new \Ormic\Observers\Datalog();
//        }
//        if (get_called_class() != 'Ormic\\Model\\Datalog')
//        {
//            self::observe(self::$datalogObserver);
//        }
        // 'creating', 'created', 'updating', 'updated',
        // 'deleting', 'deleted', 'saving', 'saved',
        // 'restoring', 'restored',
        foreach ($this->getObservableEvents() as $event)
        {
            $methodName = 'on' . camel_case($event);
            if (method_exists($this, $methodName))
            {
                self::$event(array($this, $methodName));
            }
        }
    }

//    public static function boot()
//    {
//        parent::boot();
//        if (!static::$datalogObserver) {
//            static::$datalogObserver = new \Ormic\Observers\Datalog();
//        }
//        static::observe();
//    }

    public function save(array $options = array())
    {
        // The User model is the only one that can be saved without 
        $anonModels = array(
            'Ormic\\Model\\User',
            'Ormic\\Model\\Datalog',
        );
        if (!$this->getUser() && !in_array(get_called_class(), $anonModels))
        {
            throw new \Exception('User not set when saving ' . get_called_class());
        }
        parent::save($options);
    }

    public static function firstOrCreate(array $attributes, \Ormic\Model\User $user = null)
    {
        if (!is_null($instance = static::where($attributes)->first()))
        {
            $instance->setUser($user);
            return $instance;
        }
        $model = new static($attributes);
        $model->setUser($user);
        $model->save();
        return $model;
    }

    public function getDatalog()
    {
        return Datalog::where('table', $this->getTable())
            ->where('row', $this->id)
            ->orderBy('date_and_time', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
    }

//
//    public function onCreating(Base $model)
//    {
//        
//    }

    public function canCreate()
    {
        return $this->canEdit();
    }

    public function canEdit()
    {
        return ($this->getUser() && $this->getUser()->isAdmin());
    }

    public function getHasOne()
    {
        return self::$hasOne;
    }

    public function getHasMany()
    {
        return $this->hasMany;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        if (!$this->user)
        {
            $this->user = \Auth::user();
        }
        return $this->user;
    }

    /**
     * Get the columns of this Model.
     * @return array|Column
     * @throws \Exception
     */
    public function getColumns()
    {
        if ($this->columns)
        {
            return $this->columns;
        }

        switch (DB::connection()->getConfig('driver'))
        {
            case 'sqlite':
                $columnsSql = "PRAGMA TABLE_INFO(" . $this->getTable() . ")";
                $indicesSql = "PRAGMA INDEX_LIST(" . $this->getTable() . ")";
                $column_name = 'name';
                $reverse = false;
                break;

            case 'pgsql':
                $columnsSql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $this->getTable() . "'";
                $column_name = 'column_name';
                $reverse = true;
                break;

            case 'mysql':
                $columnsSql = 'SHOW FULL COLUMNS FROM ' . $this->getTable();
                $column_name = 'Field';
                $reverse = false;
                break;

            case 'sqlsrv':
                $parts = explode('.', $this->getTable());
                $num = (count($parts) - 1);
                $table = $parts[$num];
                $columnsSql = "SELECT column_name FROM " . DB::connection()->getConfig('database') . ".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $table . "'";
                $column_name = 'column_name';
                $reverse = false;
                break;

            default:
                $error = 'Database driver not supported: ' . DB::connection()->getConfig('driver');
                throw new \Exception($error);
                break;
        }
        $this->columns = array();
        $indices = (isset($indicesSql)) ? DB::select($indicesSql) : [];
        foreach (DB::select($columnsSql) as $columnInfo)
        {
            $column = new Column($this, $columnInfo->$column_name, $columnInfo, $indices);
            $this->columns[$column->getName()] = $column;
        }
        return $this->columns;
    }

    public function getAttributeTitle($attribute)
    {
        $value = $this->$attribute;
        $relation = $this->getRelation($attribute);
        if ($relation && $this->$relation)
        {
            $title = $this->$relation->getTitle();
        } else
        {
            $title = $value;
        }
        return $title;
    }

    /**
     * Get the related model, given an attribute name.
     * @param string $attr Can have trailing '_id'.
     */
    public function getBelongsTo($attr)
    {
        if (substr($attr, -3) == '_id')
        {
            $relationName = substr($attr, 0, -3);
            return $this->$relationName;
        }
        return false;
    }

    /**
     * Get the relation name for a given attribute.
     *
     * If an attribute name ends in '_id' then it is a foreign key, and has a
     * corresponding relation named the same but without the suffix.
     *
     * @param string $attr
     * @return string|false The relation name, or false if the attribute is not a relation.
     */
    public function getRelation($attr)
    {
        if (substr($attr, -3) == '_id')
        {
            return substr($attr, 0, -3);
        }
        return false;
    }

    public function getSlug()
    {
        return str_slug(str_plural(snake_case(class_basename($this), ' ')));
    }

    public function getTitle()
    {
        $titleAttr = 'title';
        foreach ($this->getColumns() as $col)
        {
            if ($col->isUnique())
            {
                $titleAttr = $col->getName();
            }
        }
        if (isset($this->$titleAttr))
        {
            return $this->$titleAttr;
        }
        return $this->id;
    }

    public function getUrl($action = '')
    {
        $url = snake_case(str_plural(class_basename($this)), '-');
        $url .= '/' . $this->id;
        $url .= ($action) ? "/$action" : "";
        return url($url);
    }

    /**
     * Shortcut to get the ID of a given model, based on its title.
     * @param string $title
     * @return integer
     */
    public static function getId($title)
    {
        return self::firstOrCreate(array('title' => $title))->id;
    }

    /**
     * Set a belongs-to relation, creating the foreign entity if it doesn't already exist.
     * @param string $rel
     * @param string $title
     */
    public function setBelongsTo($rel, $title)
    {
        $exists = $this->$rel->first();
        if (!$exists->id)
        {
            
        }
    }

}
