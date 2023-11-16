<?php
function esNulo(array $parametros)
{
    foreach ($parametros as $parametro) {
        if (strlen(trim($parametro)) < 1) {
            return true;
        }
    }
    return false;
}
function esEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}
function validaPassword($password, $repassword)
{
    if (strcmp($password, $repassword) === 0) {
        return true;
    }
    return false;
}
function generarToken()
{
    return md5(uniqid(mt_rand(), false));
}
function resgistraCliente(array $datos, $con)
{
    $sql = $con->prepare("INSERT INTO cliente (Nombre_cliente, Apellido_cliente, Correo_cliente, Tel_cliente, Documento_cliente) VALUES (?,?,?,?,?)");
    if ($sql->execute($datos)) {
        return $con->lastInsertID();
    }
    return 0;
}

function registraUsuario(array $datos, $con)
{
    $sql = $con->prepare("INSERT INTO usuario (usuario, password, Token, Id_cliente) VALUES (?,?,?,?)");
    if ($sql->execute($datos)) {
        return true;
    }
    return false;
}
function usuarioExiste($usuario, $con)
{
    $sql = $con->prepare("SELECT id FROM usuario WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}
function mailExiste($email, $con)
{
    $sql = $con->prepare("SELECT Cli_cod FROM cliente WHERE Correo_cliente LIKE ? LIMIT 1");
    $sql->execute([$email]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

function mostrarMensajes(array $errors)
{
    if (count($errors) > 0) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '<ul>';
        echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}
function login($usuario, $password, $con)
{
    $sql = $con->prepare("SELECT id, usuario, password FROM usuario WHERE Usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (esActivo($usuario, $con)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['usuario'];
                header("Location: index.php");
                exit;
            }
        } else {
            return 'El usuario no ha sido activado ';
        }
    }
}

function esActivo($usuario, $con)
{
    $sql = $con->prepare("SELECT Activación FROM usuario WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row['Activación'] == 0) {
        return true;
    }
    return false;
}