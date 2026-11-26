<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cerrando sesión... | Botica Biofarma</title>
</head>
<body>
    <script>
        sessionStorage.removeItem("token");
        sessionStorage.removeItem("usuario");
        sessionStorage.removeItem("rol");
        window.location.href = "login.php";
    </script>
</body>
</html>
