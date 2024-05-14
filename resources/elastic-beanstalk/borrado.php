<?php
include 'funciones.php';
$pdo = conectar_mariadb();
$mensaje = '';
// Se comprueba si el ID de contacto existe
if (isset($_GET['id'])) {
// Selecciona el registro que se elminará
    $stmt = $pdo->prepare('SELECT * FROM contactos WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contacto = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contacto) {
        exit('No existe el contacto con ese ID');
    }
    // Se asegura que el usuario confirma antes del borrado
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
    // El usuario hizo clic en el boton SI
            $stmt = $pdo->prepare('DELETE FROM contactos WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $mensaje = 'Contacto eliminado con exito';
        } else {
    // El usuario hizo clic en el boton NO, se redirige a la pagina de lectura
            header('Location: lectura.php');
            exit;
        }
    }
} else {
    exit('No se especifico el ID');
}
?>

<?=cabecera('Borrado')?>

<div class="content delete">
    <h2>Eliminar contacto #<?=$contacto['id']?></h2>
    <?php if ($mensaje): ?>
    <p><?=$mensaje?></p>
    <?php else: ?>
    <p>¿Estas seguro que deseas eliminar el contacto #<?=$contacto['id']?>?</p>
    <div class="yesno">
        <a href="borrado.php?id=<?=$contacto['id']?>&confirm=yes">SI</a>
        <a href="borrado.php?id=<?=$contacto['id']?>&confirm=no">NO</a>
    </div>
    <?php endif; ?>
</div>

<?=pie()?>
