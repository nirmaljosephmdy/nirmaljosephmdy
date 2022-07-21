<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Exam\ExamRequest;
use App\Models\Exam;
use App\Models\Question;
use App\Repositories\Exam\ExamsRepository;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions =Question::get()->all();
        return view('adminpanel.exam.add',compact('questions'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamRequest $request)
    {
        $examdetails=$request->all();
        ExamsRepository::store($examdetails);
        return json_encode(['status'=>true,"redirect_url"=>url('exam/store2')]);
    }

    public function store2()
    {
        $examType=[];
        $exam = Exam::get();
        foreach($exam as $key=> $examTypee)
        {
            $examType[$key]['id']=$examTypee['id'];
            $examType[$key]['title']=$examTypee['title'];

        }
        return view('adminpanel.exam.add2',compact('examType'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
