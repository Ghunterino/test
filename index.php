<?php

// Assuming you installed from Composer:
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$dom = new Dom;


$fp = fopen('file.csv', 'w');

for ($i=0; $i < 100000; $i++) {
  echo "========================\n";
  echo "Page $i sur 100000\n";
  echo "========================\n";
  $dom->loadFromUrl('https://www.service-public.fr/particuliers/vosdroits/F'.$i);

  try{
    $question = $dom->find('#headerPage')->find("h1")->innerHtml;
    $checkIntro = sizeof($dom->find('#intro'));
    $checkContentFiche = sizeof($dom->find('.content-fiche'));
    if($checkIntro > 0){
      $response = $dom->find('#intro')->find('p')->innerHtml;
    }
    elseif($checkContentFiche > 0){
      if(sizeof($dom->find('.content-fiche')->find('p')) > 0){
        $response = $dom->find('.content-fiche')->find('p')->innerHtml;
      }
    }
    else{
      echo "Weird !";
    }
    fputcsv($fp, [
      $question, $response
    ]);

  }
  catch(Exception $e){

  }

}







?>
