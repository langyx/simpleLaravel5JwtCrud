<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    //
    protected $fillable = ["id"];

    public $with = [
        'promoType'
    ];


    public function users() {
        return $this->hasMany(User::class);
    }

    public function promoType()
    {
        return $this->belongsTo(PromoType::class, "promo_type_id");
    }
}
