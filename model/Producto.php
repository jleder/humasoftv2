<?php

class C_Producto {

    //Escriba tus variables
    private $codigo;
    private $codcate;
    private $nombre;
    private $codigoprov;
    private $umedida;
    private $stkmin;
    private $stkmax;
    private $pventa;
    private $observa;
    private $fecreg;
    private $domuser;
    private $palmacen;
    private $peso;
    private $umed_com;
    private $lithec;
    private $descorto;
    private $inicial;
    private $codlis;

    public function __get($atrb) {
        return $this->$atrb;
    }

    public function __set($atrb, $val) {
        $this->$atrb = $val;
    }

    function consultas($sql) {
        $obj_conexion = new Conexion();
        return $obj_conexion->consultar($sql);
    }

    function n_Arreglo($result) {
        $lista = array();
        while ($reg = pg_fetch_array($result)) {
            array_push($lista, $reg);
        }
        return $lista;
    }

    function n_fila($result) {
        $row = pg_fetch_row($result);
        return $row;
    }

    function insertProducto() {
        $sql = "INSERT INTO alardb01(codcate, codigo, nombre, codigoprov, umedida, stkmin, stkmax, pventa, observa, fecreg, coduse, palmacen, peso, umed_com, lithec, descorto) values ('$this->codcate', '$this->codigo',  '$this->nombre', '$this->codigoprov', '$this->umedida', '$this->stkmin', '$this->stkmax', '$this->pventa', '$this->observa', now(), '$this->domuser', '$this->palmacen', '$this->peso', '$this->umed_com', '$this->lithec', '$this->descorto');";
        $result = $this->consultas($sql);
        return $result;
    }

    function insertarListaPrecios($codlis) {
        $sql = "INSERT INTO lista_precio2(codlis, codigoprod, precio, fecreg, coduse) values ('$codlis', '$this->codigo', '$this->pventa', now(), '$this->domuser' );";
        $result = $this->consultas($sql);
        return $result;
    }

