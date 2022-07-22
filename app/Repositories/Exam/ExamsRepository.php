<?php

namespace App\Repositories\Exam;

use App\Models\Exam;

class ExamsRepository
{

    public static function store($examdetails)
    {
        $exam= new Exam;

        $exam->title        = $examdetails['title'];
        $exam->rule         = $examdetails['instructions'];
        $exam->questions    = $examdetails['questions'];
        $exam->save();

    }


    public static function datatable($id)
    {
        dd($id);
        
    }



















}





























?>