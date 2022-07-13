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
            $QuestionsTable->points             = $data['points'] ?? '';
            $QuestionsTable->questionImage      = '' ;
            

            $array=[
                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $data['Optiona'],
                    'is_answer'             => $data['radio']==1 ? true : false,  ],

                [
                    'answer_option_id'      => 2, 
                    'OptB'                  => $data['Optionb'],
                    'is_answer'             =>$data['radio']==2 ? true : false, ],

                [
                    'answer_option_id'      => 3, 
                    'OptC'                  => $data['Optionc'],
                    'is_answer'             => $data['radio']==3 ? true : false, ],

                [
                    'answer_option_id'      => 4,   
                    'OptD'                  => $data['Optiond'],
                    'is_answer'             => $data['radio']==4 ? true : false, ]

                    ];

                    
                    $QuestionsTable->answer_options =$array ?? '';

                    $QuestionsTable->save();

        }








        if($data['type']==1)
        {
            $QuestionsTable                     = new Question;
            

            $QuestionsTable->question_type      = $data['type'] ?? '';
            $QuestionsTable->question           = $data['questionn'] ?? '';
            $QuestionsTable->points             = $data['points2'] ?? '';

            //File Upload-------------------------------
                $opt_imga = $data['opta']->getClientOriginalName();
                $opt_imgb = $data['optb']->getClientOriginalName();
                $opt_imgc = $data['optc']->getClientOriginalName();
                $opt_imgd = $data['optd']->getClientOriginalName();

                $data['opta']->storeAs('QuestionImg',$opt_imga);
                $data['optb']->storeAs('QuestionImg',$opt_imgb);
                $data['optc']->storeAs('QuestionImg',$opt_imgc);
                $data['optd']->storeAs('QuestionImg',$opt_imgd);
                

            

            $array=[
                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $opt_imga,
                    'is_answer'             => $data['Radio2']==1 ? true : false,  ],

                [
                    'answer_option_id'      => 2, 
                    'OptB'                  => $opt_imgb,
                    'is_answer'             =>$data['Radio2']==2 ? true : false, ],

                [
                    'answer_option_id'      => 3, 
                    'OptC'                  => $opt_imgc,
                    'is_answer'             => $data['Radio2']==3 ? true : false, ],

                [
                    'answer_option_id'      => 4,   
                    'OptD'                  => $opt_imgd,
                    'is_answer'             => $data['Radio2']==4 ? true : false, ]

                    ];

                    
                    $QuestionsTable->answer_options =$array ?? '';

                    $QuestionsTable->save();


        }









        if($data['type']==2)
        {
            $QuestionsTable                     = new Question;
            

            $QuestionsTable->question_type      = $data['type'] ?? '';
            $QuestionsTable->question           = $data['questionnn'] ?? '';
            $QuestionsTable->points             = $data['points3'] ?? '';

            //File Upload-------------------------------
                $question_img = $data['qimage']->getClientOriginalName();
                $data['qimage']->storeAs('QuestionImg',$question_img);
                $QuestionsTable->questionImage = $question_img;

            

            $array=[
                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $data['optionna'],
                    'is_answer'             => $data['customRadio3']==1 ? true : false,  ],

                [
                    'answer_option_id'      => 2, 
                    'OptB'                  => $data['optionnb'],
                    'is_answer'             =>$data['customRadio3']==2 ? true : false, ],

                [
                    'answer_option_id'      => 3, 
                    'OptC'                  => $data['optionnc'],
                    'is_answer'             => $data['customRadio3']==3 ? true : false, ],

                [
                    'answer_option_id'      => 4,   
                    'OptD'                  => $data['optionnd'],
                    'is_answer'             => $data['customRadio3']==4 ? true : false, ]

                    ];

                    
                    $QuestionsTable->answer_options =$array ?? '';

                    $QuestionsTable->save();


        }








        

    }



 }
























 












?>