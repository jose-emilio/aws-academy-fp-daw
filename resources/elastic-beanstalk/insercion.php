<?php
include 'funciones.php';
$pdo = conectar_mariadb();
$mensaje = '';
// Se comprueba si los datos de POST no estan vacios
if (!empty($_POST)) {
    // Los datos de POST no vacíos insertan un nuevo registro
    // Se configuran las variables que se insertaran, deben comprobarse si las variables POST existen, sino se dejan en blanco
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Se comrpueba si la variable POST "nombre" existe, sino se deja el valor por defecto a blanco, lo mismo para el resto de variables
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
    $fechaCreacion = isset($_POST['fechaCreacion']) ? $_POST['fechaCreacion'] : '';
    // Se inserta un nuevo registro en la tabla de contactos
    $stmt = $pdo->prepare('INSERT INTO contactos VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $nombre, $email, $telefono, $cargo, $fechaCreacion]);
    // Mensaje de salida
    $mensaje = 'Creado con exito!';
}
?>

<?=cabecera('Insertar')?>

<div class="content update">
    <h2>Crear Contacto</h2>
    <form action="insercion.php" method="post">
        <label for="id">ID</label>
        <label for="nombre">Nombre</label>
        <input type="text" name="id" id="id">
        <input type="text" name="nombre" id="nombre" required>
        <label for="email">E-mail</label>
        <label for="telefono">Tel&eacute;fono</label>
        <input type="text" name="email" id="email" required>
        <input type="text" name="telefono" id="telefono" required>
        <label for="cargo">T&iacute;tulo</label>
        <label for="fechaCreacion">Creado</label>
        <input type="text" name="cargo" id="cargo" required>
        <input type="datetime-local" name="fechaCreacion" id="fechaCreacion" required>
        <input type="submit" value="Create">
    </form>
    <?php if ($mensaje): ?>
    <p><?=$mensaje?></p>
    <?php endif; ?>
</div>

<?=pie()?>
