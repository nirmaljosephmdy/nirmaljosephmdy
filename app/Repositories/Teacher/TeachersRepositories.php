<?php

namespace App\Repositories\Teacher;

use App\Models\Admin;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class TeachersRepositories
{

    public static function getTeacherDetails($id)
    {
        return Admin::find($id);
    }


}

    









































?>
