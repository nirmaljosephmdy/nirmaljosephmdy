<?php
 
 namespace App\Repositories\Question;

use App\Models\Question;

 class QuestionsRepository
 {

    public static function store($data)
    {
        if($data['type']==0)
        {
            $QuestionsTable                     = new Question;
            

            $QuestionsTable->question_type      = $data['type'] ?? '';
            $QuestionsTable->question           = $data['question'] ?? '';
            $QuestionsTable->questionImage      = $data['qimage'] ?? '';
            

            $array=[
                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $data['Optiona'],
                    'is_Correct_answer'     =>'false'],

                [
                    'answer_option_id'      => 1, 
                    'OptB'                  => $data['Optionb'],
                    'is_Correct_answer'     =>'false'],

                [
                    'answer_option_id'      => 1, 
                    'OptB'                  => $data['Optionc'],
                    'is_Correct_answer'     =>'True'],

                [
                    'answer_option_id'      => 1, 
                    'OptB'                  => $data['Optiond'],
                    'is_Correct_answer'     =>'False']

                    ];

                    
                    $QuestionsTable->answer_options =$array ?? '';

                    $QuestionsTable->save();


            
            

        }

    }



 }
























 












?>