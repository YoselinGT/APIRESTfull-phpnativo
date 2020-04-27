<?php

require_once "conexion.php";

class ModeloCursos{

    // Mostrar todos los cursos

    static public function index($tabla1,$tabla2, $cantidad, $desde){

        // $stmt = Conexion::conectar()->prepare("Select * from ".$tabla);

        if($cantidad != null){

            $stmt = Conexion::conectar()->prepare("Select $tabla1.id, $tabla1.titulo, $tabla1.descripcion, $tabla1.instructor, $tabla1.imagen, $tabla1.precio, $tabla1.id_creador, $tabla2.primer_nombre, $tabla2.primer_apellido from $tabla1 INNER JOIN $tabla2 ON $tabla1.id_creador=$tabla2.id LIMIT $desde, $cantidad");
            
        }else{

        $stmt = Conexion::conectar()->prepare("Select $tabla1.id, $tabla1.titulo, $tabla1.descripcion, $tabla1.instructor, $tabla1.imagen, $tabla1.precio, $tabla1.id_creador, $tabla2.primer_nombre, $tabla2.primer_apellido from $tabla1 INNER JOIN $tabla2 ON $tabla1.id_creador=$tabla2.id");
    
        }   
    
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

        $stmt->close();

        $stmt -=null;

    }

       // crear un registro

       static public function create($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO  $tabla (titulo, descripcion, instructor, imagen, precio, id_creador) VALUES (:titulo, :descripcion, :instructor, :imagen, :precio, :id_creador)");

        // return $datos["llave_secreta"];

        $stmt->bindParam(":titulo",$datos["titulo"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion",$datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":instructor",$datos["instructor"], PDO::PARAM_STR);
        $stmt->bindParam(":imagen",$datos["imagen"], PDO::PARAM_STR);
        $stmt->bindParam(":precio",$datos["precio"], PDO::PARAM_STR);
        $stmt->bindParam(":id_creador",$datos["id_creador"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }

        return $stmt->fetchAll();

        $stmt->close();

        $stmt -=null;

    }

    // Mostrar todos los cursos

    static public function show($tabla1,$tabla2,$id){

        // $stmt = Conexion::conectar()->prepare("Select * from ".$tabla ." Where id=:id");

        $stmt = Conexion::conectar()->prepare("Select $tabla1.id, $tabla1.titulo, $tabla1.descripcion, $tabla1.instructor, $tabla1.imagen, $tabla1.precio, $tabla1.id_creador, $tabla2.primer_nombre, $tabla2.primer_apellido from $tabla1 INNER JOIN $tabla2 ON $tabla1.id_creador=$tabla2.id Where $tabla1.id=:id");

        $stmt->bindParam(":id",$id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

        $stmt->close();

        $stmt -=null;

    }


    // actualizacion un registro

    static public function update($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET titulo = :titulo, descripcion = :descripcion, instructor = :instructor, imagen = :imagen, precio = :precio WHERE id = :id");

        // return $datos["llave_secreta"];
        $stmt->bindParam(":id",$datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":titulo",$datos["titulo"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion",$datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":instructor",$datos["instructor"], PDO::PARAM_STR);
        $stmt->bindParam(":imagen",$datos["imagen"], PDO::PARAM_STR);
        $stmt->bindParam(":precio",$datos["precio"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }

        return $stmt->fetchAll();

        $stmt->close();

        $stmt -=null;

    }

        // actualizacion un registro

    static public function delete($tabla,$id){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    
        $stmt->bindParam(":id",$id, PDO::PARAM_INT);
    
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