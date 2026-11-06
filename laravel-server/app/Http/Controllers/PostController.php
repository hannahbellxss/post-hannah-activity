<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public $school = "Mindoro State University Congratulationsssss!";

   public function index()
{
    return response()->json(Post::all());
}
 
public function store(StorePostRequest $request)
{
    $post = Post::create($request->validated());
    return response()->json([
        'message' => 'Post created successfully',
        'data' => $post
    ], 201);
}

    public function read()
    {
        $message = "You are now currently enrolled to $this->school";

        return response()->json([
            'school' => $this->school,
            'message' => $message,
        ]);
    }

    public function greet($name)
    {
        $name = "Carlito";
        $message = "Hello, $name;";

        return response()->json([
            'name' => $name,
            'message' => $message,
        ]);
    }
}
