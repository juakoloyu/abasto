CREATE TABLE `transportistas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) DEFAULT NULL, 
  `tipo_doc` INT DEFAULT NULL, 
  `documento` VARCHAR(255) DEFAULT NULL, 
  `cat_licencia` INT DEFAULT NULL, 
  `licencia` VARCHAR(255) DEFAULT NULL, 
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
);
