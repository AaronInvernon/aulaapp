<?php

class UsuariosController extends MvcController {
    #REGISTRO DE USUARIOS registro.php
    #-------------------------------------

    public function registroUsuarioController() {
        if (isset($_POST["usuarioRegistro"])) {
            $datosController = array("user" => $_POST["usuarioRegistro"],
              "password" => $_POST["passwordRegistro"],
                "nombre" => $_POST["nombreRegistro"],
                "apellido1" => $_POST["apellido1Registro"],
                "apellido2" => $_POST["apellido2Registro"],
                "email" => $_POST["emailRegistro"]
            );

            $respuesta = UsuariosModel::registroUsuarioModel($datosController, "usuario");

            if ($respuesta == "ok") {
                header("location:index.php?action=ok");
            } else {
                header("location:index.php");
            }
        }
    }

    #Registro de usuarios ingresar.php
    #------------------------------------

    public function ingresoUsuarioController() {
        if (isset($_POST["usuarioIngreso"])) {
            $datosController = array("user" => $_POST["usuarioIngreso"],
                "password" => $_POST["passwordIngreso"]);

            $respuesta = UsuariosModel::ingresoUsuarioModel($datosController, "usuario");

            if ((strtolower($respuesta["user"]) == strtolower($_POST["usuarioIngreso"])) &&
                    ($respuesta["password"] == sha1($_POST["passwordIngreso"]))) {
                //para que iniciemos sesion y continuemos logueados
                session_start();

                $_SESSION["validar"] = true;
                $_SESSION["userId"] = $respuesta["id"];
                $_SESSION["rol"] = $respuesta["rolID"];
                $_SESSION["usuario"] = $respuesta["user"];
                $_SESSION["notificaciones"] = $respuesta["notificaciones"]; //esto quizá haya que quitarlo al hacerse con ajax
                $_SESSION["inscrito"] = $respuesta["inscritoCurso"];
                $_SESSION["inscritoAsignaturas"] = $respuesta["inscritoAsignaturas"];
                $_SESSION["fallosLogin"] = $respuesta["contador_fallo_login"];
                /*
                 * Me va a hacer falta también el curso   
                 * las asignaturas? en un array
                 * 
                 * 
                 */
                header("location:index.php?action=matricular");
            } else {
                header("location:index.php?action=fallo");
            }
        }
    }

    #Listar usuarios usuarios.php
    #------------------------------------

    public function vistaUsuariosController() {

        $respuesta = UsuariosModel::vistaUsuariosModel("usuario");

        foreach ($respuesta as $fila => $item) {
            echo'<tr>
				<td>' . $item["user"] . '</td>
				<td>' . $item["nombre"] .' '. $item["apellido1"].' '. $item["apellido2"]. '</td>
				<td><a href="index.php?action=usuarios&idAutorizarAlumno=' . $item["id"] . '"><button title="Autorizar como alumno">Autorizar usuario como alumno</button></a><br>
                                    <a href="index.php?action=usuarios&idAutorizarProfesor=' . $item["id"] . '"><button title="Autorizar como profesor">Autorizar usuario como profesor</button></a><br>
                                    <a href="index.php?action=usuarios&idAutorizarAdmin=' . $item["id"] . '"><button title="Autorizar como admin">Autorizar usuario como administrador</button></a></td>
				<td><a href="index.php?action=usuarios&idBorrar=' . $item["id"] . '"><button title="¿Estás seguro que quieres hacer eso?">Borrar</button></a></td>
			</tr>';
        }
    }

    #Editar usuario editar.php
    #------------------------------------

    public function editarUsuarioController() {

        $datosController = $_SESSION["userId"];

        //echo $datos;

        $respuesta = UsuariosModel::editarUsuarioModel($datosController, "usuario");

        echo '
		<input type="hidden" value="' . $respuesta["id"] . '" name="idEditar">

		<input type="text" value="' . $respuesta["user"] . '" name="usuarioEditar" required>
                    
		<input type="text" value="' . $respuesta["nombre"] . '" name="nombreEditar" required>
                    
		<input type="text" value="' . $respuesta["apellido1"] . '" name="apellido1Editar" required>
                    
		<input type="text" value="' . $respuesta["apellido2"] . '" name="apellido2Editar" required>

		<input type="hidden" value="' . $respuesta["password"] . '" name="passwordEditar" required>
                
                Antigua contraseña <input type="password" value="" name="oldPassword" required>
                
                Nueva contraseña<input type="password" value="" name="newPassword" required>
                
                Repite nueva contraseña<input type="password" value="" name="newRePassword" required>

		<input type="email" value="' . $respuesta["email"] . '" name="emailEditar" required>

		<input type="submit" value="Actualizar">';
    }

    #Actualizar usuario editar.php
    #------------------------------------

