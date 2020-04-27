<?php

require_once "conexion.php";

class ModeloClientes{

    // Mostrar todos los cursos

    static public function index($tabla){

        $stmt = Conexion::conectar()->prepare("Select * from ".$tabla);

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();

        $stmt -=null;

    }

    // crear un registro

    static public function create($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO  $tabla (primer_nombre, primer_apellido, email, id_cliente, llave_secreta ) VALUES (:primer_nombre, :primer_apellido, :email, :id_cliente, :llave_secreta)");

        // return $datos["llave_secreta"];

        $stmt->bindParam(":primer_nombre",$datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":primer_apellido",$datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":email",$datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente",$datos["id_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":llave_secreta",$datos["llave_secreta"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }

        return $stmt->fetchAll();

        $stmt->close();

        $stmt -=null;

    }

}