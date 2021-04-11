<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Code' => 'required|max:1|min:1|unique:'.BookLanguage::TABLE.',Code',
            'Name' => 'required'
        ],[
            'Code.required' => 'رمز اللغة إجباري',
            'Code.max' => 'رمز اللغة يجب أن يكون حرف واحد',
            'Code.unique' => 'هذه اللغة موجودة',
            'Code.min' => 'رمز اللغة يجب أن يكون حرف واحد',
            'Name.required' => 'اسم اللغة إجباري'
        ]);
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
            return "يوجد كُتب تحمل هذه اللغة" . " " . $language->Code;
        }
        if($language->delete())
        {
            return redirect(route('languages.index'));
        }
        return "لا يمكن حذف اللغة";
    }
}
