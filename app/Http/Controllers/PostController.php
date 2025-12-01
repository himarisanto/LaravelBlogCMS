<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'search']);
    }

    public function index(Request $request)
    {
    $posts = Post::query()
        ->with(['categories', 'author'])
        ->whereNotNull('published_at')
        ->when($request->filled('q'), function ($query) use ($request) {
            $q = $request->input('q');

            $query->where(function ($qry) use ($q) {
                $qry->where('title', 'like', "%{$q}%")
                    ->orWhere('body', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%");
            });
        })
        ->orderBy('published_at', 'desc')
        ->limit(10)
        ->get();

        return view('posts.index', compact('posts'));
    }


    public function show($slug)
    {
        $post = Post::with('categories', 'author', 'comments.user')->where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'categories' => 'array',
            'thumbnail' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date'
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);

        $post = Post::create($data);

        if (!empty($request->categories)) {
            $post->categories()->sync($request->categories);
        }

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post created');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'categories' => 'array',
            'thumbnail' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) Storage::disk('public')->delete($post->thumbnail);
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $post->update($data);
        $post->categories()->sync($request->categories ?? []);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post updated');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        if ($post->thumbnail) Storage::disk('public')->delete($post->thumbnail);
        $post->delete();
        return redirect()->route('home')->with('success', 'Post deleted');
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $posts = Post::whereNotNull('published_at')
            ->where(function ($qry) use ($q) {
                $qry->where('title', 'like', '%' . $q . '%')
                    ->orWhere('body', 'like', '%' . $q . '%');
            })->paginate(12);

        return view('posts.search', compact('posts', 'q'));
    }
}
