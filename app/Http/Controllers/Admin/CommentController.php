<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $products = Product::withCount('Comments')
                           ->orderBy('Comments_count', 'desc')
                           ->paginate(10);
    // dd($products);
        return view('admin.comments.index', compact('products'));
    }
    public function show(Request $request, $id)
    {
        $product = Product::with('Comments.User')->find($id);
        $comments = $product->Comments()->with('User')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comments.show', compact('product', 'comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        
        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã bị xóa.');
    }
    
    public function forceDestroy($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        $comment->forceDelete();
        
        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã bị xóa vĩnh viễn.');
    }
    
    public function restore($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        $comment->restore();
        
        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được khôi phục.');
    }


}
