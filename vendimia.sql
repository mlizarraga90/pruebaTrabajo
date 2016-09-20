/*
SQLyog Ultimate v9.63 
MySQL - 5.6.16 : Database - vendimia
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`vendimia` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `vendimia`;

/*Table structure for table `articulos` */

DROP TABLE IF EXISTS `articulos`;

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `precio` double(20,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `articulos` */

insert  into `articulos`(`id`,`modelo`,`precio`,`existencia`,`descripcion`,`status`) values (1,'12',4250.00,12,'12',0),(2,'dv-20011',4250.00,1011,'Taza11',0),(3,'23',4250.00,23,'23',0),(4,'dv-200',4250.00,12,'Laptop',1),(5,'Doña Chonita1',4250.00,123,'Taza1',1);

/*Table structure for table `claveclientes` */

DROP TABLE IF EXISTS `claveclientes`;

CREATE TABLE `claveclientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '1=usada,0=disponible',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `claveclientes` */

insert  into `claveclientes`(`id`,`clave`,`status`) values (1,'0001',1),(5,'0002',1),(6,'0006',1),(7,'0007',1),(8,'0008',1),(9,'0009',0);

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) DEFAULT NULL,
  `aPaterno` varchar(50) DEFAULT NULL,
  `aMaterno` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `rfc` varchar(30) DEFAULT NULL,
  `claveCliente` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `clientes` */

insert  into `clientes`(`id`,`nombres`,`aPaterno`,`aMaterno`,`direccion`,`status`,`rfc`,`claveCliente`) values (1,'Manuel','Lizarraga','Hernandez',NULL,0,'Mlh1990','0001'),(2,'11','11','111',NULL,0,'23','0002'),(3,'1','2','1',NULL,0,'2','0006'),(4,'1','2','1',NULL,0,'2','0007'),(5,'Manuel','Lizarraga','Hernandez',NULL,1,'mlh1990','0008');

/*Table structure for table `configuracion` */

DROP TABLE IF EXISTS `configuracion`;

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tazaFinanciamiento` float(20,2) DEFAULT NULL,
  `enganche` float(20,2) DEFAULT NULL,
  `plazoMaximo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `configuracion` */

insert  into `configuracion`(`id`,`tazaFinanciamiento`,`enganche`,`plazoMaximo`) values (12,2.80,20.00,12);

/*Table structure for table `detalleventas` */

DROP TABLE IF EXISTS `detalleventas`;

CREATE TABLE `detalleventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folio` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `detalleventas` */

insert  into `detalleventas`(`id`,`folio`,`idProducto`,`cantidad`) values (1,'00001',4,3),(2,'00001',5,4);

/*Table structure for table `folios` */

DROP TABLE IF EXISTS `folios`;

CREATE TABLE `folios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folio` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '0=disponible,1=usad',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `folios` */

insert  into `folios`(`id`,`folio`,`status`) values (2,'00001',1),(4,'00003',0);

/*Table structure for table `ventas` */

DROP TABLE IF EXISTS `ventas`;

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) DEFAULT NULL,
  `idArticulo` int(11) DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `folio` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `plazo` int(11) DEFAULT NULL,
  `abono` int(11) DEFAULT NULL,
  `enganche` float DEFAULT NULL,
  `ahorro` float DEFAULT NULL,
  `precioContado` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `ventas` */

insert  into `ventas`(`id`,`idCliente`,`idArticulo`,`total`,`fecha`,`folio`,`status`,`plazo`,`abono`,`enganche`,`ahorro`,`precioContado`) values (1,5,NULL,46084.35,'2016-09-19 23:35:04','00001',1,6,7681,15946,6628.57,39455.8);

/* Trigger structure for table `clientes` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_updateClave` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_updateClave` AFTER INSERT ON `clientes` FOR EACH ROW BEGIN
    declare idclave int default 0;
    DECLARE folio INT DEFAULT 0;
    select id into idclave from claveClientes where status=0 limit 1;
    
    update claveclientes set status=1 where clave=new.claveCliente;
    insert into claveclientes set clave=concat('000',idclave+1);
    END */$$


DELIMITER ;

/* Trigger structure for table `ventas` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_updateFolios` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_updateFolios` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
	declare total int default 0;
	select id into total from folios where folio=new.folio;
	if total=0 then
		insert into folios set folio=new.folio,status=1;
		INSERT INTO folios SET folio=CONCAT('0000',total+2),STATUS=0;
		else if total>1 then
			update folios set status=1 where folio=new.folio;
			insert into folios set folio=CONCAT('0000',total+1),status=0;
		end if;
	end if;
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
