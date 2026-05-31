<?php
// Configuración de la conexión usando las variables de entorno del docker-compose
$host = 'db'; 
$db   = 'crud_db';
$user = 'root';
$pass = 'secret_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // Conexión PDO a la base de datos
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     echo "Error de conexión: " . $e->getMessage();
     exit;
}

// --- LÓGICA DEL CRUD ---

// C: Crear (Insertar registro)
if (isset($_POST['create'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email) VALUES (?, ?)");
    $stmt->execute([$nombre, $email]);
    header("Location: index.php");
    exit;
}

// U: Modificar (Actualizar registro)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
    $stmt->execute([$nombre, $email, $id]);
    header("Location: index.php");
    exit;
}

// D: Borrar (Eliminar registro)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// R: Leer (Obtener todos los registros para listarlos)
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll();

// Auxiliar para cargar los datos en el formulario cuando se presiona "Modificar"
$usuario_editar = null;
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id_edit]);
    $usuario_editar = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Taller Docker - CRUD</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; color: #333; }
        h2, h3 { color: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007BFF; color: white; }
        .btn { padding: 8px 12px; text-decoration: none; color: white; border-radius: 4px; border: none; cursor: pointer; display: inline-block; }
        .btn-add { background-color: #28a745; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; }
        form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 400px; margin-bottom: 30px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-group input { width: 95%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
    </style>
</head>
<body>

    <h2>Menú Principal - Operaciones CRUD</h2>
    <hr>

    <form action="index.php" method="POST">
        <h3><?php echo $usuario_editar ? "Modificar Registro (U)" : "Crear Registro (C)"; ?></h3>
        
        <?php if ($usuario_editar): ?>
            <input type="hidden" name="id" value="<?php echo $usuario_editar['id']; ?>">
        <?php endif; ?>
        
        <div class="input-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $usuario_editar ? htmlspecialchars($usuario_editar['nombre']) : ''; ?>" required>
        </div>
        <div class="input-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $usuario_editar ? htmlspecialchars($usuario_editar['email']) : ''; ?>" required>
        </div>
        
        <?php if ($usuario_editar): ?>
            <button type="submit" name="update" class="btn btn-add">Actualizar Registro</button>
            <a href="index.php" style="margin-left: 10px; color: #666;">Cancelar</a>
        <?php else: ?>
            <button type="submit" name="create" class="btn btn-add">Guardar Registro</button>
        <?php endif; ?>
    </form>

    <h3>Registros Actuales en Base de Datos (R)</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones (U / D)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($usuarios) > 0): ?>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $u['id']; ?>" class="btn btn-edit">Modificar</a>
                        <a href="index.php?delete=<?php echo $u['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Borrar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: #777;">No hay registros encontrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
