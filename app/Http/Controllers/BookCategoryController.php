<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookCategoryController extends Controller
{
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Code' => 'required|unique:'.Category::TABLE.',Code',
            'Name' => 'required'
        ],[
            'Code.required' => 'رمز الفئة إجباري',
            'Code.unique' => 'هذه الفئة موجودة',
            'Name.required' => 'اسم الفئة إجباري'
        ]);
        if(Category::create($validated))
        {
            return redirect(route('categories.index'));
        }
        return "لا يمكن إنشاء الفئة";
    }
    public function destroy(Category $category)
    {
        if($category->books()->count() !== 0)
        {
            return AppHelper::ArabicFormat("يوجد ؟ كتاب تحمل هذه الفئة: ؟", [$category->books()->count(), $category->Name]);
        }
        if($category->delete())
        {
            return redirect(route('categories.index'));
        }
        return "لا يمكن حذف الفئة";
    }
}
