<?php
$array_rutas = explode("/",$_SERVER['REQUEST_URI']);

if(isset($_GET["page"]) && is_numeric($_GET["page"])){

    $cursos = new ControladorCursos();
    $cursos->index($_GET["page"]); 

}else{
    if(count(array_filter($array_rutas)) == 0){
        $json = array (
            "detalle" => "no encontrado"
        );
        
        echo json_encode($json, true);
        return;
    }else{
    
        if(count(array_filter($array_rutas)) == 1){
            // Cuando se hace peticiones en registro
            if(array_filter($array_rutas)[1] == "registro"){
    
                if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    
                    // Capturar datos
    
                    $data= array("nombre" =>$_POST['nombre'],
                                "apellido" =>$_POST['apellido'],
                                "email" =>$_POST['email']);
    
                   $registro = new ControladorClientes();
                   $registro->create($data); 
                }else{
                    $json = array (
                        "detalle" => "no encontrado"
                    );
                    
                    echo json_encode($json, true);
                    return;
                }
    
            }
    
            // Cuando se hace peticiones en cursos
            else if(array_filter($array_rutas)[1] == "cursos"){
                if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET"){
                    $cursos = new ControladorCursos();
                    $cursos->index(null); 
                }else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    
                    // Capturar los datos
                    $data= array("titulo" =>$_POST['titulo'],
                                "descripcion" =>$_POST['descripcion'],
                                "imagen" =>$_POST['imagen'],
                                "precio" =>$_POST['precio'],
                                "instructor" =>$_POST['instructor']);
    
                    $cursos = new ControladorCursos();
                    $cursos->create($data); 
                }else{
                    $json = array (
                        "detalle" => "no encontrado"
                    );
                    
                    echo json_encode($json, true);
                    return;
                }
            }else{
                $json = array (
                    "detalle" => "no encontrado"
                );
                
                echo json_encode($json, true);
                return;
            }
    
        }else{
            // Cuando se hace peticiones desde un solo curso
    
            if(array_filter($array_rutas)[1] == "cursos" && is_numeric(array_filter($array_rutas)[2])){
    
                if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET"){
                    $cursos = new ControladorCursos();
                    $cursos->show(array_filter($array_rutas)[2]); 
                }
    
                else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "PUT"){
    
                    // Capturar datos
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
    
                    $cursos = new ControladorCursos();
                    $cursos->update(array_filter($array_rutas)[2],$datos); 
                }
                
                else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "DELETE"){
                    $cursos = new ControladorCursos();
                    $cursos->delete(array_filter($array_rutas)[2]); 
                }
                else{
                    $json = array (
                        "detalle" => "no encontrado"
                    );
                    
                    echo json_encode($json, true);
                    return;
                }
            }else{
                $json = array (
                    "detalle" => "no encontrado"
                );
                
                echo json_encode($json, true);
                return;
            }
        }
    
        
    }
    
}

