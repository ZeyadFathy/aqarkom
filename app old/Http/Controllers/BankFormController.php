<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin\BankAccounts\BankAccount;
use App\Admin\BankForm\BankForm;

class BankFormController extends Controller
{
    public function index()
    {
        $bank_accounts =  BankAccount::select('bank_name')->get();

        return view('bankform')->with('banks', $bank_accounts);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bank_name' => 'required',
            'to_bank' => 'required',
            'from_bank' => 'required',
            'amount' => 'required',
        ]);
        $bank_form = new BankForm;
        $bank_form->name = $request->name;
        $bank_form->mobile = $request->mobile;
        $bank_form->email = $request->email;
        $bank_form->amount = $request->amount;
        $bank_form->bank_name = $request->bank_name;
        $bank_form->to_bank = $request->to_bank;
        $bank_form->from_bank = $request->from_bank;
        $bank_form->date = $request->date;
        if ($request->hasFile('photo')) {
            $request->photo->storeAs('images', date('YmdHis') . '.' . $request->photo->extension(), 'admin');
            $bank_form->photo = 'images/' . date('YmdHis') . '.' . $request->photo->extension();
        }
        $bank_form->save();
        return view('Thankyou');
    }
}
