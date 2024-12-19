-- Crear base de datos de inicio de sesion 

CREATE DATABASE Inicio_sesion;

USE Inicio_sesion;

CREATE TABLE Inicio(
Id_usuario INT AUTOINCREMENT,
Nombre VARCHAR (50) NOT NULL,
Edad INT NOT NULL,
Sexo VARCHAR (10) NOT NULL,
correo VARCHAR (30) NOT NULL,
contraseña VARCHAR (20) NOT NULL,
PRIMARY KEY (Id_usuario)
) ENGINE = InnoDB;