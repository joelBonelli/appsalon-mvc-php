<?php

namespace Controllers;
use MVC\Router;
use Model\AdminCita;
use Model\Cita;

class AdminController {

    public static function index(Router $router) {
        session_start();

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        if ( !checkdate( $fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }

        // Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta); //debuguear($citas);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }


    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            //debuguear($_SERVER);
            $cita = Cita::find($id);
            $cita ->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }



}