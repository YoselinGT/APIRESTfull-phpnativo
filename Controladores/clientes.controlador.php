<?php

class ControladorClientes{

    //Crear un registro

    public function create($data){

        // Validar nombre
        if(isset($data["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/',$data["nombre"])){
            $json = array (
                "status" => 404,
                "detalle" => "Erro en el nombre, solo se permiten letras"
            );
        }

        // Validar apellido
        if(isset($data["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/',$data["apellido"])){
            $json = array (
                "status" => 404,
                "detalle" => "Erro en el apellido, solo se permiten letras"
            );
        }
        
        // Validar correo
        if(isset($data["email"]) && !preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/",$data["email"])){
            $json = array (
                "status" => 404,
                "detalle" => "Error  en el correo, no esta en un formato correcto"
            );
        }

        // Validar correo no repetido
        
        $clientes = ModeloClientes::index("clientes");
        foreach($clientes as $key => $value){
            if($value["email"] == $data["email"]){
                $json = array (
                    "status" => 404,
                    "detalle" => "Error, el email ya existe en la base de datos"
                );
            }
        }
        // Generar credenciales del cliente

        $id_cliente = str_replace("$","a", crypt($data["nombre"].$data["apellido"].$data["email"],'$2a$07$normaApa10$'));
        
        $secret_key = str_replace("$","o", crypt($data["email"].$data["apellido"].$data["nombre"],'$2a$07$normaApa10$'));

        // Llevar datos al modelo
        $datos = array("nombre" => $data["nombre"],"apellido"=>$data["apellido"],"email"=>$data["email"],"id_cliente"=>$id_cliente,"llave_secreta"=>$secret_key);

        $create = ModeloClientes::create("clientes",$datos);

        if($create == "ok"){

            $json = array (
                "status" => 200,
                "detalle" => "Registro guardado, tomen sus credenciales y guardelas",
                "credenciales" =>array("id_cliente" => $id_cliente, "llave_secreta"=>$secret_key)
            );

        }

        // Repuesta del modelo

        echo json_encode($json, true);
        return;
    }

}