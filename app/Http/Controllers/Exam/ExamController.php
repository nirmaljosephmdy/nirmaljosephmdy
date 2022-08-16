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
        $examType=ExamsRepository::examRegistration();
        return view('adminpanel.exam.add2',compact('examType'));

    }

    public function confirm(Request $request)
    {
        $file=false;
        if($request->hasFile('QImage'))
        {
            $file=true;
        }
        $ExamQ=$request->all();
        ExamsRepository::examQuestion($ExamQ,$file);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        // $req=$request->all();
        // $examId=$id;
        // ExamsRepository::datatable($req,$examId);

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
                 "question"  =>$record->question, 
                 "points"    =>$record->points,
                 "action"    =>'<a href=" # "  data-id='.$record->id.' id='.$record->id.'  class="btn btn-primary btn-sm actionedit" title="Add" >
                 <i class="fas fa-solid fa-plus"></i>
                 
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return ExamsRepository::edit($id);

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
