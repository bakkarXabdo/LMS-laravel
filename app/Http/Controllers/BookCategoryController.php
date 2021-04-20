<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
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
        $validated = $this->validated($request);
        if(Category::create($validated))
        {
            return redirect(route('categories.index'));
        }
        return "لا يمكن إنشاء الفئة";
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $validated = $this->validated($request);
        if(DB::transaction(function () use ($validated, $category) {
            $oldCode = $category->Code;
            $category->update($validated);
            if($oldCode !== $validated['Code'])
            {
                ini_set('max_execution_time', 600);
                foreach($category->books()->with('copies')->select([Book::KEY])->get() as $book)
                {
                    $book->update([$book->getKeyName() => $category->Code.$book->languageCode.$book->numericId]);
                    foreach($book->copies()->select([BookCopy::KEY])->get() as $copy)
                    {
                        $copy->update([BookCopy::KEY => $category->Code.$copy->languageCode.$copy->numericId]);
                    }
                }
            }
            return true;
        }))
        {
            return redirect(route('categories.index'));
        }
        throw new HttpException(500, 'لا يمكن تعديل الفئة');
    }


    public function destroy(Category $category)
    {
        if($category->rentals()->count() > 0)
        {
            request()->wantsJson()
            ? response()->json(['success' => false, 'message' => 'يوجد كُتب معارة من هذه الفئة'])
            : 'يوجد كُتب معارة من هذه الفئة';
        }
        if($category->delete())
        {
            return request()->wantsJson()
            ? response()->json(['success' => true, 'message' => 'تم الحذف'])
            : redirect(route('categories.index'));
        }
        request()->wantsJson()
            ? response()->json(['success' => false, 'message' => 'خطأ غير معروف'])
            : "لا يمكن حذف الفئة";
    }

    public function validated($request)
    {
        $validated = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributeNames())->validate();
        $validated['Code'] = strtoupper($validated['Code']);
        return $validated;
    }
    public function rules()
    {
        $unique = Rule::unique(Category::class, 'Code');
        if(request()->method() !== 'POST')
        {
            $unique->ignore(request()->route('category'), Category::KEY);
        }
        return [
            'Code' => ['required', 'alpha', $unique],
            'Name' => 'required'
        ];
    }
    public function messages()
    {
        return [
        ];
    }

    public function attributeNames()
    {
        return [
            'Code' => 'رمز الفئة',
            'Name' => 'إسم الفئة'
        ];
    }
}
