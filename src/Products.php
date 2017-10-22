<?php

/**
 * Description of Products
 *
 * @author Frzifus
 *
 * @Entity @Table(name="shop.products")
 */


class Products {
  /** @Id @Column(type="integer") @GeneratedValue */
  private $id;
  // webseite von wo geklaut wurde
  /** @prefix @Column(type="integer")  */
  private $prefix;
  // productname
  /** @products_name @Column(type="varchar255") */
  private $products_name;
  // Artikelnummer
  /** @products_model @Column(type="varchar64")  */
  private $products_model;
  /** @products_ean @Column(type="varchar128") */
  private $products_ean;
  /** @products_image @Column(type="varchar254") */
  private $products_image;
  /** @products_description @Column(type="text") */
  private $products_description;
  /** @products_short_description @Column(type="text") */
  private $products_short_description;
  /** @products_price @Column(type="decimal(15.4)") */
  private $products_price;
  /** @products_weight @Column(type="decimal(15.4)") */
  private $products_weight;
  /** @manufacturer_id @Column(type="integer") */
  private $manufacturer_id;

  // /** @products_keywords @Column(type="varchar255") */
  // private string products_keywords;

  //  /** @products_weight @Column(type="decimal(15.4)") */
  //  private string image64;

  /**
   * public methods
   */

  public function __construct() {}

  public function set_Prefix(string $prefix) {
    $this->prefix = $prefix;
  }

  public function set_Name(string $name) {
    $this->products_name = $name;
  }

  public function set_ManufacturerId(int $id) {
    $this->manufacturer_id = $id;
  }

  public function set_Model(string $model) {
    $this->products_model = $model;
  }

  public function set_EAN(string $ean) {
    $this->products_ean = $ean;
  }

  // public function set_ImagePath(string $path) {
  //   $this->products_image = $path;
  // }

  public function set_Description(string $desc) {
    $this->products_description = $desc;
  }

  public function set_ShortDescription(string $desc) {
    $this->products_short_description = $desc;
  }

  public function Prefix() : string {
    return $this->prefix;
  }

  public function Name() : string {
    return $this->products_name;
  }

  public function Model() : string {
    return $this->products_name;
  }

  public function EAN() : string {
    return $this->products_ean;
  }

  // public function ImagePath() : string {
  //   return $this->products_image;
  // }

  public function Description() : string {
    return $this->products_description;
  }

  public function ShortDescription() : string {
    return $this->products_short_description;
  }

  public function Price() : double {
    return $this->products_price;
  }

  public function Weight() : double {
    return $this->products_weight;
  }

  public function ManufacturerId() : int {
    return $this->manufacturer_id;
  }
  /**
   * private methods
   */
}


?>
