<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    function activities() {
        if(!file_exists(public_path('tmp/' . Auth::user()->user_id)))
            mkdir(public_path('tmp/' . Auth::user()->user_id));

        $file = fopen(public_path('tmp/' . Auth::user()->user_id) . '/activities.csv', 'w');

        fputcsv($file, array('Activite', 'Date'), ';');

        $activities = Auth::user()->orderedActivity();

        foreach($activities as $activity)
            fputcsv($file, [$activity->activity_label, date('d / m / Y - H\hi', strtotime($activity->activity_date))], ';');

        fclose($file);

        return redirect(asset('tmp/' . Auth::user()->user_id . '/activities.csv'));
    }
}
