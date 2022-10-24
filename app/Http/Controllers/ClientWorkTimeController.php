<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientWorkTimeController extends Controller
{
    public function update(Request $request, $client_id){
        error_log('ClientWorkTime@update called');
        error_log('time state is '.json_encode($request->input('timeState')));
        $client = Client::find($client_id);
        $timeState = $request->input('timeState');
        error_log(gettype($timeState));
        // dd($request->input('timeState'));
        if($timeState  == 'to24Hour'){
            error_log('change to 24hour');
            $client->activity_time = '24hour';
            $client->save();

        }
        if ($timeState  == 'toWorkDay') {
            error_log('change to workday');

            $client->activity_time = 'workday';
            $client->save();

        } 
        
        return redirect()->back();    
    }
}
