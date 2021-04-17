<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookLanguageController extends Controller
{
    public function index()
    {
        return view('languages.index')->with('languages', BookLanguage::all());
    }
    public function create()
    {
        return view('languages.create');
    }
    public function edit(BookLanguage $language)
    {
        return view('languages.edit', compact('language'));
    }
    public function update(Request $request, BookLanguage $language)
    {
        $validated = $this->validated();
        if(DB::transaction(function ()use($validated, $language) {
            $oldCode = $language->Code;
            $language->update($validated);
            if($oldCode !== $validated['Code'])
            {
                ini_set('max_execution_time', 600);
                foreach($language->books()->with('copies')->select([Book::KEY])->get() as $book)
                {
                    $book->update([$book->getKeyName() => $book->categoryCode.$language->Code.$book->numericId]);
                    foreach($book->copies()->select(BookCopy::KEY)->get() as $copy)
                    {
                        $copy->update([$copy->getKeyName() => $copy->categoryCode.$language->Code.$copy->numericId]);
                    }
                }
            }
            return true;
        })){
            return redirect(route('languages.index'));
        }
        throw new HttpException(500, 'لا يمكن تعديل اللغة');
    }
    public function store(Request $request)
    {
        $validated = $this->validated();
        if(BookLanguage::create($validated))
        {
            return redirect(route('languages.index'));
        }
        return "لا يمكن إنشاء اللغة";
    }
    public function destroy(BookLanguage $language)
    {
        if($language->rentals()->count() > 0)
        {
            request()->wantsJson()
            ? response()->json(['success' => false, 'message' => 'يوجد كُتب معارة من هذه اللغة'])
            : 'يوجد كُتب معارة من هذه اللغة';
        }
        if($language->delete())
        {
            return request()->wantsJson()
            ? response()->json(['success' => true, 'message' => 'تم الحذف'])
            : redirect(route('languages.index'));
        }
        request()->wantsJson()
            ? response()->json(['success' => false, 'message' => 'خطأ غير معروف'])
            : "لا يمكن حذف الفئة";
    }

    public function validated()
    {
        $validated = Validator::make(request()->all(), $this->rules(), $this->messages())->validate();
        $validated['Code'] = strtoupper($validated['Code']);
        return $validated;
    }
    public function rules()
    {
        $unique = Rule::unique(BookLanguage::class, 'Code');
        if(request()->method() !== 'POST')
        {
            $unique->ignore(request()->route('language'), BookLanguage::KEY);
        }
        return [
            'Code' => ['required','max:1','min:1', $unique],
            'Name' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'Code.required' => 'رمز اللغة إجباري',
            'Code.max' => 'رمز اللغة يجب أن يكون حرف واحد',
            'Code.unique' => 'هذه اللغة موجودة',
            'Code.min' => 'رمز اللغة يجب أن يكون حرف واحد',
            'Name.required' => 'اسم اللغة إجباري'
        ];
    }
}
