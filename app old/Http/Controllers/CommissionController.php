<?php

namespace App\Http\Controllers;
use App\Admin\Options\Option;
use App\Admin\BankAccounts\BankAccount;

use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {   $c = 0;
        $bank_accounts =  BankAccount::select('bank_name', 'account_name', 'account_no', 'iban')->get();
        $commission = Option::where( 'key', 'money_const' )->select('value')->first();
        $note = Option::where( 'key', 'notes' )->select('value')->first();
        $notes = explode(".", $note->value);
        $about_us = Option::where( 'key', 'about_us' )->select('value')->first();
        return view('commission')->with('commission',$commission)
        ->with('notes',$notes)->with('about_us',$about_us)->with('bank_accounts',$bank_accounts);
    }
}
