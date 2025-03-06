<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController {

    public static function login(Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            
            if (empty($alertas)) {
                // Comprobrr que exista el usuario
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    // Verificar el password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar 
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                        //debuguear($_SESSION);
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }

        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        session_start();
        //debuguear($_SESSION);
        $_SESSION = [];
        header('Location: /');    
    }


    public static function olvide(Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado === "1") {
                    // Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    
                    // TODO: Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu mail');

                } else {
                    Usuario::setAlerta('error', 'El Usuario no existe o no está confimado');
                    
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }


    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        
        // Buscar usuario por su token
        $usuario = Usuario::where('token', $token); // El Usuario de la base de datos

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
            $error = true;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $password->validarPassword();

            if (empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {
        $usuario = new Usuario($_POST);  
        $alertas = []; // ALERTAS VACIAS

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alertas este vacio
            if (empty($alertas)) {
                $resultado = $usuario->existeUsuario(); // Verificar que el usuario no este registrado

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPassword(); // Hashear el Password
                    $usuario->crearToken(); // Generar Token
                    
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token); // Enviar el mail
                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar(); // Crear el usuario
                    //debuguear($resultado);
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }


    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']); //debuguear($token);
        $usuario = Usuario::where('token', $token); //debuguear($usuario);
        
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido'); // Mostrar mensaje de error
        } else {
            $usuario->confirmado = "1"; // Modificar a usuario confirmado
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }
 
        $alertas = Usuario::getAlertas();  // Obtener alertas
        $router->render('auth/confirmar-cuenta', [   // Renderizar la vista
            'alertas' => $alertas
        ]);
    }






}