    function insert_filestock($fecha, $url) {
        $sql = "INSERT INTO filestock(fecha, url, coduse) values ('$fecha', '$url', '$this->domuser');";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete_filestock($codigo) {
        $sql = "DELETE FROM filestock WHERE codigo = '$codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function unlink_filestock($url) {
        $ruta = '../site/archivos/filestock/';
        $dir = $ruta . $url;
        if (file_exists($dir)) {
            unlink($dir);
        }
    }

    function list_filestock() {
        $sql = "SELECT codigo, fecha, url FROM filestock order by fecreg desc limit 30;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function updateProducto() {

        $sql = "UPDATE alardb01 SET "
                . "codcate = '$this->codcate', "
                . "nombre = '$this->nombre', "
                . "codigoprov = '$this->codigoprov', "
                . "umedida = '$this->umedida', "
                . "stkmin = '$this->stkmin', "
                . "stkmax = '$this->stkmax', "
                . "pventa = '$this->pventa', "
                . "observa = '$this->observa', "
                . "fecmod = now(), "
                . "usemod = '$this->domuser', "
                . "palmacen = '$this->palmacen', "
                . "peso = '$this->peso', "
                . "umed_com = '$this->umed_com', "
                . "lithec = '$this->lithec', "
                . "descorto = '$this->descorto' "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function updateListaPrecios() {

        $sql = "UPDATE lista_precio2 SET "
                . "precio = '$this->pventa', "
                . "usemod = '$this->domuser', "
                . "fecmod = now() "
                . "WHERE codlis = '$this->codlis' and codigoprod = '$this->codigo'; ";
        $result = $this->consultas($sql);
        return $result;
    }

    function delete() {

        $sql = "DELETE FROM alardb01 WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getProductoByCod() {
        $sql = "SELECT codigo, codcate, nombre, codigoprov, umedida, stkmin, stkmax, pventa, observa, palmacen, peso, umed_com, lithec, descorto, desele
                FROM alardb01 as p JOIN altbdb01 as c ON c.codele = p.codcate
                WHERE c.codtab = 'CF' AND p.codigo = '$this->codigo'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getProdxPrecioByCod() {
        $sql = "SELECT codigo, codcate, nombre, codigoprov, umedida, stkmin, stkmax, pventa, observa, palmacen, peso, umed_com, lithec, descorto, codlis, precio, desele, p.orden
                FROM alardb01 as p JOIN lista_precio2 as l ON p.codigo = l.codigoprod 
                JOIN altbdb01 as c ON c.codele = p.codcate
                WHERE p.codigo = '$this->codigo' AND c.codtab= 'CF' ORDER BY codcate, codigo, codlis;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getProductosAll() {
        $sql = "SELECT codigo, codcate, nombre, codigoprov, umedida, stkmin, stkmax, pventa, observa, palmacen, peso, umed_com, lithec, descorto, activo FROM alardb01 WHERE activo='SI' ORDER BY orden asc, codcate, codigo";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //verificar esta funcion y eliminarla o cambiarla por getListaPrecioProductosAll2();
    function getListaPrecioProductosAll() {
        $sql = "SELECT codcate, desele, codigoprod, nombre, codlis, precio
                FROM lista_precio2 as l 
                JOIN alardb01 as p ON p.codigo = l.codigoprod
                JOIN altbdb01 as c ON c.codele = p.codcate
                WHERE p.activo = 'SI'
                ORDER BY codcate, codigoprod, codlis";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getListaPrecioProductosAll2() {
        $sql = "SELECT codcate, desele, codigoprod, nombre, codlis, precio, c.valele
                FROM lista_precio2 as l 
                JOIN alardb01 as p ON p.codigo = l.codigoprod
                JOIN altbdb01 as c ON c.codele = p.codcate
                where p.activo = 'SI'
                ORDER BY c.valele, codigoprod, codlis";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getListaPrecioDscto() {
        $sql = "SELECT codlis, codigoprod, nombre, precio, c.valele, orden
                FROM lista_precio2 as l 
                JOIN alardb01 as p ON p.codigo = l.codigoprod
                JOIN altbdb01 as c ON c.codele = p.codcate
                where inicial2 <> '' and codlis IN ('01', '60', '61', '62')
                ORDER BY p.orden asc, codlis";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPrecioE($codprod) {
        $sql = "SELECT codlis, codigoprod, nombre, precio, c.valele, orden
                FROM lista_precio2 as l 
                JOIN alardb01 as p ON p.codigo = l.codigoprod
                JOIN altbdb01 as c ON c.codele = p.codcate
                where l.codlis = '05' and codigoprod = '$codprod';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }
    
    function getPrecioA($codprod) {
        $sql = "SELECT codlis, codigoprod, nombre, precio, c.valele, orden
                FROM lista_precio2 as l 
                JOIN alardb01 as p ON p.codigo = l.codigoprod
                JOIN altbdb01 as c ON c.codele = p.codcate
                where l.codlis = '01' and codigoprod = '$codprod';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getcategoria($codtab) {
        $sql = "select codtab, codele, desele, alias, valele, texto from altbdb01 where codtab = '$codtab'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function llenartabla_lista_precio2() {
        $sql = "SELECT codigo, pventa FROM alardb01";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        foreach ($lista as $productos) {
            $listaprecios = array('01', '02', '03', '04', '05');

            $this->__set('codigo', $productos['codigo']);
            $this->__set('pventa', $productos['pventa']);
            $this->__set('domuser', $_SESSION['usuario']);

            foreach ($listaprecios as $codlis) {
                if ($codlis <> '01') {
                    $this->__set('pventa', trim('0.00'));
                }
                $this->insertarListaPrecios($codlis);
            }
        }
    }

    function llenartabla_preciocondscto() {
        $sql = "SELECT codigo, pventa FROM alardb01";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        foreach ($lista as $productos) {
            $listaprecios = array('60', '61', '62');

            $this->__set('codigo', $productos['codigo']);
            $this->__set('pventa', $productos['pventa']);
            $this->__set('domuser', $_SESSION['usuario']);

            foreach ($listaprecios as $codlis) {
                $this->__set('pventa', trim('0.00'));
                $this->insertarListaPrecios($codlis);
            }
        }
    }

    function getProductoByNut() {
        $sql = "SELECT codigo, codcate, nombre, codigoprov, umedida, stkmin, stkmax, pventa, observa, palmacen, peso, umed_com, lithec, descorto, codlis, precio, desele, p.orden
                FROM alardb01 as p JOIN lista_precio2 as l ON p.codigo = l.codigoprod 
                JOIN altbdb01 as c ON c.codele = p.codcate
                WHERE inicial2 = '$this->inicial' AND c.codtab= 'CF' ORDER BY codcate, codigo, codlis;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function addArrayUnidades($arreglo, $codnut, $unidad, $orden, $factor) {
        $indice = array_search(trim($codnut), array_column($arreglo, trim('codnut')), false);
        if (strlen($indice) == '') {
            array_push($arreglo, array('codnut' => $codnut, 'unidad' => trim($unidad), 'orden' => $orden, 'factor' => $factor));
        } else {
            $arreglo[$indice]['unidad'] = $unidad;
            $arreglo[$indice]['factor'] = $factor;
        }
        return $arreglo;
    }

    function calcularPrecioAMBT($descuento, $preciorestado, $totalCongelado) {
        $dcto = (1 - ($descuento / 100));
        $precioAMBT = ($preciorestado * $dcto) + $totalCongelado;
        return $precioAMBT;
    }

    function crearDespacho($ha, $arraycarrito) {
        $carritodesp = array();
        foreach ($arraycarrito as $carrito) {
//si el cod producto ya existe, aumentamos la cantidad.        
            $codprod = $carrito['codprod'];
            $litros = $carrito["cantidad"];
            $factorb = $carrito["factorb"];
            $litroxdist = ($litros / $factorb) * $ha;
            $bidon = ceil($litroxdist); //aqui redondea el bidon
            $litrosxbidon = $factorb * $bidon;
            $cantidad1 = $bidon;
            $cantidad2 = $litrosxbidon;
            $umedida1 = 'BD';
            $umedida2 = 'LT';
            $precio1 = $carrito['precio'];
            $precio2 = $carrito['preciodcto'];
            $ordendesp = $carrito['ordenprod'];
            $preciototal = $precio2 * $cantidad2;
            $indice = array_search(trim($codprod), array_column($carritodesp, trim('codprod')), false);
            if (strlen($indice) == '') {
                array_push($carritodesp, array('ordenprod' => $carrito['ordenprod'],
                    'codprod' => trim($carrito['codprod']),
                    'nomprod' => $carrito['nomprod'],
                    'litros' => $litros,
                    'cantidad1' => $cantidad1,
                    'umedida1' => $umedida1,
                    'cantidad2' => $cantidad2,
                    'umedida2' => $umedida2,
                    'precio1' => $precio1,
                    'precio2' => $precio2,
                    'preciototal' => $preciototal,
                    'factorb' => $factorb,
                    'ordendesp' => $ordendesp));
            } else {
                $litros_anterior = $carritodesp[$indice]['litros'];
                $litros_total = $litros + $litros_anterior;
                $litroxdist = ($litros_total / $factorb) * $ha;
                $bidon = ceil($litroxdist); //aqui redondea el bidon
                $litrosxbidon = $factorb * $bidon;
                $carritodesp[$indice]['cantidad1'] = $bidon;
                $carritodesp[$indice]['cantidad2'] = $litrosxbidon;
            }
        }
        return $carritodesp;
    }
    
    function getFormaPago(){
        $sql = "select codtab, codele, desele, valele from altbdb01 where codtab = 'CP' and codele <> '' order by desele";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function calcularFactorAprobacion($precioAMBT, $precioTotalE) {
        $x = ($precioAMBT - $precioTotalE);
        if ($precioTotalE > 0) {
            $fag = ($x / $precioTotalE) * 100; //Factor Aprobacion Gerencial
        } else {
            $fag = 0;
        }
        $fau = ($fag - 25); //Factor Aprobacion Usuario    
        return $fau;
    }

    function calcularPrecioSaldo($precioAMBT, $pcc, $pca) {

        $presaldo = 0;
        if ($pcc > 0) {
            $presaldo = ($pcc - $precioAMBT);
        } else {
            if ($pca > 0) {
                $presaldo = ($pca - $precioAMBT);
            }
        }
        return $presaldo;
    }

    function removeItemArray($indice, $array) {
        unset($array[$indice]);
        $array = array_values($array);
        return $array;
    }
    
     function getProductoMasVendidos(){
        $sql = "select nomprod, sum(cantidad) as cantidad, sum(precio) as precio from peddb02 group by nomprod order by cantidad desc limit 5";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
