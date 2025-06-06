<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб перейти на сторінку адміністратора.');
        }

        $questions = Faq::all();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:1000',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Запитання/відовідь створено успішно!!!');
    }

    public function edit(Faq $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Faq $question)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:1000',
        ]);

        $question->update($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Запитання/відовідь оновлено успішно!!!');
    }

    public function destroy(Faq $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Запитання/відовідь успішно видалено!!!');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $questions = Faq::where('question', 'LIKE', "%{$query}%")->get();

        return response()->json([
            'questions' => $questions
        ]);
    }
}
