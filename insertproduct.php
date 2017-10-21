<?php
include 'dbconfig.php';

  function flush_model($model) {
     try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO products (products_name, products_model, products_ean, products_description
                                      products_short_description, products_price,products_weight,
                                      manufacturer_id)
                VALUES ($model->Name(), $model->Model(), $model->EAN(), $model->Description(), $model->ShortDescription(), $model->Price(), $model->Weight(), $model->Manufacturer());";

        $conn->exec($sql);
     }
     catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
     }
  }
?>