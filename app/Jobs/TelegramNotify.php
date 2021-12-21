<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TelegramNotify  //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $desiredVariationUp = 8;
        $desiredVariationDown = -8;

        $coin =  Http::get('https://api.coingecko.com/api/v3/coins/cryptocars/')->object();

        $id = $coin->id;
        $symbol = $coin->symbol;
        $name = $coin->name;
        $brl = $coin->market_data->current_price->brl;
        $variationBrl = $coin->market_data->price_change_percentage_24h_in_currency->brl;
        //dd($variationBrl);
        $lastUpdated = date('d-m-Y H:i', strtotime($coin->last_updated));

        if($variationBrl > $desiredVariationUp || $variationBrl < $desiredVariationDown)
        {

            $status = '⏺';

            if($variationBrl > $desiredVariationUp)
            {
                $status = '⬆️';
            }elseif($variationBrl < $desiredVariationDown)
            {
                $status = '⬇️';
            }



            /* $moeda = [
                        'CCAR->BRL' => [$name, $symbol, $brl, $lastUpdated],
                        'CCAR->BNB' => [$name, $symbol, $bnb, $lastUpdated],
                    ]; */
            //$token = '5013620342:AAHzzRR7B7dAI1eD0oWE8ZjZd5LxW53EV08'; //token Yuri
            //$chatId = '1119471058'; //telegram Yuri

            $token = '1140021184:AAFrE0GLb6bjftlNfQ5jf06vUaNLuNQfU3Q'; //token Icaro
            //$chatId = '615312356'; //telegram Icaro
            $chatId = '-663151197';//grupo pushcoin
            //$getChatId = Http::get("https://api.telegram.org/bot{$token}/getUpdates");
            $message = "{$status} {$name} - {$symbol} {$status}\nVariação BRL 24H: {$variationBrl}\nCCAR -> BRL = {$brl}\nAtualizado em = {$lastUpdated}";
            $sendMessage = Http::get("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&text={$message}");

        }


    }
}
