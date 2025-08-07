<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post; // Use your actual Post model
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    // Show all posts in admin dashboard
    public function index()
    {
        $posts = Post::all();
        return view('admin.dashboard', compact('posts'));
    }

    // Approve a post by ID
    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'approved';
        $post->save();

        Session::flash('success', 'Post approved successfully.');
        return redirect()->back();
    }

    // Reject a post by ID
    public function reject($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'rejected';
        $post->save();

        Session::flash('error', 'Post rejected.');
        return redirect()->back();
    }

    // Delete a post by ID
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        Session::flash('success', 'Post deleted.');
        return redirect()->back();
    }
}
