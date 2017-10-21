<?php

namespace App\Http\Controllers;

use App\Operation;
use App\Providers\PrivatBankDataProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $summary_grn = Operation::where('user_id', '=', $user_id)->sum('val_grn');
        $summary_dol = Operation::where('user_id', '=', $user_id)->sum('val_dol');
        //берем сегоднешний день + 1 , чтобы вывело операции сегоднишнего дня включительно
        $today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+1,   date("Y")));
        $lastmonth = date("Y-m-d", mktime(0, 0, 0, date("m")-1, date("d")+1,   date("Y")));
        $opearations = Operation::where('user_id', '=', $user_id)->whereBetween('created_at', [$lastmonth, $today])->get();

        return view('home', ['operations' => $opearations, 'summary_grn' => $summary_grn, 'summary_dol' => $summary_dol, 'today' => $today, 'lastmonth' => $lastmonth]);
    }
    public function addOperation(){

        $dataProvider = new PrivatBankDataProvider();
        $currency_rate_grn_usd = $dataProvider->getCurrencyRate();
        $from = $_POST['from'];
        $to = $_POST['to'];
        $name = $_POST['name'];
        $val_grn = $_POST['val_grn'];
        $user_id = Auth::user()->id;
        $operation = new Operation;
        $operation->name = $name;
        $operation->val_grn = $val_grn;
        $operation->val_dol = $val_grn/$currency_rate_grn_usd;
        $operation->user_id = $user_id;
        $operation->save();
        $summary_grn = Operation::where('user_id', '=', $user_id)->sum('val_grn');
        $summary_dol = Operation::where('user_id', '=', $user_id)->sum('val_dol');
        $opearations = Operation::where('user_id', '=', $user_id)->whereBetween('created_at', [$from, $to])->get();
        return view('operations', ['operations' => $opearations, 'summary_grn' => $summary_grn, 'summary_dol' => $summary_dol]);
    }

    public function editOperation(){

        $dataProvider = new PrivatBankDataProvider();
        $currency_rate_grn_usd = $dataProvider->getCurrencyRate();

        $name = $_POST['name'];
        $val_grn = $_POST['val_grn'];
        $operation_id = $_POST['id_edit'];
        $user_id = Auth::user()->id;
        $from = $_POST['from'];
        $to = $_POST['to'];


        $data = array(
            'name' => $name,
            'val_grn' => $val_grn,
            'val_dol'=> $val_grn/$currency_rate_grn_usd
        );
        Operation::where('id', $operation_id)
            ->update($data);

        $summary_grn = Operation::where('user_id', '=', $user_id)->sum('val_grn');
        $summary_dol = Operation::where('user_id', '=', $user_id)->sum('val_dol');
        $opearations = Operation::where('user_id', '=', $user_id)->whereBetween('created_at', [$from, $to])->get();
        return view('operations', ['operations' => $opearations, 'summary_grn' => $summary_grn, 'summary_dol' => $summary_dol]);
    }

    public function deleteOperation(){
        $operation_id = $_POST['id_delete'];
        Operation::where('id', $operation_id)
            ->delete();

        $user_id = Auth::user()->id;
        $summary_grn = Operation::where('user_id', '=', $user_id)->sum('val_grn');
        $summary_dol = Operation::where('user_id', '=', $user_id)->sum('val_dol');
        $opearations = Operation::where('user_id', '=', $user_id)->get();
        return view('operations', ['operations' => $opearations, 'summary_grn' => $summary_grn, 'summary_dol' => $summary_dol]);
    }

    public function filterByDate(){
        $from = $_POST['from'];
        $to = $_POST['to'];
        $user_id = Auth::user()->id;
        $summary_grn = Operation::where('user_id', '=', $user_id)->sum('val_grn');
        $summary_dol = Operation::where('user_id', '=', $user_id)->sum('val_dol');
        $opearations = Operation::where('user_id', '=', $user_id)->whereBetween('created_at', [$from, $to])->get();
        return view('operations', ['operations' => $opearations, 'summary_grn' => $summary_grn, 'summary_dol' => $summary_dol]);
    }
}
