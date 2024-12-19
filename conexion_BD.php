<?php
	//La conexión recibe los parámetros servidor= localhost, usuario="root", contraseña="" y nombre de la base de datos= alumnos, separados por comas y entre comillas simples
	$mysqli = new mysqli('localhost', 'root', '', 'inicio_sesion');
	if($mysqli->connect_error){
		//connect_error es un procedimiento que nos devuelve una cadena que describe el error que atravesó la ejecución y en caso de no haber error genera un null
		die('Error en la conexion' . $mysqli->connect_error);}

?>