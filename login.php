<?php
session_start();

// Si el usuario ya está logueado, redirigir a la página principal
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Array de usuarios fijos
    $users = [
        'adamix' => ['password' => 'pasemesolosilomeresco70', 'id' => 1],
        'admin' => ['password' => 'admin', 'id' => 2],
        'empleado' => ['password' => 'empleado', 'id' => 3]
    ];

    // Verificar si el usuario existe y la contraseña es correcta
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['user_id'] = $users[$username]['id'];
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="login-page">
    <div class="login-container">
        <h2 class="login-title">Iniciar Sesión</h2>
        <?php if ($error) : ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="login-button">Iniciar sesión</button>
            </div>
        </form>
    </div>
</body>

</html>