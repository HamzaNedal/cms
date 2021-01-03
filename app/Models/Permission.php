<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Mindscms\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $guarded = [];
}