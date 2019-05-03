<?php
/**
 * Created by PhpStorm.
 * User: yannis
 * Date: 03/05/2019
 * Time: 16:32
 */


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PromoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}