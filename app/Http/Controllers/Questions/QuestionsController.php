<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Repositories\Question\QuestionsRepository;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminpanel.question.add'); 
        
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
    public function store(Request $request)
    {
        $Questions  = $request->all();
        QuestionsRepository::store($Questions);
        return json_encode(['status'=>true,"redirect_url"=>url('questions/add')]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('adminpanel.question.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $QuestionDetails    =QuestionsRepository::edit($id);
        return view('adminpanel.question.edit',compact('QuestionDetails'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $updateDetails  = $request->all();
        QuestionsRepository::update($updateDetails);
        
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



    public function datatable(Request $request)
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
                                    "id"        =>$record->id,
                                    "question"  =>$record->question, 
                                    "image"     =>$record->questionImage ?? '',
                                    "points"    =>$record->points,
                                    "type"      =>$record->question_type,
                                    "action"    =>'<a href=" '.route('question.edit',['question_id'=>$record->id]).' "  data-id='.$record->id.'  class="btn btn-primary btn-sm actionedit" title="edit category" >
                                                 <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm actionDelete" href=" '.route('teacher.remove',['remove'=>$record->id]).'">
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



}
