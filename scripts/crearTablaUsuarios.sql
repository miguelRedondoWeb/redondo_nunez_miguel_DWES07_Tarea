use proyecto;

create table usuarios(
usuario varchar(20) primary key,
pass varchar(64) not null
);


insert into usuarios select 'admin' , sha2('secreto',256);
insert into usuarios select 'gestor' , sha2('pass',256);