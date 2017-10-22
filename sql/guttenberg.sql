CREATE TABLE IF NOT EXISTS Products (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pre INT UNSIGNEDN NOT NULL,
  products_name VARCHAR(255) NOT NULL,
  products_model VARCHAR(64) NOT NULL,
  products_ean VARCHAR(255) NOT NULL,
  products_description TEXT NOT NULL,
  products_short_description TEXT NOT NULL,
  products_price DECIMAL(15,4) NOT NULL,
  products_weight DECIMAL(15,4) NOT NULL,
  PRIMARY KEY (id),
);
