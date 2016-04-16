<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;
use HCMS\User;

class Complaint extends Model
{
    protected $fillable = [
        'title', 'hospital_id', 'user_id',
    ];

    protected static $statuses = [
        'new'      => 'New',
        'open'     => 'Open',
        'resolved' => 'Resolved',
    ];

    public function isViewableBy(User $user)
    {
        if ($this->wasOwnedBy($user) ||
                $this->isAssignedTo($user) ||
                $this->wasRespondedBy($user)) {
            return true;
        }

        return false;
    }

    public function isAssignedto(User $user)
    {
        return $this->assigned_user_id === $user->id;
    }

    public function wasCreatedBy(User $user)
    {
        return $this->user_id === $user->id;
    }

    public function wasRespondedBy(User $user)
    {
        return $this->replies()->where('user_id', $user->id)->count() > 0;
    }

    public function replies()
    {
        return $this->hasMany('HCMS\Reply');
    }
}
