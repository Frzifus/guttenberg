<?php
/**
 * Description of Push_Products
 *
 * @author Frzifus
 *
 */
include 'FlushProducts.php';
include 'ContentTuple.php';
include 'Products.php';

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
    $product->set_Name($xpath->query(
      $tuple->Pattern["DOMPath"]["products_name"])->item(0)->textContent);
    $product->set_Model($xpath->query(
      $tuple->Pattern["DOMPath"]["products_model"])->item(0)->textContent);
    $product->set_EAN($xpath->query(
      $tuple->Pattern["DOMPath"]["products_ean"])->item(0)->textContent);
    $product->set_Description($xpath->query(
      $tuple->Pattern["DOMPath"]["products_description"])->item(0)->textContent);
    $product->set_ShortDescription($xpath->query(
      $tuple->Pattern["DOMPath"]["products_short_description"])
                                   ->item(0)->textContent);
    $product->set_Price($xpath->query(
      $tuple->Pattern["DOMPath"]["products_price"])->item(0)->textContent);
    $product->set_Weight($xpath->query(
      $tuple->Pattern["DOMPath"]["products_weight"])->item(0)->textContent);
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
$rawText = "https://allpa.de/bedienungen/lenkungssytemen/cilinders/seastar-zylinder-kgm-fur-hydraulisches-innenbord-steuersystem-ba125-3atm-jet.html";

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

var_dump($products);

foreach ($products as $product) {
  FlushProduct($product);
}
?>