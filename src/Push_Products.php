<?php
/**
 * Description of Push_Products
 *
 * @author Frzifus
 *
 */
include 'FlushProducts.php';
include 'ContentTuple.php';

/******************************************************************************/
/* functions                                                                  */
/******************************************************************************/


/**
 * @return array
 */
function PullContent(array $uris, array $allPattern) : array {
  $content = array();
  foreach ($uris as $url) {
    try {
      $tuple = new ContentTuple();
      $tuple->Pattern = UrlMatchPattern($url, $allPattern);
      $tuple->Content = file_get_contents($url);
      if (count($tuple->Pattern) == 0) { continue; }
      $content[] = $tuple;
    } catch(Exception $e) {
      echo "Fehler beim holen von: " . $url;
    }
  }
  return $content;
}


/**
 * @return array
 */
function UrlMatchPattern(string $url, array $pattern) : array {
  foreach ($pattern as $p) {
    if (preg_match('/' . $p["prefix"] . '/', $url)) {
      return $p;
    }
  }
  return array();
}

/**
 * @return Products
 */
function MapAndParseDom(ContentTuple $tuple) : Products {
  $product = new Products();
  $doc = new DOMDocument();
  libxml_use_internal_errors(true);
  $doc->loadHTML('<?xml encoding="UTF-8">' . $tuple->Content);
  $doc->encoding = 'UTF-8';
  $doc->saveHTML();

  $xpath = new \DOMXPath($doc);

  try {
    $product->set_Name($xpath->query($tuple->pattern["products_name"]));
    $product->set_Model($xpath->query($tuple->pattern["products_model"]));
    $product->set_EAN($xpath->query($tuple->pattern["products_ean"]));
    $product->set_Description($xpath->query(
      $tuple->pattern["products_description"]));
    $product->set_ShortDescription($xpath->query(
      $tuple->pattern["products_short_description"]));
    $product->set_Price($xpath->query($tuple->pattern["products_price"]));
    $product->set_Weight($xpath->query($tuple->pattern["products_weight"]));
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  return $product;
}

function ListAllPatternFiles(string $path = "./pattern") : array {
  $allPattern = array();
  $dir = scandir($path);
  foreach ($dir as $file) {
    if (preg_match("/\.json/", $file)) {
      $allPattern[] = $file;
    }
  }
  return $allPattern;
}

function ReadAllPattern(array $files) : array {
  $allPattern = array();
  foreach ($files as $file) {
    $json = file_get_contents('pattern/' . $file, NULL, NULL);
    $json = json_decode($json, true);
    $allPattern[] = $json;
  }
  return $allPattern;
}

/******************************************************************************/
/* Script stuff                                                               */
/******************************************************************************/


/**
 * @var rawText
 */
// $rawText = $_POST["URI"];
$rawText = "https://google.de\r\nrofl";

$URIS = array();

$url_pattern = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.'
             . '([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';

foreach(preg_split("/((\r?\n)|(\r\n?))/", $rawText) as $line) {
  if (preg_match($url_pattern, $line)) {
    $URIS[] = $line;
  } else {
    echo "URL is invalid " . $line . "\n";
  }
}

$patternFilelist = ListAllPatternFiles();
$allPattern = ReadAllPattern($patternFilelist);

$content = PullContent($URIS, $allPattern);

$products = array();

foreach ($content as $tuple) {
  $products[] = MapAndParseDom($tuple);
}
foreach ($products as $product) {
  FlushProduct($product);
}
?>