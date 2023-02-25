<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BetController extends Controller
{

    public function getTopBets(Request $request)
    {

        if (!in_array($request->by, ['bet_size', 'coef', 'win'])) {
            return response()->json(['success' => false, 'error' => 'Не правильно указаны фильтры']);
        }

        if ($request->time == 'year') {
            return response()->json(['success' => true, 'data' => Bet::where('date_time', '>', Carbon::now()->floorYear()->format('Y-m-d H:i:s'))->orderByDesc($request->by)->take(10)->get()]);
        } else if ($request->time == 'month') {
            return response()->json(['success' => true, 'data' => Bet::where('date_time', '>', Carbon::now()->floorMonth()->format('Y-m-d H:i:s'))->orderByDesc($request->by)->take(10)->get()]);
        } else if ($request->time == 'day') {
            return response()->json(['success' => true, 'data' => Bet::where('date_time', '>', Carbon::now()->floorDay()->format('Y-m-d H:i:s'))->orderByDesc($request->by)->take(10)->get()]);
        }
        return response()->json(['success' => false, 'error' => 'Не правильно указаны фильтры']);
    }

    public function delete($id)
    {
        Bet::find($id)->delete();
        return back();
    }

    public function index(Request $request, $user_id = false)
    {
        $data = [];

        if (!$user_id) {
            $data['rows'] = Bet::orderByDesc('date_time')->paginate(20);
        } else {
            $data['rows'] = Bet::where('user_id', $user_id)->orderByDesc('date_time')->paginate(20);
        }

        return view('tables.bets', $data);
    }

}