    public function actualizarUsuarioController() {

        if (isset($_POST["usuarioEditar"])) {
            $datosController = array(
                "id" => $_SESSION["userId"],
                "user" => $_POST["usuarioEditar"],
                "nombre" => $_POST["nombreEditar"],
                "ape1" => $_POST["apellido1Editar"],
                "ape2" => $_POST["apellido2Editar"],
                "pass" => $_POST["passwordEditar"],
                "passAntiguo" => sha1($_POST["oldPassword"]),
                "newPass" => $_POST["newPassword"],
                "rePassAntiguo" => $_POST["newRePassword"],
                "email" => $_POST["emailEditar"]
            ); //para enviarle al modelo para modificar

            if (($datosController["pass"] == $datosController["passAntiguo"]) && ($datosController["newPass"] == $datosController["rePassAntiguo"]) && $datosController["pass"] != "" && $datosController["passAntiguo"] != "" && $datosController["newPass"] != "" && $datosController["rePassAntiguo"] != "") {
                $respuesta = UsuariosModel::actualizarUsuarioModel($datosController, "usuario");

                if ($respuesta == "ok") {
                    header("location:index.php?action=perfil");
                } else {
                    echo "error, no se actualizó";
                }
            } else {
                echo 'Ha ocurrido algún error, comprueba que has introducido bien los datos, no se ha actualizado nada.';
            }
        }
    }

    #   Función para ver tu perfil de usuario y modificar algún dato

    public function verPerfilUsuarioController() {
        $datosController = $_SESSION["userId"];

        $respuesta = UsuariosModel::verPerfilUsuarioModel($datosController, "usuario");

        echo '<p><b>Nombre de usuario: </b>' . $respuesta["user"] . '</p>';
        echo '<p><b>Nombre: </b>' . $respuesta["nombre"] . '</p>';
        echo '<p><b>Primer apellido: </b>' . $respuesta["apellido1"] . '</p>';
        echo '<p><b>Segundo apellido: </b>' . $respuesta["apellido2"] . '</p>';
        echo '<p><b>Email: </b>' . $respuesta["email"] . '</p>';
        echo '<p><b>Fecha de registro: </b>' . $respuesta["fecha_alta"] . '</p>';

        echo '<a href="index.php?action=editarPerfil">Editar perfil</a>';
    }

    #   Función para autorizar usuarios que se han dado de alta en la aplicación

    public function autorizarUsuarioAlumnoController() {

        if (isset($_GET["idAutorizarAlumno"])) {
            $datosController = $_GET["idAutorizarAlumno"]; //para enviarle al modelo para modificar



            $respuesta = UsuariosModel::autorizarUsuarioAlumnoModel($datosController, "usuario");

            if ($respuesta == "ok") {
                header("location:index.php?action=usuarios");
            } else {
                echo "error, no se pudo autorizar el usuario :( ";
            }
        }
    }

    public function autorizarUsuarioProfesorController() {

        if (isset($_GET["idAutorizarProfesor"])) {
            $datosController = $_GET["idAutorizarProfesor"]; //para enviarle al modelo para modificar



            $respuesta = UsuariosModel::autorizarUsuarioProfesorModel($datosController, "usuario");

            if ($respuesta == "ok") {
                header("location:index.php?action=usuarios");
            } else {
                echo "error, no se pudo autorizar el usuario :( ";
            }
        }
    }

    public function autorizarUsuarioAdminController() {

        if (isset($_GET["idAutorizarAdmin"])) {
            $datosController = $_GET["idAutorizarAdmin"]; //para enviarle al modelo para modificar



            $respuesta = UsuariosModel::autorizarUsuarioAdminModel($datosController, "usuario");

            if ($respuesta == "ok") {
                header("location:index.php?action=usuarios");
            } else {
                echo "error, no se pudo autorizar el usuario :( ";
            }
        }
    }

    #Borrar usuario en el archivo  editar.php
    #------------------------------------

    public function borrarUsuarioController() {
        if (isset($_GET["idBorrar"])) {

            $datosController = $_GET["idBorrar"];
            $respuesta = UsuariosModel::borrarUsuarioModel($datosController, "usuario");
            if ($respuesta == "ok") {
                header("location:index.php?action=lUsuarios");
            }
        }
    }

    public function listarUsuariosController() { // con esta función listaremos TODOS los usuarios de la aplicación
        $respuesta = UsuariosModel::listarUsuariosModel("usuario");

        foreach ($respuesta as $fila => $item) {
            echo'<tr>
				<td>' . $item["user"] . '</td>
				<td>' . $item["email"] . '</td>				
				<td><a href="index.php?action=usuarios&idBorrar=' . $item["id"] . '"><button>Borrar</button></a></td>
			</tr>';
        }
    }

}

?>