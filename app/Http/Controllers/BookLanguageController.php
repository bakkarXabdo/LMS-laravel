<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\BookLanguage;
use Illuminate\Http\Request;

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
    public function update(Request $request, BookLanguage $langauge)
    {
        $validated = $this->validate($request, $this->rules(), $this->messages());
        $langauge->update($validated);
        return redirect(route('languages.index'));
    }
    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->rules(), $this->messages());
        if(BookLanguage::create($validated))
        {
            return redirect(route('languages.index'));
        }
        return "لا يمكن إنشاء اللغة";
    }
    public function destroy(BookLanguage $language)
    {
        if($language->books()->count() !== 0)
        {
            return AppHelper::ArabicFormat("يوجد ؟ كتاب تحمل هذه اللغة: ؟", [$language->books()->count(), $language->Name]);
        }
        if($language->delete())
        {
            return redirect(route('languages.index'));
        }
        return "لا يمكن حذف اللغة";
    }

    public function rules()
    {
        return [
            'Code' => 'required|max:1|min:1|unique:'.BookLanguage::TABLE.',Code',
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
