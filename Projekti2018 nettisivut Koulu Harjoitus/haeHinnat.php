<html>
<body>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div class="container">
  <h2>Hae tuotteen hinta Jimmssiltä, Gigantista tai Verkkokaupasta</h2>
  <form class="form-horizontal" method="GET">
    <div class="form-group">
      <label class="control-label col-sm-2" for="Text">URL osoite</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="URL" placeholder="Syötä Jimssin, Gigantin tai Verkkokauppa.com URL osoite" name="JimmsURL">
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-success">Hae</button>
      </div>
    </div>
  </form>
</div>




<?php

function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}




// Tarkistetaan minkä verkkokaupan linkki on kyseessä

// Jimms
if (strpos($url,'jimms') !== true) 
 {

$html = file_get_contents_curl($_GET["JimmsURL"]);

$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes = $doc->getElementsByTagName('title');

//get and display what you need:
$title = $nodes->item(0)->nodeValue;

$metas = $doc->getElementsByTagName('meta');

for ($i = 0; $i < $metas->length; $i++)
{
    $meta = $metas->item($i);
    if($meta->getAttribute('property') == 'product:price:amount')
        $hinta = $meta->getAttribute('content');
}

 }




// Gigantti
if (strpos($url,'gigantti') !== true) 
 {

$html = file_get_contents_curl($_GET["JimmsURL"]);

$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes = $doc->getElementsByTagName('title');

//get and display what you need:
$title = $nodes->item(0)->nodeValue;

$metas = $doc->getElementsByTagName('meta');

for ($i = 0; $i < $metas->length; $i++)
{
    $meta = $metas->item($i);
    if($meta->getAttribute('itemprop') == 'price')
        $hinta = $meta->getAttribute('content');
}
 }




//Tulostus

echo "<h4>Tuote: $title". '<br/><br/>';
echo "<h4>Tuotteen hinta: $hinta". ' €' . '<br/><br/>';


?>