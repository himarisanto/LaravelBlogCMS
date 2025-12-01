<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'body'=>'required']);
        $data['user_id'] = auth()->id();
        Comment::create($data);
        return back()->with('success','Comment added');
    }
}
