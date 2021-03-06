﻿<?php

class Conexion {

    var $BaseDatos;
    var $Servidor;
    var $Usuario;
    var $Clave;
    var $Puerto;
    /* identificador de conexión y consulta */
    var $Conexion_ID;
    var $Consulta_ID;

    /* número de error y texto error */
    var $Errno = 0;
    var $Error = "";

    /*
      function Conexion() {

      $this->BaseDatos = "BIOTECH";
      $this->Servidor = "localhost";
      $this->Usuario = "postgres";
      $this->Clave = '';
      $this->Puerto = 5432;
      }
     */

    function conectar() {
        
        $user = 'postgres';
        $passwd = '';
        $db = 'BIOTECH';
        $port = 5432;
        $host = 'localhost';
        $strCnx = "host=$host port=$port dbname=$db user=$user password=$passwd";

        $cnx = pg_connect($strCnx) or die("Error de conexion. " . pg_last_error());
        return $cnx;
    }

    function consultar($sql) {
        $conexion = $this->conectar();
        return pg_query($conexion, $sql);
    }

function transformDDMMAAtoAAMMDD($fecha) {
        $getfecha = explode('/', $fecha);
        $dia = $getfecha[0];
        $mes = $getfecha[1];
        $ano = $getfecha[2];
        return $ano . '/' . $mes . '/' . $dia;
    }

}

?>