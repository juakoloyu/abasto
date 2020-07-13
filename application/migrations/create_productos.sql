CREATE TABLE `productos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(255) DEFAULT NULL, 
  `peso` INT DEFAULT NULL, 
  `descripcion` VARCHAR(255) DEFAULT NULL, 
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
);
