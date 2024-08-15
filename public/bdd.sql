CREATE DATABASE `moviedb` /*!40100 DEFAULT CHARACTER SET utf8 */;

use moviedb;
CREATE TABLE `actores` (
  `actor_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` datetime NOT NULL,
  `nacionalidad` varchar(100) NOT NULL,
  PRIMARY KEY (`actor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `peliculas` (
  `pelicula_id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `año` int(11) NOT NULL,
  `director` varchar(255) NOT NULL,
  PRIMARY KEY (`pelicula_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
