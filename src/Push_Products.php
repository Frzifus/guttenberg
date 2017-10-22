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
function PullContent(array $uris) : array {
  $content = array();
  foreach ($uris as $url) {
    try {
      $tuple = new ContentTuple();
      $tuple->Pattern = UrlMatchPattern($url);
      $tuple->Content = file_get_contents($url);
      $content[] = $tuple;
    } catch(Exception $e) {
      echo "Fehler beim holen von: " . $url;
    }
  }
  return $content;
}


/**
 * @return bool
 */
function UrlMatchPattern($url) : bool {
  return true;
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

function ListAllPatternFiles() : array {
  $allPattern = array();
  $dir = scandir('./Pattern');
  foreach ($dir as $file) {
    if (preg_match("/\.json/", $file)) {
      $allPattern[] = $file;
    }
  }
  return $allPattern;
}

function ReadPattern(string $file) : array {
  $json = file_get_contents('Pattern/' . $file, NULL, NULL);
  $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

  var_dump($jsonIterator);
  exit();
  foreach ($jsonIterator as $key => $val) {
    if(is_array($val)) {
      echo "$key:\n";
    } else {
      echo "$key => $val\n";
    }
  }
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

$content = PullContent($URIS);

?>