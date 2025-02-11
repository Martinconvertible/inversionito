<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function Laravel\Prompts\alert;

class StockController extends Controller
{
    public function show ($symbol){
        //construir la url
        $baseUrl= env('ALPHAVANTAGE_BASE_URL');
        $apiKey= env('ALPHAVANTAGE_API_KEY');

        //conseguir el ultimo dia habil 

        function obtenerUltimodihabil ($fecha = null){
            date_default_timezone_set('America/New_York');

            try {
                if ($fecha== null){
                    $fecha= date('Y-m-d');
                }
            $fechaObj = new DateTime($fecha);

            $diaSemana = $fechaObj->format('N');

            if ($diaSemana ==6 ){
                $fechaObj->modify('-1 day');
            } elseif ($diaSemana ==7 ){
                $fechaObj->modify('-2 day');
            } elseif ($diaSemana==1){
                $horaActual = date('H:i');
                $horaLimite= '17:30';

                if ($horaActual< $horaLimite){
                    $fechaObj->modify('-3 day');
                }
            } elseif ($diaSemana<6 && $diaSemana>1){
                $horaActual = date('H:i');
                $horaLimite= '17:30';
                if ($horaActual< $horaLimite){
                    $fechaObj->modify('-1 day');
                }
            }
            
            return $fechaObj-> format ('Y-m-d');} catch (Exception $e){
                throw new Exception( 'Formato fecha invalido');
            }};

          $fechaActual= obtenerUltimodihabil();
            
            
        //hacer la solicitud HTTP

    $response= Http::get($baseUrl, [
        'function' => 'RSI',
        'symbol' => $symbol,
        'interval' => 'daily',
        'time_period'=> '14',
        'series_type'=> 'close',
        'apikey' => $apiKey,
    ]);
    if ($response->successful()) {
        $data = $response->json();
        if (isset($data ["Information"])){ return view('limiteDiario');} 


        else if (isset ($data["Technical Analysis: RSI"])){;

        //if ($validadorRSI)
        $rsidata['accion']=$data["Technical Analysis: RSI"]["$fechaActual"]["RSI"];
        $rsidata['status'] = "";

       if($rsidata['accion']<20) { $rsidata['status']= "superblue"; $rsidata['comentario']= "El momento más optimo para comprar, llegando al valor minimo relativo"; $rsidata['simbolo']= $symbol;} 
        elseif ($rsidata['accion']<30) { $rsidata['status']= "DIAMANTE" ;$rsidata['comentario']= "Momento de comprar, podría bajar más pero no es lo habitual";$rsidata['simbolo']= $symbol;}
        elseif ($rsidata['accion']<50) { $rsidata['status']= "reloj" ;$rsidata['comentario']= "Tiempo de esperar, en valor relativo medio";$rsidata['simbolo']= $symbol;}
        elseif ($rsidata['accion']>60) { $rsidata['status']= "MONEY"; $rsidata['comentario']= "Momento de vender, podría subir más pero no es lo habitual"; $rsidata['simbolo']= $symbol;}
        elseif ($rsidata['accion']>70) { $rsidata['status']= "MONEY"; $rsidata['comentario']= "Momento optimo de vender, está en valores máximos relativos";$rsidata['simbolo']= $symbol;}  
            //return response()->json(['error'=> 'No se pudo obtener datra'], 500);

        //dd($rsidata);
        
        //return response()->json($data);
        
        return view('show')->with('rsidata', $rsidata);
    }}
        return view('error');
    }
}
