<?php
/**
 * Created by PhpStorm.
 * User: yannis
 * Date: 03/05/2019
 * Time: 16:30
 */



namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'promo_type_id' => $this->promo_type_id,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'users' => $this->users,
        ];
    }
}
