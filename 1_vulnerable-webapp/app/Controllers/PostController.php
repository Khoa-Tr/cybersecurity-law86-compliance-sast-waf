<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // VULNERABILITY 3: CSRF
    // No CSRF token verification
    public function store(Request $request)
    {
        $post = new Post();
        
        // VULNERABILITY 2: CROSS-SITE SCRIPTING (XSS) - STORED
        // Store unsanitized input
        $post->content = $request->input('content');  // No sanitization
        $post->save();
        
        return redirect()->back();
    }

    public function show($id)
    {
        $post = Post::find($id);
        
        // VULNERABILITY 2: CROSS-SITE SCRIPTING (XSS) - STORED
        // Render without escaping
        return view('posts.show', ['content' => $post->content]);
    }
}
