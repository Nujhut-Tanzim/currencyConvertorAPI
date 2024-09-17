<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class CurrencyConvertorController extends Controller
{
    public function Store(Request $request)
    {
        $fromCurrency=$request->input("fromCurrency");
        $toCurrency=$request->input("toCurrency");
        $rate=$request->input("rate");
        $flagImagePath = $request->file('flag_image')->store('flags');

        $data=ExchangeRate::updateOrCreate([
            "fromCurrency"=>$fromCurrency,
            "toCurrency"=>$toCurrency,
            "Rate"=>$rate,
            "flag_img"=>$flagImagePath
        ]);

        return response()->json($data,201);

    }

    public function getAllRate(Request $request)
    {
        
        $data=ExchangeRate::select('fromCurrency','toCurrency','Rate')->get();
                           
        
        return response()->json($data,200);
    }

    public function getAPI(Request $request)
    {
        $fromCurrency=$request->query("base");
        $toCurrency=$request->query("target");
        $data=ExchangeRate::where("fromCurrency","=",$fromCurrency)
                           ->where("toCurrency","=",$toCurrency)
                           ->first();
        $rate=$data["Rate"];
        return response()->json([
            "fromCurrency"=>$fromCurrency,
            "toCurrency"=>$toCurrency,
            "Rate"=>$rate
        ],200);
    }

    
    public function CurrencyConversion(Request $request)
    {
        $request->validate([
            'base'=>'required|string|size:3',
            'target'=>'required|string|size:3',
            'amount'=>'required|numeric|min:0'
        ]);
        $fromCurrency=$request->query("base");
        $toCurrency=$request->query("target");
        $amount=$request->query("amount");

        if (!ctype_alpha($fromCurrency) || !ctype_alpha($toCurrency)) {
            return response()->json(['error' => 'Currency codes must contain only alphabetic characters.'], 400);
        }
        $data=ExchangeRate::where("fromCurrency","=",$fromCurrency)
                           ->where("toCurrency","=",$toCurrency)
                           ->first();
        $rate=$data["Rate"];
        $convertedResult=$rate*$amount;
        return response()->json([
            "fromCurrency"=>$fromCurrency,
            "toCurrency"=>$toCurrency,
            "Rate"=>$rate,
            "result"=>$convertedResult
        ],200);
    }
}
