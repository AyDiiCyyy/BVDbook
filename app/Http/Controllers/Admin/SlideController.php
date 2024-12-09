<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slide\StoreSlideRequest;
use App\Http\Requests\Slide\UpdateSlideRequest;
use App\Models\Slide;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    use StorageImageTrait;
    const PAGINATION = 5;
    public function index(){
        $slides = Slide::orderBy('order')->orderBy('id', 'desc')->paginate(self::PAGINATION);
        return view('admin.slides.index', compact('slides'));

    }

    public function create(){
        $title = 'Thêm mới slide';
        return view('admin.slides.add', compact('title'));
    }

    public function store(StoreSlideRequest $request){
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'order'=> $request->order,
            'active'=> $request->active ?? 0
        ];
        $data['image'] = StorageImageTrait::storageTraitUpload($request, 'image', 'slides')['path'] ?? '';
        
        $slide = Slide::create($data);
        return redirect()->route('admin.slide.index')->with('status_succeed', 'Thêm slide thành công');
    }
    public function edit($id){
        $title = "Sửa slide";
        $slide = Slide::find($id);
        return view ('admin.slides.update', compact('title', 'slide'));
    }
    public function update(UpdateSlideRequest $request, $id){
        $slide = Slide::find($id);
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'order' => $request->order,
            'active' => $request->active ?? 0

        ];
        $data['image'] = StorageImageTrait::storageTraitUpload($request, 'image', 'slides')['path'] ?? $slide->image;
        if ($request->hasFile('image')) {
            $path = 'public/slides/' . basename($slide->image);
            if (Storage::exists($path)) {
                Storage::delete($path);
            
            }
        }
        $slide->update($data);
        return redirect()->route('admin.slide.index')->with('status_succeed', 'Cập nhật slide thành công');
    }
    public function changeActive(Request $request)
    {
        $item = Slide::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();
        return $item;           
    }
    public function changeOrder(Request $request)
    {
        $item = Slide::find($request->id);
        $item->order = $request->order;
        $item->save();
        return $item;
    }
}

