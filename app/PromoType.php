<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoType extends Model
{
    //
    protected $fillable = [];
    public function promos() {
        return $this->hasMany(Promo::class);
    }
}
