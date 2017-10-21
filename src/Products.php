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
  private int id;
  // webseite von wo geklaut wurde
  /** @prefix @Column(type="integer")  */
  private string prefix;
  // productname
  /** @products_name @Column(type="varchar255") */
  private string products_name;
  // Artikelnummer
  /** @products_model @Column(type="varchar64")  */
  private string products_model;
  /** @products_ean @Column(type="varchar128") */
  private string products_ean;
  /** @products_image @Column(type="varchar254") */
  private string products_image;
  /** @products_description @Column(type="text") */
  private string products_description;
  /** @products_short_description @Column(type="text") */
  private string products_short_description;
  /** @products_price @Column(type="decimal(15.4)") */
  private double products_price;
  /** @products_weight @Column(type="decimal(15.4)") */
  private double products_weight;

  // /** @products_keywords @Column(type="varchar255") */
  // private string products_keywords;

  //  /** @products_weight @Column(type="decimal(15.4)") */
  //  private string image64;

  /**
   * public methods
   */

  public void __construct() {}

  public void set_Prefix(string prefix) {
    $this->prefix = prefix;
  }

  public void set_Name(string name) {
    $this->products_name = name;
  }

  public void set_Model(string model) {
    $this->products_model = model;
  }

  public void set_EAN(string ean) {
    $this->products_ean = ean;
  }

  public void set_ImagePath(string path) {
    $this->products_image = path;
  }

  public void set_Description(string desc) {
    $this->products_description = desc;
  }

  public void set_ShortDescription(string desc) {
    $this->products_short_description = desc;
  }
  /**
   * private methods
   */
}


?>
