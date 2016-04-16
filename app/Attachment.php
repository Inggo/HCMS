<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'reply_id', 'filename'
    ];

    public function reply()
    {
        return $this->belongsTo('HCMS\Reply');
    }
}
