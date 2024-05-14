<?php

require './vendor/autoload.php';
use Aws\Ssm\SsmClient;
use Aws\Exception\AwsException;

function conectar_mariadb() {
    try {
    //Se obtiene la contraseña de la BD desde AWS SSM Parameter Store
        $cliente = new SsmClient(['version' => 'latest', 'region' => $_SERVER['AWS_REGION']]);
        $resultado = $cliente->getParameter(['Name' => $_SERVER['RDS_DB_SECRET'], 'WithDecryption' => true]);
        $password=$resultado['Parameter']['Value'];
    }
    catch (SsmException $e) {
	echo $e->getMessage() . "\n";
    }
    $DATABASE_HOST = $_SERVER['RDS_HOSTNAME'];
    $DATABASE_USER = $_SERVER['RDS_USER_NAME'];
    $DATABASE_PASS = $password;
    $DATABASE_NAME = $_SERVER['RDS_DB_NAME'];
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $excepcion) {
    	// Si hubiera un error con la conexion, se para el script y se visualiza el error
    	exit('Error al conectar con la base de datos '.$excepcion);
    }
}
function cabecera($titulo) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$titulo</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>OPERACIONES CRUD EN PHP Y MARIADB</h1>
            <a href="index.php"><i class="fas fa-home"></i>Inicio</a>
    		<a href="lectura.php"><i class="fas fa-user"></i>Contactos</a>
    	</div>
    </nav>
EOT;
}

function pie() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>
