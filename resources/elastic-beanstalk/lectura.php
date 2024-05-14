<?php
include 'funciones.php';
// Conexion a MariaDB
$pdo = conectar_mariadb();
// Se obtiene la pagina mediante una solicitud GET
$pagina = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Numero de registros a mostrar en cada pagina
$registrosPorPagina = 5;

// Preparar la sentencia SQL y obtener los registros de la tabla de contactos
$stmt = $pdo->prepare('SELECT * FROM contactos ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($pagina-1)*$registrosPorPagina, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $registrosPorPagina, PDO::PARAM_INT);
$stmt->execute();
// Obtener los registros para visualizarlos en la plantilla
$contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
// Obtener el total de contactos, para determinar si se debe mostrar un boton SIGUIENTE y PREVIO
$numContactos = $pdo->query('SELECT COUNT(*) FROM contactos')->fetchColumn();
?>

<?=cabecera('Lectura')?>

<div class="content read">
	<h2>LEER CONTACTOS</h2>
	<a href="insercion.php" class="create-contact">Crear Contacto</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nombre</td>
                <td>E-mail</td>
                <td>Tel&eacute;fono</td>
                <td>T&iacute;tulo</td>
                <td>Creado</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contactos as $contacto): ?>
            <tr>
                <td><?=$contacto['id']?></td>
                <td><?=$contacto['nombre']?></td>
                <td><?=$contacto['email']?></td>
                <td><?=$contacto['telefono']?></td>
                <td><?=$contacto['cargo']?></td>
                <td><?=$contacto['fechaCreacion']?></td>
                <td class="actions">
                    <a href="actualizacion.php?id=<?=$contacto['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="borrado.php?id=<?=$contacto['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($pagina > 1): ?>
		<a href="lectura.php?page=<?=$pagina-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($pagina*$registrosPorPagina < $numContactos): ?>
		<a href="lectura.php?page=<?=$pagina+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=pie()?>