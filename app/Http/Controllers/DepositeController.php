<?php

namespace App\Http\Controllers;

use App\Models\Deposite;
use Illuminate\Http\Request;

class DepositeController extends Controller
{
    public function index(Request $request, $user_id = false)
    {
        $data = [];
        if (!$user_id) {
            $data['rows'] = Deposite::orderByDesc('created_at');
        } else {
            $data['rows'] = Deposite::where('user_id', $user_id)->orderByDesc('created_at');
        }
        if($request->has('status')){
            $data['rows'] = $data['rows']->where('status_id', $request->input('status'));
        }

        $data['rows'] = $data['rows']->paginate(20);

        return view('tables.deposites', $data);
    }

    public function accept(Request $request, $id)
    {
        $deposite = Deposite::find($id);
        if ($deposite->status_id == 1) {
            $deposite->status_id = 2;
            $user = $deposite->user;
            $user->money = $user->money + $deposite->size;
            $user->save();
            $deposite->save();
        }
        return back();
    }

    public function reject(Request $request, $id)
    {
        $deposite = Deposite::find($id);

        if ($deposite->status_id == 1) {
            $deposite->status_id = 3;
            $deposite->save();
        }
        $deposite->save();

        return back();
    }

    public function delete(Request $request, $id)
    {
        Deposite::find($id)->delete();
        return back();
    }
}
