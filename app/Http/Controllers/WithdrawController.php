<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index(Request $request, $user_id = false)
    {
        $data = [];
        if (!$user_id) {
            $data['rows'] = Withdraw::orderByDesc('created_at');
        } else {
            $data['rows'] = Withdraw::where('user_id', $user_id)->orderByDesc('created_at');
        }
        if($request->has('status')){
            $data['rows'] = $data['rows']->where('status_id', $request->input('status'));
        }

        $data['rows'] = $data['rows']->paginate(20);

        return view('tables.withdraws', $data);
    }

    public function accept(Request $request, $id)
    {
        $withdraw = Withdraw::find($id);
        if ($withdraw->status_id == 1) {
            $withdraw->status_id = 2;
            $user = $withdraw->user;
            $user->money = $user->money + $withdraw->size;
            $user->save();
            $withdraw->save();
        }
        return back();
    }

    public function reject(Request $request, $id)
    {
        $withdraw = Withdraw::find($id);

        if ($withdraw->status_id == 1) {
            $withdraw->status_id = 3;
            $withdraw->save();
        }
        $withdraw->save();

        return back();
    }

    public function delete(Request $request, $id)
    {
        Withdraw::find($id)->delete();
        return back();
    }
}
