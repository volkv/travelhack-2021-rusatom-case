<?php


namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'parent_id'         => $this->child_id,
            'rating'            => $this->average_rating,
            'user_rating'       => $this->user_rating,
            'rating_count'      => $this->rating_count
        ]);
    }
}
