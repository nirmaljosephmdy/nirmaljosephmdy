<?php

namespace App\Repositories\Exam;

use App\Models\Exam;
use App\Models\Question;

class ExamsRepository
{

    public static function store($examdetails)
    {
        $exam= new Exam;

        $exam->title        = $examdetails['title'];
        $exam->rule         = $examdetails['instructions'];

        $exam->save();

    }

    public static function examRegistration()
    {
        $examType=[];
        $exam = Exam::get();
        foreach($exam as $key=> $examTypee)
        {
            $examType[$key]['id']=$examTypee['id'];
            $examType[$key]['title']=$examTypee['title'];

        }
        return $examType;

    }


    public static function datatable($request,$id)
    {



        ## Read value
        $draw               = $request->get('draw');
        $start              = $request->get("start");
        $rowperpage         = $request->get("length"); // Rows display per page

        $columnIndex_arr    = $request->get('order');
        $columnName_arr     = $request->get('columns');
        $order_arr          = $request->get('order');
        $search_arr         = $request->get('search');

        $columnIndex        = $columnIndex_arr[0]['column']; // Column index
        $columnName         = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder    = $order_arr[0]['dir']; // asc or desc
        $searchValue        = $search_arr['value']; // Search value

        // Total records
        $totalRecords           = Question::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Question::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $query                  = Question::orderBy($columnName,$columnSortOrder);

            if($searchValue){

                    $query->where(function($sec_query) use ($searchValue){
                    $sec_query->where('question', 'LIKE', '%'.$searchValue.'%');
                    $sec_query->orWhere('points', 'LIKE', '%'.$searchValue.'%');

                });
            }


            $records = $query->select('*')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

        $data_arr = array();
        
        $loop=1; 
        foreach($records as $record){

            $data_arr[] = array(
                "sl"        =>$loop,
                // "id"        =>$record->id,
                "question"  =>$record->question, 
                // "image"     =>$record->questionImage ?? '',
                "points"    =>$record->points,
                // "type"      =>$record->question_type,
                "action"    =>'<a href=" '.route('question.edit',['question_id'=>$record->id]).' "  data-id='.$record->id.'  class="btn btn-primary btn-sm actionedit" title="edit category" >
                             <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm actionDelete" href=" '.route('question.remove',['remove_id'=>$record->id]).'">
                        <i class="fas fa-trash"></i>
                    </a>'
            );
            $loop++;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );


        return response()->json($response);
//
}



public static function edit($id)
{
    return Question::find($id);
}
        


    }

















































?>