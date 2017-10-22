<?Php
include 'dbconfig.php';

function FlushProducts(Products $model) {
  $toJson = [
    'prefix' => $model->Prefix(),
    'DOMPath' => [
      'products_name' => $model->Name(),
      'products_model'=> $model->Model(),
      'products_ean'  => $model->EAN(),
      'products_description' => $model->Description(),
      'products_short_description' => $model->ShortDescription(),
      'products_price'  => $model->Price(),
      'manufacturer_id' => $model->ManufacturerId(),
      'products_weight' => $model->Weight(),
      'products_image' => []
    ]
  ];

  $filename = 'data/' . $model->Prefix() . '_' . $model->Name() . '.json';

  file_put_content($filename, json_encode($toJson));
}
