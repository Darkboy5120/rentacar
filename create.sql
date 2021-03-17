SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

drop table if exists `reporte_devolucion_imagen`;
drop table if exists `reporte_entrega_imagen`;
drop table if exists `reporte_devolucion`;
drop table if exists `reporte_entrega`;
drop table if exists `renta`;
drop table if exists `auto`;
drop table if exists `usuario_foto`;
drop table if exists `conductor`;
drop table if exists `administrador`;
drop table if exists `arrendatario`;
drop table if exists `usuario`;
drop table if exists `penalizacion`;
drop table if exists `auto_modelo`;
drop table if exists `municipio`;
drop table if exists `estado`;


create table `estado` (
  `pk_estado` tinyint unsigned not null auto_increment,
  `nombre` varchar(50) not null,
  primary key(pk_estado)
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `municipio` (
  `pk_municipio` smallint unsigned not null auto_increment,
  `fk_estado` tinyint unsigned not null,
  `nombre` varchar(50) not null,
  primary key(pk_municipio),
  foreign key(fk_estado) references estado(pk_estado) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `auto_modelo` (
    `pk_auto_modelo` tinyint unsigned not null auto_increment,
    `nombre` varchar(50) not null,
    primary key(pk_auto_modelo),
    unique key(nombre)
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `penalizacion` (
    `pk_penalizacion` tinyint unsigned not null auto_increment,
    `nombre` varchar(50) not null,
    `precio` smallint not null,
    primary key(pk_penalizacion),
    unique key(nombre)
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `usuario` (
  `pk_usuario` smallint unsigned not null auto_increment,
  `nombre` varchar(50) not null,
  `apellido` varchar(50) not null,
  `telefono` varchar(10) not null,
  `correo` varchar(50) not null,
  `contraseña` varchar(50) not null,
  primary key(pk_usuario),
  unique key(correo)
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `arrendatario` (
  `fk_usuario` smallint unsigned not null,
  `fecha_nacimiento` datetime not null,
  `codigo_postal` varchar(5) not null,
  `fk_municipio` smallint unsigned not null,
  `direccion` varchar(50) not null,
  unique key(fk_usuario),
  foreign key(fk_usuario) references usuario(pk_usuario) on delete cascade,
  foreign key(fk_municipio) references municipio(pk_municipio) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `administrador` (
    `fk_usuario` smallint unsigned not null,
    `nombre_empresa` varchar(50) not null,
    unique key(nombre_empresa),
    foreign key(fk_usuario) references usuario(pk_usuario) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `conductor` (
    `fk_usuario` smallint unsigned not null,
    `fk_administrador` smallint unsigned not null,
    foreign key(fk_usuario) references usuario(pk_usuario) on delete cascade,
    foreign key(fk_administrador) references usuario(pk_usuario) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `usuario_foto` (
    `fk_usuario` smallint unsigned not null,
    `imagen_ruta` varchar(100) not null,
    unique key(imagen_ruta),
    foreign key(fk_usuario) references usuario(pk_usuario) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `auto` (
    `pk_auto` mediumint unsigned not null auto_increment,
    `fk_administrador` smallint unsigned not null,
    `fk_modelo` tinyint unsigned not null,
    `precio` smallint unsigned not null,
    `tipo` enum("1", "2", "3", "4", "5") not null,
    `asientos` tinyint not null,
    `puertas` tinyint not null,
    `cajuela` enum("1", "2", "3", "4") not null,
    `cilindros` tinyint not null,
    `caballos_fuerza` tinyint not null,
    `capacidad_tanque` tinyint not null,
    `capacidad_bateria` tinyint not null,
    `transmicion` enum("1", "2") not null,
    `color_pintura` varchar(20) not null,
    `aire_acondicionado` enum("1", "2") not null,
    `gps` enum("1", "2") not null,
    `vidrios_polarizados` enum("1", "2") not null,
    primary key(pk_auto),
    foreign key(fk_administrador) references usuario(pk_usuario) on delete cascade,
    foreign key(fk_modelo) references auto_modelo(pk_auto_modelo) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `renta` (
    `pk_renta` int unsigned not null auto_increment,
    `fk_auto` mediumint unsigned not null,
    `fk_arrendatario` smallint unsigned not null,
    `fk_conductor` smallint unsigned not null,
    `punto_entrega` varchar(100) not null,
    `punto_devolucion` varchar(100) not null,
    `fecha_entrega` date not null,
    `hora_entrega` time not null,
    `fecha_devolucion` date not null,
    `hora_devolucion` time not null,
    `costo` smallint not null,
    primary key(pk_renta),
    foreign key(fk_auto) references auto(pk_auto) on delete cascade,
    foreign key(fk_arrendatario) references usuario(pk_usuario) on delete cascade,
    foreign key(fk_conductor) references usuario(pk_usuario) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `reporte_entrega` (
    `pk_reporte_entrega` int unsigned not null auto_increment,
    `fk_renta` int unsigned not null,
    `todo_bien` enum("1", "2") not null,
    `descripcion` varchar(255) not null,
    primary key(pk_reporte_entrega),
    foreign key(fk_renta) references renta(pk_renta) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `reporte_devolucion` (
    `pk_reporte_devolucion` int unsigned not null auto_increment,
    `fk_renta` int unsigned not null,
    `todo_bien` enum("1", "2") not null,
    `descripcion` varchar(255) not null,
    primary key(pk_reporte_devolucion),
    foreign key(fk_renta) references renta(pk_renta) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `reporte_entrega_imagen` (
    `fk_reporte_entrega` int unsigned not null,
    `fk_penalizacion` tinyint unsigned not null,
    `imagen_ruta` varchar(100) not null,
    unique key(imagen_ruta),
    foreign key(fk_reporte_entrega) references reporte_entrega(pk_reporte_entrega) on delete cascade,
    foreign key(fk_penalizacion) references penalizacion(pk_penalizacion) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `reporte_devolucion_imagen` (
    `fk_reporte_devolucion` int unsigned not null,
    `fk_penalizacion` tinyint unsigned not null,
    `imagen_ruta` varchar(100) not null,
    unique key(imagen_ruta),
    foreign key(fk_reporte_devolucion) references reporte_devolucion(pk_reporte_devolucion) on delete cascade,
    foreign key(fk_penalizacion) references penalizacion(pk_penalizacion) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

COMMIT;