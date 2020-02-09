<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //enable query log
        //  \DB::enableQueryLog();
        //se cargan todos los Questions, CON el modelo de usuario para evitar varios results
        $questions = Question::with('user')->latest()->paginate(5);
        // $questions = Question::latest()->paginate(5);
        //se muestra la vista
        return view('questions.index', compact('questions'));
        // view('questions.index', compact('questions'))->render();

        //  dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $question = new Question();
        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //usar Request hecho AskQuestionRequest
    public function store(AskQuestionRequest $request)
    {
        // $request->user()->questions()->create($request->only('title', 'body'));
        $request->user()->questions()->create($request->all());
        return redirect()->route('questions.index')->with('success', 'Pregunta creada...' . $request->title);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //mostrar pregunta
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //mostrar view edit
        // dd($question);
        $question = Question::find($question->id);
        return view("questions.edit", compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        //Recibir Request AskQuestionRequest y actualizar $question inyectado
        // dd('request en update: ' . $request . ' y question: ' . $question);

        $question->update($request->only('title', 'body'));
        return redirect('/questions')->with('success', 'La pregunta ' . $request->title . ' ha sido actualizada...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //borrar question inyectado
    }
}
