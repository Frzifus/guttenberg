<?php
/**
 * Description of Push_Products
 *
 * @author Frzifus
 *
 */
include 'FlushProducts.php';

/******************************************************************************/
/* functions                                                                  */
/******************************************************************************/

/**
 * @return array
 */
function PullContent() {
  foreach ($URIS as $url) {
    function ($url) {
      $client = new \GuzzleHttp\Client();
      $res = $client->request('GET', $url);
      // Teste Serverantwort
      if ($res->getStatusCode() != 200) {
        continue;
      }
      $content = array_push($content, $res);
    }
  }
}


/**
 * @return bool
 */
function MatchContentPattern() : bool {
  return true;
}

/**
 * @return Products
 */
function MapAndParseDom($dom, $pattern) : Products {
  $product = new Products();
  $doc = new DOMDocument();

  $html = $dom->getBody();
  libxml_use_internal_errors(true);
  $doc->loadHTML('<?xml encoding="UTF-8">' . $html->getContents());
  $doc->encoding = 'UTF-8';
  $doc->saveHTML();

  $xpath = new \DOMXPath($doc);

  try {
    $product->set_Name($xpath->query("//div[@class='some_pattern_stuff']"));
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  return $product;
}

/******************************************************************************/
/* Script stuff                                                               */
/******************************************************************************/


/**
 * @var rawText
 */
$rawText = $_POST["URI"];

$URIS = array();
$content = array();

foreach(preg_split("/((\r?\n)|(\r\n?))/", $rawText) as $line) {
  $URIS = array_push($URIS, $line);
}


?>