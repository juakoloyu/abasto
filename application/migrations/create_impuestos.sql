CREATE TABLE `impuestos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `concepto` VARCHAR(255) DEFAULT NULL, 
  `sp` INT DEFAULT NULL, 
  `otro_municipio` INT DEFAULT NULL, 
  `otra_provincia` INT DEFAULT NULL, 
  `tipo` INT DEFAULT NULL, 
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
);
