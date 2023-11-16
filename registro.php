<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/FuncionesCliente.php';

$db = new Database();
$con = $db->conectar();

$errors = [];
if (!empty($_POST)) {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $documento = trim($_POST['documento']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esNulo([$nombres, $apellidos, $email, $telefono, $documento, $usuario, $password, $repassword])) {
        $errors[] = "Debe llenar todo los campos ";
    }

    if (esEmail($email)) {
        $errors[] = "La dirección de correo no es valida ";
    }
    if (validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden ";
    }
    if (usuarioExiste($usuario, $con)) {
        $errors[] = "El nombre de usuario $usuario ya existe ";
    }
    if (mailExiste($email, $con)) {
        $errors[] = "El correo $email ya esta registrado ";
    }


    $id = resgistraCliente([$nombres, $apellidos, $email, $telefono, $documento], $con);
    if ($id > 0) {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = generarToken();
        if (registraUsuario([$usuario, $password, $token, $id], $con)) {
            $errors[] = 'Error al registrar este cliente ';
        }
    } else {
        $errors[] = 'Error al registrar este cliente ';
    }
    if( count($errors) == 0) {
    }else{
        print_r($errors);
    }
}
print_r($_SESSION);
//session_destroy();

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <header data-bs-theme="dark">
        <div class="collapse text-bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2"
                        viewBox="0 0 24 24">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                    <strong>Tienda Nico</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Ropa</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Contactanos</a>
                        </li>
                        <li class="nav-item">
                            <a href>Nicolas Agudelo Gómez - ID: 695076</h2>
                        </li>
                    </ul>
                    <a href="carrito.php" class="btn btn-primary me-2">
                        Carrito <span id="num_cart" class="badge bg-secondary">
                            <?php echo $num_cart; ?>
                        </span>
                    </a>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="#" class="btn btn-success"><i class="fas fa-user"></i>
                            <?php echo $_SESSION['user_name']; ?>
                        </a>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-success"><i class="fas fa-user"></i>
                            Ingresar </a>
                    <?php } ?>
                </div>
    </header>
    <main>
        <div class="container">
            <h2>Datos del cliente</h2>
            <?php mostrarMensajes($errors); ?>
            <form class="row g-3" action="registro.php" method="post" autocomplete="off">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-danger">*</span>Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger">*</span>Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email"><span class="text-danger">*</span>Correo electronico</label>
                    <input type="email" name="email" id="email" class="form-control" requireda>
                    <span id="validaEmail" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="telefono"><span class="text-danger">*</span>Telefono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="documento"><span class="text-danger">*</span>Documento</label>
                    <input type="text" name="documento" id="documento" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger">*</span>Usuario</label>
                    <span id="validaUsuario" class="text-danger"></span>
                    <input type="text" name="usuario" id="usuario" class="form-control" requireda>

                </div>
                <div class="col-md-6">
                    <label for="password"><span class="text-danger">*</span>Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="repassword"><span class="text-danger">*</span>Repetir Contraseña</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" required>
                </div>
                <i><b>Nota: </b>Los campos con asterisco son obligatorios</i>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <script>
        let txtEmail = document.getElementById('email')
        txtEmail.addEventListener("blur", function () {
            existeEmail(txtEmail.value)
        }, false)

        function existeEmail(email) {
            let url = "clases/cliente.php"
            let formData = new FormData()
            formData.append("action", "existeEmail")
            formData.append("email", email)

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(Response => response.json())
                .then(data => {
                    if (data.ok) {
                        document.getElementById('email').value = ''
                        document.getElementById('validaEmail').innerHTML = 'Email no disponible'
                    } else {
                        document.getElementById('validaEmail').innerHTML = ''
                    }
                })
        }

        let txtUsuario = document.getElementById('usuario')
        txtUsuario.addEventListener("blur", function () {
            existeUsuario(txtUsuario.value)
        }, false)

        function existeUsuario(usuario) {
            let url = "clases/cliente.php"
            let formData = new FormData()
            formData.append("action", "existeUsuario")
            formData.append("usuario", usuario)

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(Response => response.json())
                .then(data => {
                    if (data.ok) {
                        document.getElementById('usuario').value = ''
                        document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
                    } else {
                        document.getElementById('validaUsuario').innerHTML = ''
                    }
                })
    }

    </script>
</body>

</html>