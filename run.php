<?php

$cachetime = 300; //diferença entre o tempo atual e o tempo de ultima modificação dos arquivos de Cache (em segundos)
//puxa as exchanges


//bitcointrade
//$json_bitcointrade = file_get_contents("https://api.bitcointrade.com.br/v2/public/BRLBTC/ticker");

//cache da API
//$cache_bitcointrade = 'bitcoinreade.cache';
//if(file_exists($cache_bitcointrade)) {
//  if(time() - filemtime($cache_bitcointrade) > $cachetime) {
//     // too old , re-fetch
//     $cache = file_get_contents("https://api.bitcointrade.com.br/v2/public/BRLBTC/ticker"); //Atualiza o Cache
//     file_put_contents($cache_bitcointrade, $cache);
//     $json_bitcointrade = file_get_contents($cache_bitcointrade);
//  } else {
//     $json_bitcointrade = file_get_contents($cache_bitcointrade);
//  }
//} else {
//  // no cache, create one
//  $cache = file_get_contents("https://api.bitcointrade.com.br/v2/public/BRLBTC/ticker"); //Cria o Cache
//  file_put_contents($cache_bitcointrade, $cache);
//  $json_bitcointrade = file_get_contents($cache_bitcointrade);
//}



//$data_bitcoin_trade = json_decode($json_bitcointrade, true);
//$bitcointrade_price = $data_bitcoin_trade['data']['last'];
//$bitcointrade_volume = $data_bitcoin_trade['data']['volume'];
//$varbitcointrade = $bitcointrade_price * $bitcointrade_volume;


//bitcointoyou
//$json_bitcointoyou = file_get_contents("https://www.bitcointoyou.com/api/ticker.aspx");

//cache da API
$cache_bitcointoyou = 'bitcointoyou.cache';
if(file_exists($cache_bitcointoyou)) {
  if(time() - filemtime($cache_bitcointoyou) > $cachetime) {
     // too old , re-fetch
     $cache = file_get_contents("https://back.bitcointoyou.com/API/ticker?pair=BTC_BRLC"); //Atualiza o Cache
     file_put_contents($cache_bitcointoyou, $cache);
     $json_bitcointoyou = file_get_contents($cache_bitcointoyou);
  } else {
     $json_bitcointoyou = file_get_contents($cache_bitcointoyou);
  }
} else {
  // no cache, create one
  $cache = file_get_contents("https://back.bitcointoyou.com/API/ticker?pair=BTC_BRLC"); //Cria o Cache
  file_put_contents($cache_bitcointoyou, $cache);
  $json_bitcointoyou = file_get_contents($cache_bitcointoyou);
}

$databitcointoyou = json_decode($json_bitcointoyou, true);
$bitcointoyou_price = $databitcointoyou['summary']['last'];
$bitcointoyou_volume = $databitcointoyou['summary']['amount'];
//$bitcointoyou_price = intval($bitcointoyou_price);
//$bitcointoyou_volume = intval($bitcointoyou_volume);
$varbitcointoyou = $bitcointoyou_price * $bitcointoyou_volume;

//pagcripto <3
//Cache
$cache_pagcripto = 'pagcripto.cache';
if(file_exists('pagcripto.cache')) {
  if(time() - filemtime($cache_pagcripto) > $cachetime) {
    //valor antigo -> atualizar valor
    $cache_pagcripto1 = file_get_contents('https://api.pagcripto.com.br/v2/public/ticker/BTCBRL');
    file_put_contents($cache_pagcripto, $cache_pagcripto1);
    $json_pagcripto = file_get_contents($cache_pagcripto);
  } else {
    $json_pagcripto = file_get_contents($cache_pagcripto);
  }
} else {
  //sem arquivo de cache -> criar
  $cache_pagcripto1 = file_get_contents('https://api.pagcripto.com.br/v2/public/ticker/BTCBRL');
  file_put_contents($cache_pagcripto, $cache_pagcripto1);
  $json_pagcripto = file_get_contents($cache_pagcripto);
}
$datapagcripto = json_decode($json_pagcripto, true);
$pagcripto_price = $datapagcripto['data']['last'];
$pagcripto_volume = $datapagcripto['data']['volume'];
$varpagcripto = $pagcripto_price * $pagcripto_volume;


//Calcula o preco medio ponderado
$allvariables = $varbitcointoyou + $varpagcripto; //soma todas as variaveis

$volumetotal = $bitcointoyou_volume + $pagcripto_volume; //soma todos os volumes
$volumetotal = round($volumetotal, 8); //NANO tem 8 casas decimais

$preco_ponderado = $allvariables / $volumetotal; //calcula o preco medio ponderado

//$preco_ponderado = intval($preco_ponderado); //transforma em numero

//Calcula o MarketShare
//$pbitcointrade = round(($bitcointrade_volume/$volumetotal)*100, 2);
$pbitcointoyou = round(($bitcointoyou_volume/$volumetotal)*100, 2);
$ppagcripto = round(($pagcripto_volume/$volumetotal)*100, 2);

//puxa a data e hora do servidor
//isso mostra em que data estão os valores, para evitar equívocos com o cache
date_default_timezone_set('America/Sao_Paulo');
//$date = date('Y-m-d H:i');

//cache da API
$cache_data = 'data2.cache';
if(file_exists($cache_data)) {
  if(time() - filemtime($cache_data) > $cachetime) {
     // too old , re-fetch
     $cache = date('Y-m-d H:i'); //Atualiza o Cache
     file_put_contents($cache_data, $cache);
     $date = file_get_contents($cache_data);
  } else {
     $date = file_get_contents($cache_data);
  }
} else {
  // no cache, create one
  $cache = date('Y-m-d H:i'); //Cria o Cache
  file_put_contents($cache_data, $cache);
  $date = file_get_contents($cache_data);
}

?>
