<?php

namespace App\Repositories\Teacher;

use App\Models\Admin;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class TeachersRepositories
{


    public function fetchstaff(Request $request)
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
            $totalRecords =  Admin::select('count(*) as allcount')->where('role',2)->count();
            //    dd('de',$totalRecords);
            $totalRecordswithFilter = Admin::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

            $optionArray = config('options');


            // Fetch records

                $query = Admin::orderBy($columnName,$columnSortOrder)->where('role',2);

                if($searchValue){
                    $query->where(function($sec_query) use ($searchValue){
                        $sec_query->where('name', 'LIKE', '%'.$searchValue.'%');
                        $sec_query->orWhere('email', 'LIKE', '%'.$searchValue.'%');
                        $sec_query->orWhere('gender', 'LIKE', '%'.$searchValue.'%');
                        $sec_query->orWhere('status', 'LIKE', '%'.$searchValue.'%');
                    });
                }

                $records = $query->select('*')
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();

            $data_arr = array();
            //    dd($records);
            foreach($records as $record){

                $data_arr[] = array(
                    "id"        => $record->_id,
                    "name"      =>$record->name,
                    "email"     =>$record->email,
                    "permission"=>$record->usertype,
                    "gender"    =>$record->gender,
                    "status"    =>$record->status,
                    "action" =>' <a class="btn btn-info btn-sm actionedit" title="edit category" href="'.route('teacheredit',$record->id).'" >
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-danger btn-sm actionDelete" data-href="'.route('teacherdelete',$record->id).'">
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
            /////////////////////////////////////////////////



    }

    }









































?>
