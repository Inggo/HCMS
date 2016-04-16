<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;
use HCMS\User;
use Auth;

class Complaint extends Model
{
    protected $fillable = [
        'title', 'hospital_id', 'user_id', 'status',
    ];

    protected static $statuses = [
        'new'      => 'New',
        'open'     => 'Open',
        'resolved' => 'Resolved',
    ];

    public function getStatusAttribute($value)
    {
        return array_key_exists($value, static::$statuses) ?
            static::$statuses[$value] :
            'New';
    }

    public function user()
    {
        return $this->belongsTo('HCMS\User');
    }

    public function assignedUser()
    {
        return $this->belongsTo('HCMS\User', 'assigned_user_id');
    }

    public function isViewableBy(User $user)
    {
        if ($this->wasCreatedBy($user) ||
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

    public function scopeIsViewable($query)
    {
        return $query->where('assigned_user_id', Auth::user()->id)
                    ->orWhere('user_id', Auth::user()->id)
                    ->orWhereHas('replies', function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    });
    }

    public function assignToReviewer()
    {
        // Search for reviewer
        $reviewer = User::reviewer()->first();

        // Assign to reviewer
        $this->assigned_user_id = $reviewer->id;

        // Save
        $this->save();
    }

    public static function boot()
    {
        Complaint::created(function ($complaint) {
            $complaint->assignToReviewer();
        });
    }
}
