CREATE TABLE `vehiculos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dominio` VARCHAR(255) DEFAULT NULL, 
  `propietario` VARCHAR(255) DEFAULT NULL, 
  `seccional_radicacion` VARCHAR(255) DEFAULT NULL, 
  `marca` VARCHAR(255) DEFAULT NULL, 
  `tipo` VARCHAR(255) DEFAULT NULL, 
  `modelo` INT DEFAULT NULL, 
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
);
