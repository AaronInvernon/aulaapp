<?php


if (!$_SESSION["validar"]) {
	header("location:index.php?action=login");
	exit(); //usando el método exit() hacemos que nadie pueda, de ninguna forma continuar el script y alterarlo. 
}

if(($_SESSION["rol"] == 1) || ($_SESSION["rol"] == 2) ){ //si no es profesor (rol 2) o administrador (rol 1) lo lleva fuera

}else{
    header("location:index.php?action=index");
}

?>


<h1>Listado de USUARIOS</h1>

	<table border="1">
		
		<thead>
			
			<tr>
				<th>Usuario</th>				
				<th>Email</th>
				<th>Borrar</th>
			</tr>

		</thead>

		<tbody>
			<?php

				$listarUsuario = new UsuariosController();
				$listarUsuario -> listarUsuariosController();
				$listarUsuario -> borrarUsuarioController();
			?>
			

		</tbody>
	</table>

	<?php
	if (isset($_GET["action"])){
		if ($_GET["action"] == "cambio") {
			echo "Usuario borrado.";
		}
	}



?>