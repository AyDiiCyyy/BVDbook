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
                            ->having('Comments_count', '>', 0)
                           ->orderBy('Comments_count', 'desc')
                           ->paginate(10);
    // dd($products);
        return view('admin.comments.index', compact('products'));
    }
    public function show(Request $request, $id)
    {
        $product = Product::with('Comments.User')->find($id);
        
        // Lấy tham số ngày từ request
        $filterDate = $request->input('filter_date');
    
        // Lấy bình luận với điều kiện lọc theo ngày
        $comments = $product->Comments()->with('User')
            ->when($filterDate, function ($query) use ($filterDate) {
                return $query->whereDate('created_at', $filterDate);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('admin.comments.show', compact('product', 'comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        
        return redirect()->back()->with('status_succeed', 'Bình luận đã bị xóa.');
    }

}
