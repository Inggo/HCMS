<?php

namespace HCMS;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected static $statuses = [
        'new'      => 'New',
        'open'     => 'Open',
        'resolved' => 'Resolved',
    ];
}
