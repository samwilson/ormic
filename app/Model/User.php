<?php namespace Ormic\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Base implements AuthenticatableContract {

    use Authenticatable;

    protected $rules = array(
        'username' => 'unique:users'
    );

    public function canCreate()
    {
        $isAdmin = (isset($this->user) && $this->user->isAdmin());
        $isFirst = self::count() == 0;
        return ($isAdmin || $isFirst);
    }

    public function onCreated(User $user)
    {
        if (User::count() == 1 && !$user->isAdmin())
        {
            $attrs = array('name' => 'Administrator');
            $adminRole = Role::where($attrs)->first();
            if (!$adminRole)
            {
                $adminRole = new Role($attrs);
                $adminRole->setUser($user);
                $adminRole->save();
            }
            $user->roles()->attach($adminRole->id);
        }

        $user->setUser($user);
    }

    public function roles()
    {
        return $this->belongsToMany('Ormic\Model\Role');
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value;
        if (empty($this->attributes['name']))
        {
            $this->attributes['name'] = $value;
        }
    }

    /**
     * Whether this User has a Role with the given name.
     * @param string $roleName
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', '=', $roleName)->count() == 1;
    }

    public function isAdmin()
    {
        return $this->roles()->where('id', '=', Role::ADMIN_ID)->count() > 0;
    }

}
