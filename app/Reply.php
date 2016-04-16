<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function attachments()
    {
        return $this->hasMany('HCMS\Attachment');
    }
}
