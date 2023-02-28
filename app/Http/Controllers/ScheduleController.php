<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ScheduleController extends Controller
{
    public function index(){
        error_log("dit moet werken");
        Artisan::call('schedule:run');
    }
}
