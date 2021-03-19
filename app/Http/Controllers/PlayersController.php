<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Search\PlayerSearch;
use App\Search\PrizesSearch;
use App\Search\StatSearch;
use Illuminate\Support\Collection;
use App\User;

class PlayersController extends Controller
{


    public function player(Request $request)
    {
        $ps = new PlayerSearch($request->all());

        $result = $ps->search();

        $data = $result ? json_decode($result, true) : [];

        $players = isset($data['players']) ? $data['players'] : [];


        if ($request->get('CSV') === 'YES') {
            return $this->processCSV($players, 'players.csv');
        }
        return view('pages.player.datatables', [
            'players' => $players,
            'games' => $ps->validGames(),
            'availableSizes' => $ps->availablePageSizes(),
            'pageDiff' => $ps->pageDiff(),
            'pageSize' => $ps->getPageSize(),
            'prev' => $ps->prviousPage(),
            'next' => $ps->nextPage(count($players)),
        ]);

    }


    public function prizes(Request $request)
    {

        $ps = new PrizesSearch($request->all());
        $result = $ps->search();

        $data = $result ? json_decode($result, true) : [];

        $players = isset($data['players']) ? $data['players'] : [];

        if ($request->get('CSV') === 'YES') {
            return $this->processCSV($players, 'prizes.csv');
        }

        return view('players.prizes', [
            'players' => $players,
            'games' => $ps->validGames(),
            'promotypes' => $ps->validPromoTypes(),
            'availableSizes' => $ps->availablePageSizes(),
            'pageDiff' => $ps->pageDiff(),
            'pageSize' => $ps->getPageSize(),
            'prev' => $ps->prviousPage(),
            'next' => $ps->nextPage(count($players)),
            'chartData' => $ps->processPrizesForChart($players)
        ]);

    }


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


    protected function processCSV($data, $name)
    {

        try {
            $f = fopen('php://memory', 'r+');

            if (!empty($data[0])) {
                fputcsv($f, array_keys($data[0]));
            }

            foreach ($data as $d) {
                if (!empty($d['timestamp'])) {
                    $d['timestamp'] = date('d M, Y; H:i a', ($d['timestamp'] / 1000));
                }
                fputcsv($f, $d);
            }

            rewind($f);

            $content = rtrim(stream_get_contents($f));

            fclose($f);


            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=' . $name,
            ];

            return response()->make($content, 200, $headers);
        } catch (\Exception $ex) {
            return response('Sorry, could not convert data to CSV. Please, try again later.', 404);
        }
    }

}
