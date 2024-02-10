# biblioteca_simple
Simple desarrollo de una biblioteca virtual realizado en PHP

Estructura de base de datos
CREATE DATABASE IF NOT EXISTS biblioteca;
USE biblioteca;
CREATE TABLE institucion(
	id int primary key auto_increment,
    name text not null,
    description text default null,
    register_date timestamp default current_timestamp
);
CREATE TABLE libro(
	id int primary key auto_increment,
    idBiblioteca int not null,
    name text not null,
    autor text not null,
    description text default null,
    register_date timestamp default current_timestamp,
    foreign key(idBiblioteca) references institucion(id)
);
