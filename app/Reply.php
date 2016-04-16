<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'complaint_id', 'content'
    ];

    public function attachments()
    {
        return $this->hasMany('HCMS\Attachment');
    }
}
