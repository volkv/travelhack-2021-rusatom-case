<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
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
    public function index(Model $model)
    {
        return CommentResource::collection(
            $model->comments->where('approved', 1)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Model $model
     * @return CommentResource
     */
    public function store(Model $model)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
