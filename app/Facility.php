<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function complaints()
    {
        return $this->hasMany('HCMS\Complaint');
    }

    public function newComplaints()
    {
        return count($this->complaints()->where('status', 'new')->get());
    }

    public function openComplaints()
    {
        return count($this->complaints()->where('status', 'open')->get());
    }

    public function resolvedComplaints()
    {
        return count($this->complaints()->where('status', 'resolved')->get());
    }
}
