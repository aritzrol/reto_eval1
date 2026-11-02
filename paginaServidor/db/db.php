<?php
    class Db{
        public static function getConexion(){
            //echo 'Conectar::conexion() Abriendo conexion<br>';
            $conexion=new mysqli("localhost", "root", "", "manga_ancha");
            $conexion->query("SET NAMES 'utf8'");
            //echo 'Conectar::conexion() Devolviendo conexion<br>';
            return $conexion;
        }
    }
?>