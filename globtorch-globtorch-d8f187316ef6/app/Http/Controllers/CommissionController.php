<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Commission;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissions = Commission::orderBy('isPaid')
            ->orderBy('created_at')
            ->get();

        return view('commission.index', compact('commissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commission = Commission::find($id);
        $referrer = $commission->user;
        
        $payments = DB::table('users')
            ->join('enrollments', 'enrollments.user_id', '=' ,'users.id')
            ->join('payments', 'enrollments.id', '=','payments.enrollment_id')
            ->select('users.surname', 'users.name', 'users.school_id', 'payments.*')
            ->where('referrer', $referrer->school_id)
            ->whereMonth('payments.date', $commission->month)
            ->get();

        return view('commission.show', compact('referrer', 'payments', 'commission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commission = Commission::find($id);

        return view('commission.edit', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'pay_date'=>'required|date',
            'isPaid' => 'nullable|integer',
            ]);

        $commission = Commission::find($id);
        if ($request->input('isPaid') == 1)
        {
            $commission->isPaid = 1;
        }
        else
        {
            $commission->isPaid = 0;
        }
        $commission->pay_date = $request->input('pay_date');
        $commission->reference = $request->input('reference');
        $commission->pay_method = $request->input('pay_method');
        $commission->save();

        return redirect('/commission');
    }

    public function instructions()
    {
        return view('commission.instructions');
    }
}
