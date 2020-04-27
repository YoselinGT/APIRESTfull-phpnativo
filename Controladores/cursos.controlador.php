<?php

class ControladorCursos{

    public function index($page){

        $clientes = ModeloClientes::index("clientes");


        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

            foreach($clientes as $key => $valueC){
                if("Basic ".base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == "Basic ".base64_encode($valueC['id_cliente'].":".$valueC['llave_secreta'])){

                    if($page != null){
                        // Mostrar cursos con páginacion
                        $cantidad = 10;
                        $desde = ($page-1)*$cantidad;

                        $cursos = ModeloCursos::index("cursos","clientes",$cantidad,$desde);
                    }else{
                        //Mostrar todos los cursos
                        $cursos = ModeloCursos::index("cursos","clientes",null, null);
                    }

                    

                    if(!empty($cursos)){
                        $json = array (
                            "status"=>200,
                            "total_registros" => count($cursos),
                            "detalle" => $cursos
                        );
                        echo json_encode($json, true);
                        return;
                    }else{
                        $json = array (
                            "status"=>200,
                            "total_registros" => 0,
                            "detalle" => "Catalogo vacio"
                        );
                        echo json_encode($json, true);
                        return;
                    }
                   
                    
                   
                }else{
                    $json = array (
                        "status"=>404,
                        "detalle" => "Token no valido"
                    );
                    
                    
                }
            }
        
        }else{
            $json = array (
                "detalle" => "No autorizado para recibir los registros"
            );
        }

