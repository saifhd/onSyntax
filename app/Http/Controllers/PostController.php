<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __invoke(PostCreateRequest $request)
    {
        dd($request->validated());
    }
}
