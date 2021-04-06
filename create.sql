SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

drop table if exists `reporte_devolucion_imagen`;
drop table if exists `reporte_devolucion`;
drop table if exists `renta`;
drop table if exists `auto_imagen`;
drop table if exists `auto`;
drop table if exists `usuario_foto`;
drop table if exists `conductor_codigo`;
drop table if exists `conductor`;
drop table if exists `administrador`;
drop table if exists `arrendatario`;
drop table if exists `usuario_peticion`;
drop table if exists `usuario`;
drop table if exists `penalizacion`;
drop table if exists `auto_color_pintura`;
drop table if exists `auto_modelo`;
drop table if exists `auto_marca`;
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

create table `auto_marca` (
    `pk_auto_marca` tinyint unsigned not null auto_increment,
    `nombre` varchar(50) not null,
    primary key(pk_auto_marca),
    unique key(nombre)
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `auto_modelo` (
    `pk_auto_modelo` smallint unsigned not null auto_increment,
    `fk_auto_marca` tinyint unsigned not null,
    `nombre` varchar(50) not null,
    primary key(pk_auto_modelo),
    foreign key(fk_auto_marca) references auto_marca(pk_auto_marca) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `auto_color_pintura` (
    `pk_auto_color_pintura` tinyint unsigned not null auto_increment,
    `nombre` varchar(50) not null,
    primary key(pk_auto_color_pintura)
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
  `token` varchar(255) not null,
  `nombre` varchar(50) not null,
  `apellido` varchar(50) not null,
  `telefono` varchar(10) not null,
  `correo` varchar(50) not null,
  `contraseña` varchar(255) not null,
  primary key(pk_usuario),
  unique key(token),
  unique key(correo)
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `usuario_peticion` (
  `fk_usuario` smallint unsigned not null,
  `fecha_hora` timestamp default current_timestamp not null,
  unique key(fk_usuario),
  foreign key(fk_usuario) references usuario(pk_usuario) on delete cascade
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

create table `conductor_codigo` (
    `fk_administrador` smallint unsigned not null,
    `codigo` varchar(20) not null,
    `vencimiento` datetime not null,
    unique key(fk_administrador, codigo),
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
    `fk_auto_modelo` smallint unsigned not null,
    `fk_auto_color_pintura` tinyint unsigned not null,
    `precio` smallint unsigned not null,
    /* 0 - Camioneta
     * 1 - Compacto
     * 2 - Sedan
     * 3 - Suburban
     * 4 - Pickup
     */
    `tipo` enum("0", "1", "2", "3", "4") not null,
    /* 0 - Gasolina
     * 1 - Diesel
     * 2 - Electrico
     * 3 - Gas
     * 4 - Hibrido Gasolina-Electrico
     * 5 - Hibrido Gasolina-Gas
     */
    `tipo_motor` enum("0", "1", "2", "3", "4", "5") not null,
    `asientos` tinyint unsigned not null,
    `puertas` tinyint unsigned not null,
    /* 0 - No tiene
     * 1 - Pequeña
     * 2 - Mediana
     * 3 - Grande
     */
    `capacidad_cajuela` enum("0", "1", "2", "3") not null,
    /* 0 - Cobertura amplia
     * 1 - Cobertura limitada
     * 2 - Responsabilidad civil
     */
    `seguro` enum("0", "1", "2") not null,
    `unidad_consumo` tinyint unsigned not null,
    `caballos_fuerza` tinyint unsigned not null,
    `capacidad_combustible` tinyint unsigned not null,
    `transmicion` enum("0", "1") not null,
    `repuesto` enum("0", "1") not null,
    `caja_herramientas` enum("0", "1") not null,
    `aire_acondicionado` enum("0", "1") not null,
    `gps` enum("0", "1") not null,
    `vidrios_polarizados` enum("0", "1") not null,
    primary key(pk_auto),
    foreign key(fk_administrador) references usuario(pk_usuario) on delete cascade,
    foreign key(fk_auto_modelo) references auto_modelo(pk_auto_modelo) on delete cascade,
    foreign key(fk_auto_color_pintura) references auto_color_pintura(pk_auto_color_pintura) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `auto_imagen` (
    `fk_auto` mediumint unsigned not null,
    `portada` enum("0", "1") not null,
    `imagen_ruta` varchar(100) not null,
    unique key(imagen_ruta),
    foreign key(fk_auto) references auto(pk_auto) on delete cascade
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

create table `reporte_devolucion` (
    `pk_reporte_devolucion` int unsigned not null auto_increment,
    `fk_renta` int unsigned not null,
    `todo_bien` enum("0", "1") not null,
    `descripcion` varchar(255) not null,
    primary key(pk_reporte_devolucion),
    foreign key(fk_renta) references renta(pk_renta) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

create table `reporte_devolucion_imagen` (
    `fk_reporte_devolucion` int unsigned not null,
    `fk_penalizacion` tinyint unsigned not null,
    `imagen_ruta` varchar(100) not null,
    unique key(imagen_ruta),
    foreign key(fk_reporte_devolucion) references reporte_devolucion(pk_reporte_devolucion) on delete cascade,
    foreign key(fk_penalizacion) references penalizacion(pk_penalizacion) on delete cascade
) engine=InnoDB default charset=utf8 collate=utf8_unicode_ci;

INSERT INTO auto_color_pintura (nombre) VALUES ("Azúl");
INSERT INTO auto_color_pintura (nombre) VALUES ("Rojo");
INSERT INTO auto_color_pintura (nombre) VALUES ("Verde");
INSERT INTO auto_color_pintura (nombre) VALUES ("Morado");
INSERT INTO auto_color_pintura (nombre) VALUES ("Amarillo");

COMMIT;