<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['name','mobile','title','email','message','status'];
    public function status()
    {
        return $this->status == 0 ?  __('New') : __('Read');
    }
}
