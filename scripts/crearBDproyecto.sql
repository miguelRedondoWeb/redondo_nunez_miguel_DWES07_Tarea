create database proyecto DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use proyecto;

create table if not exists tiendas(
 id int auto_increment primary key,
 nombre varchar(100) not null,
 tlf varchar(13) null
);

create table if not exists familias(
 cod varchar(6) primary key,
 nombre varchar(200) not null
);

create table if not exists productos(
 id int auto_increment primary key,
 nombre varchar(200) not null,
 nombre_corto varchar(50) unique not null,
 descripcion text null,
 pvp decimal(10, 2) not null,
 familia varchar(6) not null,
 constraint fk_prod_fam foreign key(familia) references familias(cod) on update
cascade on delete cascade
);

create table if not exists stocks(
 producto int,
 tienda int,
 unidades int unsigned not null,
 constraint pk_stock primary key(producto, tienda),
 constraint fk_stock_prod foreign key(producto) references productos(id) on update
cascade on delete cascade,
 constraint fk_stock_tienda foreign key(tienda) references tiendas(id) on update
cascade on delete cascade
);

create user gestor@'localhost' identified by "secreto";

grant all on proyecto.* to gestor@'localhost';