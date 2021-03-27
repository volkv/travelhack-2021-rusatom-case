<?php


namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'location'     => $this->location,
            'rating'       => $this->average_rating,
            'user_rating'  => $this->user_rating,
            'rating_count' => $this->rating_count
        ]);
    }
}
