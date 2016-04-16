<?php

namespace HCMS;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'contact_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $types = [
        'administrator'  => 'Administrator',
        'representative' => 'Health Facility Representative',
        'handler'        => 'Complaint Handler',
        'reviewer'       => 'Complaint Reviewer',
        'complainant'    => 'Complainant',
    ];

    public function getTypeAttribute($value)
    {
        return array_key_exists($value, static::$types) ?
            static::$types[$value] :
            'Complainant';
    }

    public function isAdministrator()
    {
        return $this->is('administrator');
    }

    public function is($type)
    {
        return $this['attributes']['type'] === $type;
    }
}
