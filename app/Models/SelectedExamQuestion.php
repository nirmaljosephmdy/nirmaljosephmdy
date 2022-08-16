<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class SelectedExamQuestion extends Authenticatable
{
    use HasFactory;
    protected $collection='SelectedExamQuestion';

}
