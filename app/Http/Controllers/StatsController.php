<?php

namespace App\Http\Controllers;

use App\Search\StatSearch;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function stats(Request $request)
    {
        $formData = array_merge($request->all(), [
            'starttime' => trim($request->get('startdate') . ' ' . $request->get('starttime')),
            'endtime' => trim($request->get('enddate') . ' ' . $request->get('endtime'))
        ]);

        $ps = new StatSearch($formData);

        $result = $ps->search();

        $result = $result ? json_decode($result, true) : [];
        $data = (isset($result['succeed']) && $result['succeed']) ? $result : [];

        $start_date_time = explode(' ', $ps->getStartTime());
        $end_date_time = explode(' ', $ps->getEndTime());


        if ($request->get('CSV') === 'YES') {
            return $this->processCSV([$data], 'stats.csv');
        }
//        dd($data);
        return view('players.stats', [
            'data' => $data,
            'games' => $ps->validGames(),
            'availableEventTypes' => $ps->eventTypes(),
            'availableFilterTypes' => $ps->eventFilterTypes(),

            'startdate' => $start_date_time[0],
            'starttime' => $start_date_time[1],

            'enddate' => $end_date_time[0],
            'endtime' => $end_date_time[1],
        ]);
    }
}
