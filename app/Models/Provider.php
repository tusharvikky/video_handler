<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    public $guarded = 'id';

    public function meta()
    {
        return $this->hasMany('App\Models\ProviderMeta');
    }
}
