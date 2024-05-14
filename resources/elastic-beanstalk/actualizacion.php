<?php
include 'funciones.php';
$pdo = conectar_mariadb();
$mensaje = '';
// Comprueba si el ID de contacto existe
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
// Esta parte es similar a insercion.php, pero en su lugar se actualiza el registro
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
        $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
        $fechaCreacion = isset($_POST['fechaCreacion']) ? $_POST['fechaCreacion'] : date('Y-m-d H:i:s');
	// Actualizar el registro
        $stmt = $pdo->prepare('UPDATE contactos SET id = ?, nombre = ?, email = ?, telefono = ?, cargo = ?, fechaCreacion = ? WHERE id = ?');
        $stmt->execute([$id, $nombre, $email, $telefono, $cargo, $fechaCreacion, $_GET['id']]);
        $mensaje = 'Actualizacion realizada';
    }
	// Obtener el contacto de la tabla de contactos
    $stmt = $pdo->prepare('SELECT * FROM contactos WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contacto = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contacto) {
        exit('No existe un contacto con ese ID');
    }
} else {
    exit('No se especifico un ID');
}
?>

<?=cabecera('Lectura')?>

<div class="content update">
    <h2>Actualizar Contacto #<?=$contacto['id']?></h2>
    <form action="actualizacion.php?id=<?=$contacto['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nombre">Nombre</label>
        <input type="text" name="id" placeholder="1" value="<?=$contacto['id']?>" id="id" readonly>
        <input type="text" name="nombre" placeholder="Jose Emilio" value="<?=$contacto['nombre']?>" id="nombre" required>
        <label for="email">E-mail</label>
        <label for="telefono">Tel&eacute;fono</label>
        <input type="text" name="email" placeholder="joseemilio.vera@iestetuan.es" value="<?=$contacto['email']?>" id="email" required>
        <input type="text" name="telefono" placeholder="2025550143" value="<?=$contacto['telefono']?>" id="telefono" required>
        <label for="cargo">T&iacute;tulo</label>
        <label for="fechaCreacion">Creado</label>
        <input type="text" name="cargo" placeholder="Employee" value="<?=$contacto['cargo']?>" id="cargo" required>
        <input type="datetime-local" name="fechaCreacion" value="<?=date('Y-m-d\TH:i', strtotime($contacto['fechaCreacion']))?>" id="fechaCreacion" required>
        <input type="submit" value="Update">
    </form>
    <?php if ($mensaje): ?>
    <p><?=$mensaje?></p>
    <?php endif; ?>
</div>

<?=pie()?>
