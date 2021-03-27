<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param  Model $model
     * @return JsonResponse
     */
    public function toggle(Model $model)
    {
        $model->toggleFavorite();

        return (new FavoriteResource(null))
            ->response()
            ->setStatusCode(200);
    }
}
