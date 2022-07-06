<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\Teacher\TeachersRepositories;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
             return view('adminpanel.teachers.list');

    }


    public function getstaff()
    {
        return view('adminpanel.teachers.add');
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

        if($request->ajax())
        {
             $registration= new Admin;


             $registration->name        = $request->name;
             $registration->email       = $request->email;
             $registration->usertype    = $request->usertype;
             $registration->gender      = $request->gender;


             $picturename  = $request->file('profilepic')->getClientOriginalName();
             $request->file('profilepic')->storeAs('ProfilePic',$picturename);

             $registration->profilepic  = $picturename;
             $registration->status      = 0;

             $registration->save();
             return response()->json(['Success'=>true]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd($id);
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

    public function datatable(Request $request)
    {
       
                    ## Read value
                    $draw = $request->get('draw');
                    $start = $request->get("start");
                    $rowperpage = $request->get("length"); // Rows display per page

                    $columnIndex_arr = $request->get('order');
                    $columnName_arr = $request->get('columns');
                    $order_arr = $request->get('order');
                    $search_arr = $request->get('search');

                    $columnIndex = $columnIndex_arr[0]['column']; // Column index
                    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                    $searchValue = $search_arr['value']; // Search value

                    // Total records
                    $totalRecords =  Admin::select('count(*) as allcount')->count();
                    $totalRecordswithFilter = Admin::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

                    $optionArray = config('options');


                    // Fetch records

                        $query   = Admin::orderBy($columnName,$columnSortOrder);

                        if($searchValue){
                            $query->where(function($sec_query) use ($searchValue){
                                $sec_query->where('name', 'LIKE', '%'.$searchValue.'%');
                                $sec_query->orWhere('email', 'LIKE', '%'.$searchValue.'%');
                                $sec_query->orWhere('gender', 'LIKE', '%'.$searchValue.'%');
                                $sec_query->orWhere('status', 'LIKE', '%'.$searchValue.'%');
                                $sec_query->orWhere('usertype', 'LIKE', '%'.$searchValue.'%');
                            });
                        }


                        $records = $query->select('*')
                                ->skip($start)
                                ->take($rowperpage)
                                ->get();

                    $data_arr = array();
                    
                    foreach($records as $record){
                        // ''
                        // '.route('teacherdelete',$record->id).'

                        if($record->usertype==1)
                        {
                            $permission ='Admin';
                        }
                        else
                        {
                            $permission ='Teacher';
                        }


                        if($record->status==1)
                        {
                            $status ='Active';
                        }
                        else
                        {
                            $status ='Inactive';
                        }
                        


                        $data_arr[] = array(
                            "id"        => $record->_id,
                            "name"      =>$record->name,
                            "email"     =>$record->email,
                            "gender"    =>$record->gender,
                            "permission"=>$permission,
                            "status"    =>$status,
                            "action" =>'<a class="btn btn-primary btn-sm actionedit" title="edit category" href='.route('teacheredit',$record->_id).' >
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-danger btn-sm actionDelete" data-href="#">
                                    <i class="fas fa-trash"></i>
                                </a>'
                        );
                    }

                    $response = array(
                        "draw" => intval($draw),
                        "iTotalRecords" => $totalRecords,
                        "iTotalDisplayRecords" => $totalRecordswithFilter,
                        "aaData" => $data_arr
                    );


                    return response()->json($response);


    }
}
