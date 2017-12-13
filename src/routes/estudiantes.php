<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from estudiante";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($estudiantes);
      print_r($estudiantes);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');

    $sql = "SELECT * FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre_estudiante');
    $apellidop = $request->getParam('apellido_p_estudiante');
    $apellidom = $request->getParam('apellido_m_estudiante}');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = 	"INSERT INTO estudiante (No_control, nombre_estudiante, apellido_p_estudiante, apellido_m_estudiante, semestre, carrera_clave) VALUES (:No_control, :nombre_estudiante, :apellido_p_estudiante, :apellido_m_estudiante, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',                $nocontrol);
        $stmt->bindParam(':nombre_estudiante',         $nombre);
        $stmt->bindParam(':apellido_p_estudiante',     $apellidop);
        $stmt->bindParam(':apellido_m_estudiante',     $apellidom);
        $stmt->bindParam(':semestre',                  $semestre);
        $stmt->bindParam(':carrera_clave',             $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar estudiante
$app->put('/api/estudiantes/update/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre_estudiante');
    $apellidop = $request->getParam('apellido_p_estudiante');
    $apellidom = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                No_control                 = :No_control,
                nombre_estudiante          = :nombre_estudiante,
                apellido_p_estudiante      = :apellido_p_estudiante,
                apellido_m_estudiante      = :apellido_m_estudiante,
                semestre                   = :semestre,
                carrera_clave              = :carrera_clave
            WHERE No_control    = '$nocontrol'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',             $nocontrol);
        $stmt->bindParam(':nombre_estudiante',      $nombre);
        $stmt->bindParam(':apellido_p_estudiante',  $apellidop);
        $stmt->bindParam(':apellido_m_estudiante',  $apellidom);
        $stmt->bindParam(':semestre',               $semestre);
        $stmt->bindParam(':carrera_clave',          $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/estudiantes/delete/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');

    $sql = "DELETE FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//MATERIA

// Obtener todas las carreras

$app->get('/api/carrera', function(Request $request, Response $response){
	//echo "materias";
	$sql = "select * from carrera";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($carrera);

	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// Agregar una carrera
$app->post('/api/carrera/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "INSERT INTO carrera (clave, nombre) VALUES (:clave, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',      $clave);
        $stmt->bindParam(':nombre',     $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "carrera agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar carrera
$app->put('/api/carrera/update/{clave}', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "UPDATE carrera SET
                clave    = :clave,
                nombre   = :nombre

            WHERE clave = '.$clave.'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',   $clave);
        $stmt->bindParam(':nombre',  $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "carrera actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Borrar carrera
$app->delete('/api/carrera/delete/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "DELETE FROM carrera WHERE clave_carrera = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "carrera eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



//DEPARTAMENTO

// Obtener todos los departamentos

$app->get('/api/departamento', function(Request $request, Response $response){
	//echo "departamento";
	$sql = "select * from departamento";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($departamento);

	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Agregar un departamento
$app->post('/api/departamento/add', function(Request $request, Response $response){
    $rfc_departamento = $request->getParam('rfc_departamento');
    $nombre_departamento = $request->getParam('nombre_departamento');
		$trabajador_rfc = $request->getParam('trabajador_rfc');


    $sql = "INSERT INTO departamento (rfc_departamento, nombre_departamento, trabajador_rfc) VALUES (:rfc_departamento, :nombre_departamento, :trabajador_rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_departamento',      $rfc_departamento);
        $stmt->bindParam(':nombre_departamento',         $nombre_departamento);
				$stmt->bindParam(':trabajador_rfc', $trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "departamento agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});





// Actualizar departamento
$app->put('/api/departamento/update/{ClaveDepa}', function(Request $request, Response $response){
    $rfc_departamento = $request->getParam('rfc_departamento');
    $nombre_departamento = $request->getParam('nombre_departamento');
		$trabajador_rfc=$request->getParam('trabajador_rfc');


    $sql = "UPDATE departamento SET
                rfc_departamento       = :rfc_departamento,
                nombre_departamento           = :nombre_departamento,
								trabajador_rfc   = :trabajador_rfc

            WHERE rfc_departamento = '.$rfc_departamento.'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_departamento',       $rfc_departamento);
        $stmt->bindParam(':nombre_departamento',          $nombre_departamento);
				$stmt->bindParam(':trabajador_rfc',  $trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});








// Borrar departamento
$app->delete('/api/departamento/delete/{rfc_departamento}', function(Request $request, Response $response){
    $rfc_departamento = $request->getAttribute('rfc_departamento');

    $sql = "DELETE FROM departamento WHERE rfc_departamento = '".$rfc_departamento."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




//instituto

$app->get('/api/institu', function(Request $request, Response $response){
    //echo "institu";
    $sql = "select * from instituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $institu = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
         echo json_encode($institu);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un instituto por no de clave
$app->get('/api/institu/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "SELECT * FROM instituto WHERE clave_instituto = '".$clave_instituto."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($instituto);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// Agregar un instituto
$app->post('/api/institu/add', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');


    $sql = 	"INSERT INTO instituto (clave_instituto, nombre_instituto) VALUES (:clave_instituto, :nombre_instituto)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',          $clave_instituto);
        $stmt->bindParam(':nombre_instituto',         $nombre_instituto);


        $stmt->execute();

        echo '{"notice": {"text": "instituto agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Actualizar instituto
$app->put('/api/institu/update/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');



    $sql = "UPDATE instituto SET
                clave_instituto        = :clave_instituto,
                nombre_instituto       = :nombre_instituto


            WHERE clave_instituto = '.$clave_instituto.'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',   $clave_instituto);
        $stmt->bindParam(':nombre_instituto',  $nombre_instituto);



        $stmt->execute();

        echo '{"notice": {"text": "instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar instituto
$app->delete('/api/institu/delete/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "DELETE FROM instituto WHERE clave_instituto = '".$clave_instituto."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//trabajador

//todos los trabajadores
$app->get('/api/trabajador', function(Request $request, Response $response){
    //echo "trabajador";
    $sql = "select * from trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
          echo json_encode($trabajador);
        // print_r($trabajador);
				
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un trabajador por rfc
$app->get('/api/trabajador/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "SELECT * FROM trabajador WHERE rfc_trabajador = $rfc_trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($trabajador);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un trabajador
$app->post('/api/trabajador/add', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');


    $sql = 	"INSERT INTO trabajador (rfc_trabajador, nombre_trabajador,apellido_p,apellido_m,clave_presupuestal) VALUES (:rfc_trabajador,:nombre_trabajador,:apellido_p,:apellido_m,:clave_presupuestal)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',          $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',       $nombre_trabajador);
        $stmt->bindParam(':apellido_p',              $apellido_p);
        $stmt->bindParam(':apellido_m',              $apellido_m);
        $stmt->bindParam(':clave_presupuestal',      $clave_presupuestal);


        $stmt->execute();

        echo '{"notice": {"text": "trabajador agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar trabajador
$app->put('/api/trabajador/update/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');



    $sql = "UPDATE trabajador SET
           rfc_trabajador            = :rfc_trabajador,
           nombre_trabajador         = :nombre_trabajador,
           apellido_p                = :apellido_p,
           apellido_m                = :apellido_m,
           clave_presupuestal        = :clave_presupuestal


            WHERE rfc_trabajador = '$rfc_trabajador'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',   $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',  $nombre_trabajador);
        $stmt->bindParam(':apellido_p',   $apellido_p);
        $stmt->bindParam(':apellido_m',   $apellido_m);
        $stmt->bindParam(':clave_presupuestal',   $clave_presupuestal);



        $stmt->execute();

        echo '{"notice": {"text": "trabajor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar trabajador
$app->delete('/api/trabajador/delete/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "DELETE FROM trabajador WHERE rfc_trabajador = $rfc_trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice"
					: {"text": "trabajador eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//actividades

//todas las actividades
$app->get('/api/act_complementaria', function(Request $request, Response $response){
    //echo "trabajador";
    $sql = "select * from act_complementaria";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $act_complementaria = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($act_complementaria);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener una actividad por clave
$app->get('/api/act_complementaria/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "SELECT * FROM act_complementaria WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $act_complementaria = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($act_complementaria);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar una actividad
$app->post('/api/act_complementaria/add', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_complementarias = $request->getParam('nombre_complementarias');



    $sql = 	"INSERT INTO act_complementaria (clave_act, nombre_complementarias) VALUES (:clave_act,:nombre_complementarias)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act', $clave_act);
        $stmt->bindParam(':nombre_complementarias', $nombre_complementarias);



        $stmt->execute();

        echo '{"notice": {"text": "actividad agregada"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar actividad
$app->put('/api/act_complementaria/update/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_act = $request->getParam('nombre_complementarias');




    $sql = "UPDATE act_complementaria SET
           clave_act                    = :clave_act,
           nombre_complementarias       = :nombre_complementarias




            WHERE clave_act = '$clave_act'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act',   $clave_act);
        $stmt->bindParam(':nombre_complementarias',  $nombre_complementarias);




        $stmt->execute();

        echo '{"notice": {"text": "actividad actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar actividad
$app->delete('/api/act_complementaria/delete/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "DELETE FROM act_complementaria WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "actividad eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
