<?php
 
 namespace App\Repositories\Question;

use App\Models\Question;
use Illuminate\Support\Carbon;

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
            $QuestionsTable->questionImage      = '';
            $current                            = Carbon::now()->format('YmdHs');

            //File Upload-------------------------------
                $opt_imga = $data['opta']->getClientOriginalName();
                $opt_imgb = $data['optb']->getClientOriginalName();
                $opt_imgc = $data['optc']->getClientOriginalName();
                $opt_imgd = $data['optd']->getClientOriginalName();

                $data['opta']->storeAs('QuestionImg',$current.$opt_imga);
                $data['optb']->storeAs('QuestionImg',$current.$opt_imgb);
                $data['optc']->storeAs('QuestionImg',$current.$opt_imgc);
                $data['optd']->storeAs('QuestionImg',$current.$opt_imgd);
                

            

            $array=[
                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $current.$opt_imga,
                    'is_answer'             => $data['Radio2']==1 ? true : false,  ],

                [
                    'answer_option_id'      => 2, 
                    'OptB'                  => $current.$opt_imgb,
                    'is_answer'             =>$data['Radio2']==2 ? true : false, ],

                [
                    'answer_option_id'      => 3, 
                    'OptC'                  => $current.$opt_imgc,
                    'is_answer'             => $data['Radio2']==3 ? true : false, ],

                [
                    'answer_option_id'      => 4,   
                    'OptD'                  => $current.$opt_imgd,
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




    public static function edit($id) 
    {
           return Question::find($id);
    }


    public static function update($details)
    {
        $id                             = $details['id'];
        $QuestionsTable                 = Question::find($id);
        $QuestionsTable->exists         = true;
        $current                        = Carbon::now()->format('YmdHs');

        if($details['type']==0)
        {
            $QuestionsTable->question       = $details['question'];
            $QuestionsTable->points         = $details['points3'];
            $QuestionsTable->questionImage  = '';
            
            
            $updatearray=[
    
                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $details['option0'],
                    'is_answer'             => $details['customRadio2']==1 ? true : false,  ],
                    
                [
                    'answer_option_id'      => 2, 
                    'OptB'                  => $details['option1'],
                    'is_answer'             => $details['customRadio2']==2 ? true : false,  ],
    
                [
                    'answer_option_id'      => 3, 
                    'OptC'                  => $details['option2'],
                    'is_answer'             => $details['customRadio2']==3 ? true : false,  ],
                    
                [
                    'answer_option_id'      => 4, 
                    'OptD'                  => $details['option3'],
                    'is_answer'             => $details['customRadio2']==4 ? true : false,  ]
                    
                ];
                
                $QuestionsTable->answer_options = $updatearray;
    
                $QuestionsTable->save();
    

        }


        // ---------------------------------------------------------------------------------------------------------------------Type 2


        if($details['type']==1)
        {

            $QuestionsTable->question       = $details['questionn'];
            $QuestionsTable->points         = $details['points2'];
            $QuestionsTable->questionImage  = '';


            $opt_imga = $details['opta0']->getClientOriginalName();
            $opt_imgb = $details['opta1']->getClientOriginalName();
            $opt_imgc = $details['opta2']->getClientOriginalName();
            $opt_imgd = $details['opta3']->getClientOriginalName();

            $details['opta0']->storeAs('QuestionImg',$current.$opt_imga);
            $details['opta1']->storeAs('QuestionImg',$current.$opt_imgb);
            $details['opta2']->storeAs('QuestionImg',$current.$opt_imgc);
            $details['opta3']->storeAs('QuestionImg',$current.$opt_imgd);
            
            
            $updatearray=[
    
                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $current.$opt_imga,
                    'is_answer'             => $details['Radio2']==1 ? true : false,  ],
                    
                [
                    'answer_option_id'      => 2, 
                    'OptB'                  => $current.$opt_imgb,
                    'is_answer'             => $details['Radio2']==2 ? true : false,  ],
    
                [
                    'answer_option_id'      => 3, 
                    'OptC'                  => $current.$opt_imgc,
                    'is_answer'             => $details['Radio2']==3 ? true : false,  ],
                    
                [
                    'answer_option_id'      => 4, 
                    'OptD'                  => $current.$opt_imgd,
                    'is_answer'             => $details['Radio2']==4 ? true : false,  ]
                    
                ];
                
                $QuestionsTable->answer_options = $updatearray;
    
                $QuestionsTable->save();
    

        }



        if($details['type']==2)
        {
            $QuestionsTable                 = Question::find($id);
            $QuestionsTable->question       = $details['questionnn'];
            $QuestionsTable->points         = $details['points1'];
            $imageName                      = $details['qimage']->getClientOriginalName();
            $details['qimage']->storeAs('QuestionImg',$current.$imageName);
            $QuestionsTable->questionImage  = $current.$imageName;


            $optionArray                    = [

                [
                    'answer_option_id'      => 1, 
                    'OptA'                  => $details['optionna0'],
                    'is_answer'             => $details['customRadio3']==1 ? true : false,  ],

                [
                    'answer_option_id'      => 2, 
                    'OptB'                  => $details['optionna1'],
                    'is_answer'             => $details['customRadio3']==1 ? true : false,  ],

                [
                    'answer_option_id'      => 3, 
                    'OptC'                  => $details['optionna2'],
                    'is_answer'             => $details['customRadio3']==1 ? true : false,  ],

                [
                    'answer_option_id'      => 4, 
                    'OptD'                  => $details['optionna3'],
                    'is_answer'             => $details['customRadio3']==1 ? true : false,  ],
                ];

                $QuestionsTable->answer_options = $optionArray;
                
                $QuestionsTable->save();


        }
       

    }



 }
























 












?>