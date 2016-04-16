<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function reply()
    {
        return $this->belongsTo('HCMS\Reply');
    }
}
