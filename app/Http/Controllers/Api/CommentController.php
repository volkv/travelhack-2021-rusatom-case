<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class CommentController
 * @package App\Http\Controllers\Api
 */
class CommentController extends Controller
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Model $model
     * @return AnonymousResourceCollection
     */
    public function index(Model $model): AnonymousResourceCollection
    {
        return CommentResource::collection(
            $model->comments()->where('approved', 1)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Model $model
     * @return CommentResource
     */
    public function store(Model $model): CommentResource
    {
        $commentClass = config('comments.model');
        $comment = new $commentClass;

        $comment->commenter()->associate(auth()->user());
        $comment->commentable()->associate($model);
        $comment->comment = request()->get('comment');
        $comment->child_id = request()->get('parent_id');
        $comment->approved = config('comments.approval_required');

        $comment->save();

        return new CommentResource($comment);
    }
}
