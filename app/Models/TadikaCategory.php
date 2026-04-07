<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TadikaCategory extends Model
{
    protected $fillable = ['name'];

    public function tadikas()
    {
        return $this->hasMany(Tadika::class, 'tadika_category_id');
    }
}