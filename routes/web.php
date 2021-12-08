<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('coin', function(){
    $coin =  Http::get('https://api.coingecko.com/api/v3/coins/cryptocars/')->object();

    $id = $coin->id;
    $symbol = $coin->symbol;
    $name = $coin->name;
    $brl = $coin->market_data->current_price->brl;
    $lastUpdated = date('d-m-Y H:i', strtotime($coin->last_updated));

    $moeda = [$name, $symbol, $brl, $lastUpdated];

    $token = '5013620342:AAHzzRR7B7dAI1eD0oWE8ZjZd5LxW53EV08';
    $chatId = '1119471058';
    $message = "Mensagem de teste";
    //$getChatId = Http::get("https://api.telegram.org/bot{$token}/getUpdates");
    $sendMessage = Http::get("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&text=Token = {$name}\nSimbolo = {$symbol}\nBRL = {$brl}\nAtualizado em = {$lastUpdated}");


    return response()->json($moeda);


     return $coin->market_data->current_price->brl;
});

Route::get('/', function () {
    return view('welcome');
});
