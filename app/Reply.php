<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'user_id', 'complaint_id', 'content', 'from_assigned_user_id', 'to_assigned_user_id',
    ];

    public function attachments()
    {
        return $this->hasMany('HCMS\Attachment');
    }

    public function user()
    {
        return $this->belongsTo('HCMS\User');
    }
}