        echo json_encode($json, true);
        return;
    }

    public function create($datos){

        $clientes = ModeloClientes::index("clientes");


        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

            foreach($clientes as $key => $valueC){
                if("Basic ".base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == "Basic ".base64_encode($valueC['id_cliente'].":".$valueC['llave_secreta'])){

                    // Validacion de los datos
                    foreach($datos as $key => $valueD){

                        if(isset($valueD) && !preg_match('/^[(\\)\\=\\&\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/',$valueD)){
                            $json = array (
                                "status" => 404,
                                "detalle" => "Erro en el campo, ".$key
                            );

                            echo json_encode($json, true);
                            return;

                        }

                    }

                    // Titulo y descripcion no repetido
        
                    $cursos = ModeloCursos::index("cursos","clientes",null, null);
                
                    foreach($cursos as $key => $value){
                        if($value->titulo == $datos["titulo"]){
                            $json = array (
                                "status" => 404,
                                "detalle" => "Error, el titulo ya existe en la base de datos"
                            );
                            echo json_encode($json, true);
                            return;
                        }
                        if($value->descripcion == $datos["descripcion"]){
                            $json = array (
                                "status" => 404,
                                "detalle" => "Error, la descripcion ya existe en la base de datos"
                            );
                            echo json_encode($json, true);
                            return;
                        }
                    }
                    // Llevar datos al modelo

                    $datos = array("titulo"=>$datos['titulo'],
                                   "descripcion"=>$datos['descripcion'],
                                   "instructor"=>$datos['instructor'],
                                   "imagen"=>$datos['imagen'],
                                   "precio"=>$datos['precio'],
                                   "id_creador"=>$valueC['id']
                                );
                    $create = ModeloCursos::create("cursos",$datos);
                    // Recibimos la respuesta del modelo

                    if($create == "ok"){

                        $json = array (
                            "status" => 200,
                            "detalle" => "Registro guardado"
                        );
                    }
                    echo json_encode($json, true);
                    return;
                }else{
                $json = array (
                    "status"=>404,
                    "detalle" => "Token no valido"
                );
                
                
            }
        }
    
    }else{
        $json = array (
            "detalle" => "No autorizado para recibir los registros"
        );
    }

    echo json_encode($json, true);
    return;
}
            

    public function show($id){
        $clientes = ModeloClientes::index("clientes");


        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

            foreach($clientes as $key => $valueC){
                if("Basic ".base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == "Basic ".base64_encode($valueC['id_cliente'].":".$valueC['llave_secreta'])){
                    $curso = ModeloCursos::show("cursos","clientes",$id);

                    if(!empty($curso)){
                        $json = array (
                            "status"=>200,
                            "detalle" => $curso
                        );
                        echo json_encode($json, true);
                        return;
                    }else{
                        $json = array (
                            "status"=>200,
                            "total_registros" => 0,
                            "detalle" => "Catalogo vacio"
                        );
                        echo json_encode($json, true);
                        return;
                    }
                   
                    
                   
                }else{
                    $json = array (
                        "status"=>404,
                        "detalle" => "Token no valido"
                    );
                    
                    
                }
            }
        
        }else{
            $json = array (
                "detalle" => "No autorizado para recibir los registros"
            );
        }

        echo json_encode($json, true);
        return;
    }

    public function update($id,$datos){
        
        $clientes = ModeloClientes::index("clientes");


        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

            foreach($clientes as $key => $valueC){
                if("Basic ".base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == "Basic ".base64_encode($valueC['id_cliente'].":".$valueC['llave_secreta'])){

                    // Validacion de los datos
                    foreach($datos as $key => $valueD){

                        if(isset($valueD) && !preg_match('/^[(\\)\\=\\&\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/',$valueD)){
                            $json = array (
                                "status" => 404,
                                "detalle" => "Erro en el campo, ".$key
                            );

                            echo json_encode($json, true);
                            return;

                        }

                    }



                    // Validar id creador
                    
                    $curso = ModeloCursos::show("cursos","clientes",$id);
                    
                    foreach($curso as $key => $value){
                        if($value->id_creador == $valueC['id']){

                             // Llevar datos al modelo

                            $datos = array("id"=>$id,
                                            "titulo"=>$datos['titulo'],
                                            "descripcion"=>$datos['descripcion'],
                                            "instructor"=>$datos['instructor'],
                                            "imagen"=>$datos['imagen'],
                                            "precio"=>$datos['precio']
                                        );
                            $update = ModeloCursos::update("cursos",$datos);
                            // Recibimos la respuesta del modelo

                            if($update == "ok"){

                                $json = array (
                                    "status" => 200,
                                    "detalle" => "Registro ha sido actualizado"
                                );
                            }
                            echo json_encode($json, true);
                            return;
                            

                        }else{
                            $json = array (
                                "status" => 404,
                                "detalle" => "No esta autorizado para modificar este curso"
                            );

                            echo json_encode($json, true);
                            return;

                        }
                    }

                }else{
                $json = array (
                    "status"=>404,
                    "detalle" => "Token no valido"
                );
                
                
            }
        }
    
    }else{
            $json = array (
                "detalle" => "No autorizado para recibir los registros"
            );
        }

        echo json_encode($json, true);
        return;

    }

    public function delete($id){
               
        $clientes = ModeloClientes::index("clientes");


        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

            foreach($clientes as $key => $valueC){
                if("Basic ".base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == "Basic ".base64_encode($valueC['id_cliente'].":".$valueC['llave_secreta'])){

                    // Validar id creador
                    
                    $curso = ModeloCursos::show("cursos","clientes",$id);
                    
                    foreach($curso as $key => $value){
                        if($value->id_creador == $valueC['id']){

                             // Llevar datos al modelo

                            $delete = ModeloCursos::delete("cursos",$id);
                            // Recibimos la respuesta del modelo

                            if($delete == "ok"){

                                $json = array (
                                    "status" => 200,
                                    "detalle" => "Registro eliminado"
                                );
                            }
                            echo json_encode($json, true);
                            return;
                            

                        }else{
                            $json = array (
                                "status" => 404,
                                "detalle" => "No esta autorizado para modificar este curso"
                            );

                            echo json_encode($json, true);
                            return;

                        }
                    }

                }else{
                $json = array (
                    "status"=>404,
                    "detalle" => "Token no valido"
                );
                
                
            }
        }
    
    }else{
            $json = array (
                "detalle" => "No autorizado para recibir los registros"
            );
        }

        echo json_encode($json, true);
        return;

    }

}
