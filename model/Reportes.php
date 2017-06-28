<?php

class C_Reportes {

    //Escriba tus variables
    private $codrep;
    private $codcliente;
    private $nomcliente;
    private $codfundo;
    private $nomfundo;
    private $codlote; // Esto es un codlote estandar, tanto para huma como para testigo.
    private $codlotehuma;
    private $codlotetestigo;
    private $codcontacto;
    private $contacto;
    private $celcontacto;
    private $carcontacto;
    private $fechavisita;
    private $horaingreso;
    private $horasalida;
    private $fechaproxvis;
    private $horaproxvis;
    private $propositovis;
    private $rubrica;
    private $atendido;
    private $tipo;
    private $nota;
    private $coduse;
    private $asesor;
    private $usemod;
    private $fecreg;
    private $fecmod;
    private $humarpta;
    private $testrpta;
    private $prueba;
    private $localvisita;
    private $localproxvis;
    private $zona;
    private $cultivo;
    private $obs;
    //variables para correo
    private $nombre;
    private $de;
    private $para;
    private $asunto;
    private $msj;
    private $imagenes;
    private $proximavis;

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

    ///////////////////////////Reportes SEARCH DESDE 
    //Busqueda: Mes y Año
    function search_ma00($mes, $ano) {
        $sql = "select r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Busqueda: Mes, Año y Cliente
    function search_ma01($mes, $ano) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND r.codcliente = '$this->codcliente' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Busqueda: Mes, Año y Cliente
    function search_ma10($mes, $ano) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND r.coduse = '$this->coduse' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Busqueda: Mes, Año y Cliente
    function search_ma11($mes, $ano) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND r.coduse = '$this->coduse' AND r.codcliente = '$this->codcliente' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function search_asesor() {
        $sql = "select r.codrep, c.nombre, trim(r.encargado), r.fechavisita, r.nomuse, r.visto, atendido, imagen, r.fecreg
        FROM rpvcdb01 as r JOIN vscldb01 as c ON r.codcli = c.codigo 
        WHERE r.coduse = '$this->coduse' 
        ORDER BY r.horasalidause desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function search_dh00($desde, $hasta) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function search_dh01($desde, $hasta) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.codcliente = '$this->codcliente' AND r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";

        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function search_dh10($desde, $hasta) {

        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.coduse = '$this->coduse' AND r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function search_dh11($desde, $hasta) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.codcliente = '$this->codcliente' AND r.coduse = '$this->coduse' AND r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    ////////////////////////FIN SEARCH
    ////////////////////////FIN SEARCH
//    SEARCH DE REP COMERCIAL

    function repcomercial_search_ma00($mes, $ano) {
        $sql = "select r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Busqueda: Mes, Año y Cliente
    function repcomercial_search_ma01($mes, $ano) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND r.codcliente = '$this->codcliente' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Busqueda: Mes, Año y Asesor
    function repcomercial_search_ma10($mes, $ano) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND r.coduse = '$this->coduse' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Busqueda: Mes, Año, Asesor y Cliente
    function repcomercial_search_ma11($mes, $ano) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where extract(month from r.fechavisita) = '$mes' AND extract(year from r.fechavisita) = '$ano' AND r.coduse = '$this->coduse' AND r.codcliente = '$this->codcliente' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function repcomercial_search_dh00($desde, $hasta) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function repcomercial_search_dh01($desde, $hasta) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.codcliente = '$this->codcliente' AND r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function repcomercial_search_dh10($desde, $hasta) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.coduse = '$this->coduse' AND r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function repcomercial_search_dh11($desde, $hasta) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.codcliente = '$this->codcliente' AND r.coduse = '$this->coduse' AND r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    

    //FIN DE SEARCH DREP COMERCIAL

    function listarCultivos() {
        $sql = "SELECT codtab, codele, desele from altbdb01 where codtab = 'TC' and codele>= '01' order by desele";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function listarEtapaFenologica() {
        $sql = "SELECT codtab, codele, desele from altbdb01 where codtab = 'EF' and codele>= '01' order by desele";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function generarVariedades($name, $class) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '">                                                                               
                        <option value="Variedades de VID">..::VARIEDADES DE VID</option>
                        <option value="Red Globe">Red Globe</option>
                        <option value="Thompson seedless">Thompson seedless</option>
                        <option value="Superior">Superior</option>
                        <option value="Crimson">Crimson</option>
                        <option value="Flame">Flame</option>
                        <option value="Quebranta">Quebranta</option>
                        <option value="Italia">Italia</option>
                        <option value="Torontel">Torontel</option>
                        <option value="Moscatel">Moscatel</option>
                        <option value="Borgoña">Borgoña</option>
                        <option value="Cavernete Sanción">Cavernete Sanción</option>
                        <option value="Correción Sauvigon">Correción Sauvigon</option>
                        <option value="Tanat">Tanat</option>
                        <option value="Sirha">Sirha</option>
                        <option value="Petit Manseg">Petit Manseg</option>
                        <option value="Petit Verdod">Petit Verdod</option>
                        <option value="Arra 15">Arra 15</option>
                        <option value="Sweet Celebration">Sweet Celebration</option>
                        <option value="Sweet Juvile">Sweet Juvile</option>
                        <option value="Sugar Crisp">Sugar Crisp</option>
                        <option value="Early Sea Son">Early Sea Son</option>
                        <option value="Cotton Candy">Cotton Candy</option>
                        <option value="Jack Salute">Jack Salute</option>
                        <option value="Early Sweet">Early Sweet</option>
                        <option value="Sweet Globe">Sweet Globe</option>
                        <option value="Variedades de Arandano">..::VARIEDADES DE ARANDANO</option>
                        <option value="Biloxy">Biloxy</option>
                        <option value="Esmeralda">Esmeralda</option>
                        <option value="Corección Emeral">Corección Emeral</option>
                        <option value="Misty">Misty</option>
                        <option value="Legasy">Legasy</option>
                        <option value="Duque">Duque</option>
                        <option value="Variedades de Mandarina">..::VARIEDADES DE MANDARINA</option>
                        <option value="Murcott">Murcott</option>
                        <option value="Clamentina">Clamentina</option>
                        <option value="Variedades de Palto">..::VARIEDADES DE PALTO</option>
                        <option value="Hass">Hass</option>
                        <option value="Fuerte">Fuerte</option>
                        <option value="Maluma Hass">Maluma Hass</option>
                        <option value="Sutano">Sutano</option>
                        <option value="Variedades de Banana">..::VARIEDADES DE BANANA</option>
                        <option value="Williams">Williams</option>
                        <option value="Gran Enano">Gran Enano</option>                        
                        <option value="Variedades de Capsicums">..::VARIEDADES DE CAPSICUMS</option>
                        <option value="Paprika ">Paprika </option>
                        <option value="Pimiento Morron">Pimiento Morron</option>
                        <option value="Pimiento Piquillo">Pimiento Piquillo</option>
                        <option value="Jalapenio">Jalapenio</option>
                        <option value="Variedades de Cacao">..:VARIEDADES DE CACAO</option>
                        <option value="CCN 51">CCN 51</option>
                        <option value="TSH 565">TSH 565</option>
                        <option value="ICS 1">ICS 1</option>
                        <option value="ICS 39">ICS 39</option>
                        <option value="ICS 95">ICS 95</option>
                        <option value="IMC 67">IMC 67</option>
                        <option value="Huasare">Huasare</option>
                        <option value="Porcelana">Porcelana</option>
                        <option value="OTRO">OTRO</option>
                    </select>';
        return $select;
    }

    function generarVariedades2($name, $class, $onchange, $onblur, $onclick) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '" onchange="' . $onchange . '" onblur="' . $onblur . '" onclick="' . $onclick . '" >
                        <option value="Variedades de VID">..::VARIEDADES DE VID</option>
                        <option value="Red Globe">Red Globe</option>
                        <option value="Thompson seedless">Thompson seedless</option>
                        <option value="Superior">Superior</option>
                        <option value="Crimson">Crimson</option>
                        <option value="Flame">Flame</option>
                        <option value="Quebranta">Quebranta</option>
                        <option value="Italia">Italia</option>
                        <option value="Torontel">Torontel</option>
                        <option value="Moscatel">Moscatel</option>
                        <option value="Borgoña">Borgoña</option>
                        <option value="Cavernete Sanción">Cavernete Sanción</option>
                        <option value="Correción Sauvigon">Correción Sauvigon</option>
                        <option value="Tanat">Tanat</option>
                        <option value="Sirha">Sirha</option>
                        <option value="Petit Manseg">Petit Manseg</option>
                        <option value="Petit Verdod">Petit Verdod</option>
                        <option value="Arra 15">Arra 15</option>
                        <option value="Sweet Celebration">Sweet Celebration</option>
                        <option value="Sweet Juvile">Sweet Juvile</option>
                        <option value="Sugar Crisp">Sugar Crisp</option>
                        <option value="Early Sea Son">Early Sea Son</option>
                        <option value="Cotton Candy">Cotton Candy</option>
                        <option value="Jack Salute">Jack Salute</option>
                        <option value="Early Sweet">Early Sweet</option>
                        <option value="Sweet Globe">Sweet Globe</option>
                        <option value="Variedades de Arandano">..::VARIEDADES DE ARANDANO</option>
                        <option value="Biloxy">Biloxy</option>
                        <option value="Esmeralda">Esmeralda</option>
                        <option value="Corección Emeral">Corección Emeral</option>
                        <option value="Misty">Misty</option>
                        <option value="Legasy">Legasy</option>
                        <option value="Duque">Duque</option>
                        <option value="Variedades de Mandarina">..::VARIEDADES DE MANDARINA</option>
                        <option value="Murcott">Murcott</option>
                        <option value="Clamentina">Clamentina</option>
                        <option value="Variedades de Palto">..::VARIEDADES DE PALTO</option>
                        <option value="Hass">Hass</option>
                        <option value="Fuerte">Fuerte</option>
                        <option value="Maluma Hass">Maluma Hass</option>
                        <option value="Sutano">Sutano</option>
                        <option value="Variedades de Banana">..::VARIEDADES DE BANANA</option>
                        <option value="Williams">Williams</option>
                        <option value="Gran Enano">Gran Enano</option>                        
                        <option value="Variedades de Capsicums">..::VARIEDADES DE CAPSICUMS</option>
                        <option value="Paprika ">Paprika </option>
                        <option value="Pimiento Morron">Pimiento Morron</option>
                        <option value="Pimiento Piquillo">Pimiento Piquillo</option>
                        <option value="Jalapenio">Jalapenio</option>
                        <option value="Variedades de Cacao">..:VARIEDADES DE CACAO</option>
                        <option value="CCN 51">CCN 51</option>
                        <option value="TSH 565">TSH 565</option>
                        <option value="ICS 1">ICS 1</option>
                        <option value="ICS 39">ICS 39</option>
                        <option value="ICS 95">ICS 95</option>
                        <option value="IMC 67">IMC 67</option>
                        <option value="Huasare">Huasare</option>
                        <option value="Porcelana">Porcelana</option>
                        <option value="Desconocida">Desconocida</option>
                        <option value="OTRO">..::Nueva Variedad</option>
                    </select>';
        return $select;
    }

    function generarPatrones($name, $class) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '">                                                                                                                               
                        <option value="PATRONES DE VID">PATRONES DE VID</option>
                        <option value="MGT 10114">MGT 10114</option>
                        <option value="Freedom">Freedom</option>
                        <option value="Harmony">Harmony</option>
                        <option value="Salt Creack">Salt Creack</option>
                        <option value="Dog Rigen">Dog Rigen</option>
                        <option value="Rigen">Rigen</option>
                        <option value="R99">R99</option>
                        <option value="R101">R101</option>
                        <option value="Poulsen 1010">Poulsen 1010</option>
                        <option value="5C">5C</option>
                        <option value="5BB">5BB</option>
                        <option value="PATRONES DE CITRICOS">PATRONES DE CITRICOS</option>
                        <option value="Limon Rugoso">Limon Rugoso</option>
                        <option value="Cleopatra">Cleopatra</option>
                        <option value="Limon Bulcameriano">Limon Bulcameriano</option>
                        <option value="Sin Patron">Sin Patron</option>                        
                        <option value="OTRO">..::Escribir Patron</option>
                    </select>';

        return $select;
    }

    function generarPatrones2($name, $class, $onchange, $onblur, $onclick) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '" onchange="' . $onchange . '" onblur="' . $onblur . '" onclick="' . $onclick . '" >                        
                        <option value="PATRONES DE VID">PATRONES DE VID</option>
                        <option value="MGT 10114">MGT 10114</option>
                        <option value="Freedom">Freedom</option>
                        <option value="Harmony">Harmony</option>
                        <option value="Salt Creack">Salt Creack</option>
                        <option value="Dog Rigen">Dog Rigen</option>
                        <option value="Rigen">Rigen</option>
                        <option value="R99">R99</option>
                        <option value="R101">R101</option>
                        <option value="Poulsen 1010">Poulsen 1010</option>
                        <option value="5C">5C</option>
                        <option value="5BB">5BB</option>
                        <option value="PATRONES DE CITRICOS">PATRONES DE CITRICOS</option>
                        <option value="Limon Rugoso">Limon Rugoso</option>
                        <option value="Cleopatra">Cleopatra</option>
                        <option value="Limon Bulcameriano">Limon Bulcameriano</option>
                        <option value="Sin Patron">Sin Patron</option>
                        <option value="Desconocido">Desconocido</option>                        
                        <option value="OTRO">..::Nuevo Patron</option>
                    </select>';

        return $select;
    }

    function generarTipoSuelo($name, $class) {
        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '">
                        <option value="Arenoso">Arenoso</option>
                        <option value="Arcilloso">Arcilloso</option>
                        <option value="Limoso">Limoso</option>
                        <option value="Franco Arenoso">Franco Arenoso</option>
                        <option value="Franco Arcilloso">Franco Arcilloso</option>
                        <option value="Franco Limoso">Franco Limoso</option>
                      </select>';
        return $select;
    }

    function generarTipoRiego($name, $class) {
        $select = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '">                                                                               
                        <option value="GOTEO">GOTEO</option>
                        <option value="PULSO">PULSO</option>
                        <option value="ASPERSION">ASPERSION</option>
                        <option value="DRENCH">DRENCH</option>
                        <option value="SURCOS">SURCOS</option>                        
                        <option value="OTRO">OTRO</option>
                    </select>';
        return $select;
    }

    function regRepTecnico() {
        $sql = "INSERT INTO intrareportes(codrep, codcliente, codfundo, codlotehuma, codlotetestigo, "
                . "contacto, fechavisita, horaingreso, horasalida, horaproxvis, propositovis, rubrica, "
                . "atendido, tipo, nota, coduse, fechaproxvis) "
                . "values ('$this->codrep', '$this->codcliente', $this->codfundo, $this->codlotehuma,"
                . " $this->codlotetestigo, '$this->contacto', '$this->fechavisita', $this->horaingreso, "
                . "$this->horasalida, $this->horaproxvis, '$this->propositovis', '$this->rubrica', "
                . "'$this->atendido', '$this->tipo', '$this->nota', '$this->coduse', $this->fechaproxvis);";
        $result = $this->consultas($sql);

        //REGISTRANDO LAS RESPUESTAS DEL CUESTIONARIO HUMAGRO
        if ($result) {
            $nropreg = array('01', '02', '03');
            //Llenando Respuestas Humagro
            $huma = $this->humarpta;
            $size = count($huma);
            for ($i = 0; $i < $size; $i++) {
                $sqlhuma = "INSERT INTO rpvcdb02 (codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse, fecreg) 
                    VALUES('$this->codrep', 'RP', '$nropreg[$i]', TRUE, FALSE, '$huma[$i]', '$this->coduse', now())";
                $this->consultas($sqlhuma);
            }

            //Llenando Respuestas Testigos
            $test = $this->testrpta;
            $sizet = count($test);
            for ($j = 0; $j < $sizet; $j++) {
                $sqltest = "INSERT INTO rpvcdb02 (codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse, fecreg) 
                    VALUES('$this->codrep', 'RP', '$nropreg[$j]', FALSE, TRUE, '$test[$j]', '$this->coduse', now())";
                $this->consultas($sqltest);
            }
        }
        return $result;
    }

    function reg_rpvcdb02() {
        $nropreg = array('01', '02', '03');
        //Llenando Respuestas Humagro
        $huma = $this->humarpta;
        $size = count($huma);
        for ($i = 0; $i < $size; $i++) {
            $sql = "INSERT INTO rpvcdb02 (codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse, fecreg) 
                    VALUES('$this->codrep', 'RP', '$nropreg[$i]', TRUE, FALSE, '$huma[$i]', '$this->coduse', now())";
            $result = $this->consultas($sql);
        }
        return $result;
    }

    function regRepTecnicoMultiple01() {
        $sql = "INSERT INTO intrareportes(codrep, codcliente, codfundo, codlotehuma, codlotetestigo, "
                . "contacto, fechavisita, horaingreso, horasalida, horaproxvis, propositovis, rubrica, "
                . "atendido, tipo, nota, coduse, fechaproxvis) "
                . "values ('$this->codrep', '$this->codcliente', $this->codfundo, $this->codlotehuma, $this->codlotetestigo, "
                . "'$this->contacto', '$this->fechavisita', $this->horaingreso, "
                . "$this->horasalida, $this->horaproxvis, '$this->propositovis', '$this->rubrica', "
                . "'$this->atendido', '$this->tipo', '$this->nota', '$this->coduse', $this->fechaproxvis);";
        $result = $this->consultas($sql);
        if ($result) {
            $nropreg = array('01', '02', '03');
            //Llenando Respuestas Humagro
            $huma = $this->humarpta;
            $size = count($huma);
            for ($i = 0; $i < $size; $i++) {
                $sqlhuma = "INSERT INTO rpvcdb02 (codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse, fecreg) 
                    VALUES('$this->codrep', 'RP', '$nropreg[$i]', TRUE, FALSE, '$huma[$i]', '$this->coduse', now())";
                $this->consultas($sqlhuma);
            }

            //Llenando Respuestas Testigos
            $test = $this->testrpta;
            $sizet = count($test);
            for ($j = 0; $j < $sizet; $j++) {
                $sqltest = "INSERT INTO rpvcdb02 (codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse, fecreg) 
                    VALUES('$this->codrep', 'RP', '$nropreg[$j]', FALSE, TRUE, '$test[$j]', '$this->coduse', now())";
                $this->consultas($sqltest);
            }

            if ($this->atendido == 3 || $this->atendido == 4) {
                $sqltest = "INSERT INTO rpvcdb02 (codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse, fecreg) 
                    VALUES('$this->codrep', 'RP', '01', TRUE, FALSE, '$this->obs', '$this->coduse', now())";
                $this->consultas($sqltest);
            }

            //Agendar Proxima Visita
            if ($this->fechaproxvis != 'NULL') {
                $sqla = "INSERT INTO intraagenda(asunto, fechainicio, horainicio, donde, estado, coduse, fecreg) values ('$this->propositovis', $this->fechaproxvis, $this->horaproxvis, '$this->nomcliente', 'PENDIENTE', '$this->coduse', now());";
                $this->consultas($sqla);
            }

//            //Enviar e-mail
//            if ($this->prueba == 'SI') {
//                $this->sendmailRegTecnico_Prueba();
//            } else {
//                $this->sendmailRegTecnico();
//            }
        }
        return $result;
    }

    function regRepComercialMultiple01() {
        $mensaje = '';
        $sql = "INSERT INTO intrareportes(codrep, codcliente, codfundo, "
                . "contacto, fechavisita, horaingreso, horasalida, rubrica, "
                . "atendido, tipo, coduse, localvisita, localproxvis, fechaproxvis, horaproxvis, propositovis, zona, cultivo) "
                . "values ('$this->codrep', '$this->codcliente', $this->codfundo, "
                . "'$this->contacto', '$this->fechavisita', $this->horaingreso, "
                . "$this->horasalida, '$this->rubrica', "
                . "'$this->atendido', '$this->tipo', '$this->coduse', '$this->localvisita', '$this->localproxvis', $this->fechaproxvis, $this->horaproxvis, '$this->propositovis', '$this->zona', '$this->cultivo');";
        $result = $this->consultas($sql);
        if ($result) {
            $mensaje.= '<p>Se ha registraso el Reporte Comercial</p>';
            $nropreg = array('01', '02', '03');
            //Llenando Respuestas Humagro
            $huma = $this->humarpta;
            $size = count($huma);
            for ($i = 0; $i < $size; $i++) {
                $sqlhuma = "INSERT INTO rpvcdb02 (codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse, fecreg) 
                    VALUES('$this->codrep', 'RP', '$nropreg[$i]', TRUE, FALSE, '$huma[$i]', '$this->coduse', now())";
                $this->consultas($sqlhuma);
            }
//            //Enviar e-mail
//            if ($this->prueba == 'SI') {
//                $this->sendmailRegComercial_Prueba();
//            } else {
//                $this->sendmailRegComercial();
//            }
            //Agendar Proxima Visita
            if ($this->proximavis) {
                $sqla = "INSERT INTO intraagenda(asunto, fechainicio, horainicio, donde, estado, coduse, fecreg) values ('$this->propositovis', $this->fechaproxvis, $this->horaproxvis, '$this->localproxvis', 'PENDIENTE', '$this->coduse', now());";
                $this->consultas($sqla);
            }
        }
        return $result;
    }

    function insert_intravisitas($tipo) {
        $sql = "INSERT INTO intravisitas(codigo, fecinicio, horainicio, horafin, tipo, coduse) values ('$this->codrep', '$this->fechavisita', $this->horaingreso, $this->horasalida, '$tipo', '$this->coduse');";
        $result = $this->consultas($sql);
        return $result;
    }

    function update_intravisitas() {
        $sql = "UPDATE intravisitas SET "
                . "fecinicio = '$this->fecinicio', "
                . "horainicio = '$this->horainicio', "
                . "horafin = '$this->horafin' "
                . "WHERE codigo = '$this->codigo' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function modRepTecnico() {

        $sql = "UPDATE intrareportes SET "
                . "codcliente = '$this->codcliente', "
                . "codfundo = '$this->codfundo', "
                . "codlotehuma = '$this->codlotehuma', "
                . "codlotetestigo = '$this->codlotetestigo', "
                . "contacto = '$this->contacto', "
                . "fechavisita = '$this->fechavisita', "
                . "horaingreso = '$this->horaingreso', "
                . "horasalida = '$this->horasalida', "
                . "fechaproxvis = '$this->fechaproxvis', "
                . "horaproxvis = '$this->horaproxvis', "
                . "propositovis = '$this->propositovis', "
                . "rubrica = '$this->rubrica', "
                . "atendido = '$this->atendido', "
                . "tipo = '$this->tipo', "
                . "nota = '$this->nota', "
                . "coduse = '$this->coduse', "
                . "usemod = '$this->usemod', "
                . "fecreg = '$this->fecreg', "
                . "fecmod = '$this->fecmod' "
                . "WHERE codrep = '$this->codrep' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function deleteRepTecnico() {
        $sql = "DELETE FROM intrareportes WHERE codrep = '$this->codrep' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function getRepTecnicoByID() {
        $sql = "SELECT codrep, codcliente, codfundo, codlotehuma, codlotetestigo, contacto, fechavisita, horaingreso, horasalida, fechaproxvis, horaproxvis, propositovis, rubrica, atendido, tipo, nota, coduse, usemod, fecreg, fecmod FROM intrareportes WHERE codrep = '$this->codrep'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function listarSoloClientes() {
        $sql = "select c.codcliente as id, c.nombre as cliente  from intracliente as c order by c.nombre asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarEncargadoxCliente() {
        $sql = "select nombre, cargo, telefono, email, codcontacto, celular from intracontacto where codcliente = '$this->codcliente' order by nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarFundoxClienteOrdeByCod() {
        $sql = "SELECT f.codcliente, f.codfundo, f.nombre, f.direccion, c.nombre 
                FROM intrafundo f JOIN intracliente c ON f.codcliente = c.codcliente
                WHERE f.codcliente = '$this->codcliente' order by f.codfundo";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarLotexFundo() {
        $sql = "SELECT l.codlote, l.nombre 
                FROM intralote l JOIN intrafundo f ON l.codfundo = f.codfundo
                WHERE l.codfundo = '$this->codfundo' order by l.nombre";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function obtAbreviacion() {
        $sql = "select abrev from intracliente where codcliente = '$this->codcliente';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $abrev = trim($lista[0]);
        return $abrev;
    }

    function validarCodRep($num) {
        $sql = "select count(codrep) from intrareportes where codrep = '$num';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $rpta = trim($lista[0]);
        return $rpta;
    }

    function generarCodRepTecnico($tipo) {
        $codigo = $this->getTipoVisitaTecnica($tipo);
        $abrev = $this->obtAbreviacion();
        $sql = "select count(codrep) from intrareportes";
        //$sql = "select count(codrep) from intrareportes where codrep like '%VT-$abrev%';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $numero = ($lista[0]) + 1;
        $num = $codigo . '-' . $abrev . '-' . (20000 + $numero);
        $existe = 1;
        while ($existe != 0) {
            $existe = $this->validarCodRep($num);
            if ($existe != 0) {
                $numero++;
                $num = $codigo . '-' . $abrev . '-' . (20000 + $numero);
            }
        }
        return $num;
    }

    function getTipoVisitaTecnica($tipo) {
        $valor = '';
        switch ($tipo) {
            case '1': return $valor = 'VTSI';
            case '2': return $valor = 'LTSI';
            case '3': return $valor = 'VTNO';
            case '4': return $valor = 'LTNO';
        }
    }

    function getTipoVisitaComercial($tipo) {
        $valor = '';
        switch ($tipo) {
            case '1': return $valor = 'VCSI';
            case '2': return $valor = 'LCSI';
            case '3': return $valor = 'VCNO';
            case '4': return $valor = 'LCNO';
        }
    }

    function getTipoVisita($tipo, $visita) {
        $valor = '';
        if ($visita == 1) {
            switch ($tipo) {
                case '1': return $valor = 'VTSI';
                case '2': return $valor = 'LTSI';
                case '3': return $valor = 'VTNO';
                case '4': return $valor = 'LTNO';
            }
        } elseif ($visita == 2) {
            switch ($tipo) {
                case '1': return $valor = 'VCSI';
                case '2': return $valor = 'LCSI';
                case '3': return $valor = 'VCNO';
                case '4': return $valor = 'LCNO';
            }
        }
    }

    function generarCodVisita($tipo, $visita) {

        $sql_num = "SELECT codigo from intravisitas order by fecreg desc limit 1";
        $rs_num = $this->consultas($sql_num);
        $list_num = $this->n_fila($rs_num);
        if ($list_num) {
            $exnum = explode('-', $list_num[0]);
            $numero = ($exnum[1] + 1);
        } else {
            $numero = '10000';
        }
        $tvisita = $this->getTipoVisita($tipo, $visita);
        $codvisita = $tvisita . '-' . $numero;
        return $codvisita;
    }

    function generarCodRepComercial($tipo) {
        $codigo = $this->getTipoVisitaComercial($tipo);
        $abrev = $this->obtAbreviacion();
        $sql = "select count(codrep) from intrareportes";
        //$sql = "select count(codrep) from intrareportes where codrep like '%VC-$abrev%';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        $numero = ($lista[0]) + 1;
        $num = $codigo . '-' . $abrev . '-' . (20000 + $numero);
        $existe = 1;
        while ($existe != 0) {
            $existe = $this->validarCodRep($num);
            if ($existe != 0) {
                $numero++;
                $num = $codigo . '-' . $abrev . '-' . (20000 + $numero);
            }
        }
        return $num;
    }

    function generarHora($name, $class) {
        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '">
                        <option value="00:00">..::Seleccione</option>
                        <option value="06:00">06:00</option>
                        <option value="06:15">06:15</option>
                        <option value="06:30">06:30</option>
                        <option value="06:45">06:45</option>
                        <option value="07:00">07:00</option>
                        <option value="07:15">07:15</option>
                        <option value="07:30">07:30</option>
                        <option value="07:45">07:45</option>
                        <option value="08:00">08:00</option>
                        <option value="08:15">08:15</option>
                        <option value="08:30">08:30</option>
                        <option value="08:45">08:45</option>
                        <option value="09:00">09:00</option>
                        <option value="09:15">09:15</option>
                        <option value="09:30">09:30</option>
                        <option value="09:45">09:45</option>
                        <option value="10:00">10:00</option>
                        <option value="10:15">10:15</option>
                        <option value="10:30">10:30</option>
                        <option value="10:45">10:45</option>
                        <option value="11:00">11:00</option>
                        <option value="11:15">11:15</option>
                        <option value="11:30">11:30</option>
                        <option value="11:45">11:45</option>
                        <option value="12:00">12:00</option>
                        <option value="12:15">12:15</option>
                        <option value="12:30">12:30</option>
                        <option value="12:45">12:45</option>
                        <option value="12:00">12:00</option>
                        <option value="12:15">12:15</option>
                        <option value="12:30">12:30</option>
                        <option value="12:45">12:45</option>
                        <option value="13:00">13:00</option>
                        <option value="13:15">13:15</option>
                        <option value="13:30">13:30</option>
                        <option value="13:45">13:45</option>
                        <option value="14:00">14:00</option>
                        <option value="14:15">14:15</option>
                        <option value="14:30">14:30</option>
                        <option value="14:45">14:45</option>
                        <option value="15:00">15:00</option>
                        <option value="15:15">15:15</option>
                        <option value="15:30">15:30</option>
                        <option value="15:45">15:45</option>
                        <option value="16:00">16:00</option>
                        <option value="16:15">16:15</option>
                        <option value="16:30">16:30</option>
                        <option value="16:45">16:45</option>
                        <option value="17:00">17:00</option>
                        <option value="18:15">18:15</option>
                        <option value="18:30">18:30</option>
                        <option value="18:45">18:45</option>
                        <option value="19:00">19:00</option>
                        <option value="19:15">19:15</option>
                        <option value="19:30">19:30</option>
                        <option value="19:45">19:45</option>
                        <option value="20:00">20:00</option>
                        <option value="20:15">20:15</option>
                        <option value="20:30">20:30</option>
                        <option value="20:45">20:45</option>
                        <option value="21:00">21:00</option>
                        <option value="21:15">21:15</option>
                        <option value="21:30">21:30</option>
                        <option value="21:45">21:45</option>
                        <option value="22:00">22:00</option>
                      </select>';
        return $select;
    }

    function getLoteByID() {
        $sql = "SELECT codlote, codcliente, codfundo, nombre, hatrabajada, tipocultivo, variedad, patron, triego, tsuelo FROM intralote WHERE codlote = '$this->codlotehuma'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getLoteByID2() {
        $sql = "SELECT codlote, codcliente, codfundo, nombre, hatotal, hatrabajada, tipocultivo, fecsiembra, variedad, patron, densidad, edadcultivo, efenologica, triego, tsuelo, volaguafoliar, um_volaguafoliar FROM intralote WHERE codlote = '$this->codlote'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function cargarImagen($nombre, $directorio) {

        $aviso = 'Imagen subida correctamente';
        $carpeta = '../site/img/encuesta/';
        $filename = $_FILES['imagen']['name']; //nombre de archivo
        //$archivo = array('jpg', 'JPG', 'JPEG', 'PNG', 'png', 'GIF', 'gif'); //tipo de imágenes que aceptamos
        $tmpname = $_FILES['imagen']['tmp_name']; //nombre temporal de la imagen
        //$datos = date(imdy); //permite que las imágenes no se repitan
        $extension = explode('.', $filename); //repasa la extensión de la imagen
        $extension = $extension[sizeof($extension) - 1]; //repasa la extensión de la imagen
        $imagen = "$datos$filename";
        return $imagen;
    }

    function subirArchivo($directorio, $filename) {

        $tmpname = $_FILES['imagen']['tmp_name']; //nombre temporal de la imagen
        move_uploaded_file($tmpname, "$directorio$filename"); //movemos el archivo a la carpeta de destino
    }

    function registarArchivo($codigo, $url, $descripcion) {
        if ($url != '') {
            $sql = "INSERT INTO intraarchivos(codigo, url, descripcion) values ('$codigo', '$url', '$descripcion');";
            $result = $this->consultas($sql);
            return $result;
        }
    }

    function regClienteSimple($ruc, $nomcliente) {
        $sql = "INSERT INTO intracliente(codcliente, nombre, codcia, coduse, validado) values ('$ruc', '$nomcliente', '01', '$this->coduse', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function regFundoSimple($nomfundo) {
        $sql = "INSERT INTO intrafundo(codcliente, nombre, codcia, coduse, validado) values ('$this->codcliente', '$nomfundo', '01', '$this->coduse', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function regContactoSimple() {
        $sql = "INSERT INTO intracontacto(codcliente, nombre, celular, cargo, coduse, validado) values ('$this->codcliente', '$this->contacto', '$this->celcontacto', '$this->carcontacto',  '$this->coduse', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function modContactoCel() {
        $sql = "UPDATE intracontacto SET celular = '$this->celcontacto', cargo = '$this->carcontacto' WHERE codcontacto = '$this->codcontacto'";
        $result = $this->consultas($sql);
        return $result;
    }

    function getContactoByID() {
        $sql = "SELECT codcontacto, nombre, cargo, telefono, celular FROM intracontacto WHERE codcontacto =  '$this->codcontacto'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function regContactoyCel() {
        $sql = "INSERT INTO intracontacto(codcliente, nombre, coduse, celular,  validado) values ('$this->codcliente', '$this->contacto', '$this->celcontacto', '$this->coduse', FALSE);";
        $result = $this->consultas($sql);
        return $result;
    }

    function regLoteSimple($nombre, $hatotal, $hatrabajada, $tipocultivo, $variedad, $patron, $densidad, $edadcultivo, $efenologica, $triego, $tsuelo, $volaguafoliar, $um_volaguafoliar) {
        $sql = "INSERT INTO intralote(codcliente, codfundo, nombre, hatotal, hatrabajada, tipocultivo, variedad, patron, densidad, edadcultivo, efenologica, triego, tsuelo, volaguafoliar, um_volaguafoliar, coduse) values ('$this->codcliente', '$this->codfundo', '$nombre', '$hatotal', '$hatrabajada', '$tipocultivo', '$variedad', '$patron', '$densidad', '$edadcultivo', '$efenologica', '$triego', '$tsuelo', '$volaguafoliar', '$um_volaguafoliar', '$this->coduse');";
        $result = $this->consultas($sql);
        return $result;
    }

    function getLastIDLote() {
        $sql = "SELECT MAX(codlote) FROM intralote;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getLastIDFundo() {
        $sql = "SELECT MAX(codfundo) FROM intrafundo;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getNextIDFundo() {
        $sql = "SELECT MAX(codfundo+1) FROM intrafundo;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function obtFechadeHoy() {
        $getfecha = getdate();
        $dia = $getfecha['mday'];
        $mes = $getfecha['mon'];
        $ano = $getfecha['year'];
        $hoy = $ano . '/' . $mes . '/' . $dia;
        return $hoy;
    }
    

    //Esta funcion lo usan Rep Tecnico y Comercial
    function listarRepTecnicoxCod() {
        $sql = "SELECT r.codrep, r.codcliente, c.nombre as cliente, r.codfundo, f.nombre as fundo, r.coduse, u.desuse, r.contacto, fechavisita, EXTRACT(HOUR FROM horaingreso) AS horaing,  EXTRACT(MINUTE FROM horaingreso) as mining, EXTRACT(HOUR FROM horasalida) AS horasal,  EXTRACT(MINUTE FROM horasalida) as minsal, fechaproxvis, EXTRACT(HOUR FROM horaproxvis) AS horavis,  EXTRACT(MINUTE FROM horaproxvis) as minvis, propositovis, nota, rubrica, codlotehuma, codlotetestigo, r.atendido, r.zona, r.cultivo, r.fecreg
                FROM intrareportes as r 
                JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN intrafundo as f ON f.codfundo = r.codfundo and f.codcliente = r.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse WHERE codrep = '$this->codrep'";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getContactosByCliente() {
        $sql = "select c.codcontacto, c.nombre, dni, cargo, c.telefono, anexo, celular, email, fecnac from intracontacto as c WHERE c.codcliente = '$this->codcliente';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getObs() {
        $sql = "SELECT codigo, codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse
                FROM rpvcdb02 where codrep = '$this->codrep' order by nropreg";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function obtRespuestasHumarepTecnico() {
        $sql = "SELECT codigo, codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse
                FROM rpvcdb02 where ishumagro = true and codrep = '$this->codrep' order by nropreg";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function obtRespuestasTestrepTecnico() {
        $sql = "SELECT codigo, codrep, codpreg, nropreg, ishumagro, istestigo, respuesta, coduse
                FROM rpvcdb02 where istestigo = true and codrep = '$this->codrep' order by nropreg";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //ENVIAR CORREOS

    function msjRepTecnicoNuevo() {
        $fechaproxvis = '';
        if ($this->fechaproxvis != '') {
            $fechaproxvis = date("d/m/Y", strtotime(trim($this->fechavisita)));
        }
        if ($this->horaproxvis == '00:00') {
            $this->horaproxvis = '';
        }

        $body = '<!DOCTYPE html>

<html lang="ES">
    <head>
        <title></title>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style> .tabla { width: 100%; font-family: Courier New; }</style>
    </head>
    <body>        
        <p>Se ha creado un nuevo <strong>Reporte T&eacute;cnico</strong>, el cual se detalla a continuaci&oacute;n:</p>
        <br/>                
        <table class="tabla">
            <tbody>
                <tr>
                    <td bgcolor="whitesmoke" colspan="2"><h4 style="text-align: center;"> Reporte T&eacute;cnico <font color="red">N&ordm; ' . $this->codrep . '</font></h4></td>
                </tr>
                <tr>
                    <td width="300px" >Cliente:<strong> ' . $this->nomcliente . '</strong></td>                    
                    <td width="300px">Fundo:<strong> ' . $this->nomfundo . '</strong></td>
                </tr>
                <tr>                    
                    <td>Encargado: ' . $this->contacto . '</td>
                    <td>Asesor: ' . $this->asesor . '</td>
                </tr>
                <tr>                    
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Fecha de Visita: ' . date("d/m/Y", strtotime(trim($this->fechavisita))) . '</td>
                    <td>Fecha Pr&oacute;xima Visita: ' . trim($fechaproxvis) . ' </td>                                    
                </tr>
                <tr>
                    <td>Hora Entrada: ' . $this->horaingreso . '</td>                
                    <td>Hora Pr&oacute;xima Visita: ' . $this->horaproxvis . '</td>
                </tr>
                <tr>
                    <td>Hora Salida: ' . $this->horasalida . ' </td>                
                    <td>Proposito: ' . $this->propositovis . '</td>                                    
                </tr>
            </tbody>
        </table>
    </body>
</html><p><a href="www.agromicrobiotech.com"> Visitar Web de Agro Micro Biotech</a></>';

        return $body;
    }

    function msjRepComercialNuevo() {

        if (empty(trim($_POST['fechaproxvis'])) || $_POST['fechaproxvis'] == 'NULL') {
            $fechaproxvis = '';
        } else {
            $fechaproxvis = date("d/m/Y", strtotime(trim($_POST['fechaproxvis'])));
        }
        if ($this->horaproxvis == '00:00' || $this->horaproxvis == 'NULL') {
            $this->horaproxvis = '';
        }

        $mensaje = '';
        if ($this->atendido == '1') {
            $mensaje = '<strong>Visita Comercial</strong>';
        }
        if ($this->atendido == '2') {
            $mensaje = '<strong>Llamada Comercial</strong>';
        }
        if ($this->atendido == '3') {
            $mensaje = '<strong>Visita Comercial No Atendida</strong>';
        }
        if ($this->atendido == '4') {
            $mensaje = '<strong>Llamada Comercial No Atendida</strong>';
        }

        $body = '<!DOCTYPE html>

<html lang="ES">
    <head>
        <title></title>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style> .tabla { width: 100%; font-family: Courier New; }</style>
    </head>
    <body>        
        <p>Se ha creado una ' . $mensaje . ' la cual se detalla a continuaci&oacute;n:</p>
        <br/>                
        <table class="tabla">
            <tbody>
                <tr>
                    <td bgcolor="whitesmoke" colspan="2"><h4 style="text-align: center;"> ' . $mensaje . ' <font color="red">N&ordm; ' . $this->codrep . '</font></h4></td>
                </tr>
                <tr>
                    <td width="300px" >Cliente:<strong> ' . $this->nomcliente . '</strong></td>                    
                    <td width="300px">Fundo:<strong> ' . $this->nomfundo . '</strong></td>
                </tr>
                <tr>                    
                    <td>Contacto: ' . $this->contacto . '</td>
                    <td>Asesor: ' . $this->asesor . '</td>
                </tr>
                <tr>                    
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Fecha de Visita: ' . date("d/m/Y", strtotime(trim($this->fechavisita))) . '</td>
                    <td>Fecha Pr&oacute;xima Visita: ' . trim($fechaproxvis) . ' </td>                                    
                </tr>
                <tr>
                    <td>Hora Entrada: ' . $this->horaingreso . '</td>                
                    <td>Hora Pr&oacute;xima Visita: ' . $this->horaproxvis . '</td>                                    
                </tr>
                <tr>
                    <td>Hora Salida: ' . $this->horasalida . ' </td>                
                    <td>Proposito: ' . $this->propositovis . '</td>                                    
                </tr>
            </tbody>
        </table>
    </body>
</html><p><a href="www.agromicrobiotech.com"> Visitar Web de Agro Micro Biotech</a></>';

        return $body;
    }

    function sendmailRegTecnico_Prueba() {
        require_once '../site/html2pdf_v4.03/html2pdf.class.php';

        //Recogemos el contenido de la vista
        ob_start();

        $reporte = $this->listarRepTecnicoxCod();
        $imagenes = $this->cargarArchivosByCodRep();
        $huma = FALSE;
        $test = FALSE;
        if ($reporte[19] != '') {
            $huma = TRUE;
            $this->codlote = $reporte[19];
            $lshuma = $this->getLoteByID2();
            $rptaHuma = $this->obtRespuestasHumarepTecnico();
        }
        if ($reporte[20] != '') {
            $test = TRUE;
            $this->codlote = $reporte[20];
            $lstest = $this->getLoteByID2();
            $rptaTest = $this->obtRespuestasTestrepTecnico();
        }

        if ($reporte[21] == 3 || $reporte[21] == 4) {
            $rptaObs = $this->getObs();
            $_POST['rptaObs'] = $rptaObs;
        }

        $_POST['reporte'] = $reporte;
        if ($huma == TRUE) {

            $_POST['lshuma'] = $lshuma;
            $_POST['rptaHuma'] = $rptaHuma;
        }
        if ($test == TRUE) {
            $_POST['lstest'] = $lstest;
            $_POST['rptaTest'] = $rptaTest;
        }

        $_POST['huma'] = $huma;
        $_POST['test'] = $test;

        require_once '_plantilla_reptecnico2.php';
        $html = ob_get_clean();

        //Le indicamos el tipo de hoja y la codificación de caracteres
        $mipdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8', array(2, 1.5, 1.5, 2));

        //Escribimos el contenido en el PDF
        $mipdf->writeHTML($html);

        //Generamos el PDF        
        $mipdf->Output('pdf_reptecnico/' . $this->codrep . '.pdf', 'F');

        //ENVIAR MAIL           
        $this->__set('asesor', trim($reporte[6]));
        $this->__set('nomcliente', trim($reporte[2]));
        $this->__set('nomfundo', trim($reporte[4]));
        $titulo = trim($this->codrep) . ' - ' . trim($this->asesor) . ' - ' . trim($this->nomcliente) . ' - ' . trim($this->nomfundo);

        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->From = "sistemas@humagroperu.com";
        $mail->FromName = "HUMAGRO FERTILIZANTES";
        $mail->Subject = $titulo;
        $mail->Body = $this->msjRepTecnicoNuevo();
        $mail->IsHTML(true);        
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder");

//        if (isset($_POST['copiamail'])) {
//            $mail->AddAddress($_SESSION['email_usuario'], "");
//        }

        $archivo = '../controller/pdf_reptecnico/' . $this->codrep . '.pdf';
        $mail->AddAttachment($archivo, $this->codrep);

        foreach ($imagenes as $value) {
            $url = '../site/archivos/reptecnico/' . $value[1];
            $mail->AddAttachment($url);
        }

        if ($mail->Send()) {
            //echo '<br/><div class="alert alert-success" id="mensaje">Se envio un documento PDF adjunto</div>';
        } else {
            //echo '<br/><div class="alert alert-danger" id="mensaje">Error. No se pudo enviar el email</div>';
        }
    }

    function sendmailRegTecnico() {
        require_once '../site/html2pdf_v4.03/html2pdf.class.php';

        //Recogemos el contenido de la vista
        ob_start();

        $reporte = $this->listarRepTecnicoxCod();
        $imagenes = $this->cargarArchivosByCodRep();
        $huma = FALSE;
        $test = FALSE;
        if ($reporte[19] != '') {
            $huma = TRUE;
            $this->codlote = $reporte[19];
            $lshuma = $this->getLoteByID2();
            $rptaHuma = $this->obtRespuestasHumarepTecnico();
        }
        if ($reporte[20] != '') {
            $test = TRUE;
            $this->codlote = $reporte[20];
            $lstest = $this->getLoteByID2();
            $rptaTest = $this->obtRespuestasTestrepTecnico();
        }

        if ($reporte[21] == 3 || $reporte[21] == 4) {
            $rptaObs = $this->getObs();
            $_POST['rptaObs'] = $rptaObs;
        }

        $_POST['reporte'] = $reporte;
        if ($huma == TRUE) {

            $_POST['lshuma'] = $lshuma;
            $_POST['rptaHuma'] = $rptaHuma;
        }
        if ($test == TRUE) {
            $_POST['lstest'] = $lstest;
            $_POST['rptaTest'] = $rptaTest;
        }

        $_POST['huma'] = $huma;
        $_POST['test'] = $test;

        require_once '_plantilla_reptecnico2.php';
        $html = ob_get_clean();

        //Le indicamos el tipo de hoja y la codificación de caracteres
        $mipdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8', array(2, 1.5, 1.5, 2));

        //Escribimos el contenido en el PDF
        $mipdf->writeHTML($html);

        //Generamos el PDF        
        $mipdf->Output('pdf_reptecnico/' . $this->codrep . '.pdf', 'F');

        //ENVIAR MAIL           
        $this->__set('asesor', trim($reporte[6]));
        $this->__set('nomcliente', trim($reporte[2]));
        $this->__set('nomfundo', trim($reporte[4]));
        $titulo = trim($this->codrep) . ' - ' . trim($this->asesor) . ' - ' . trim($this->nomcliente) . ' - ' . trim($this->nomfundo);

        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->From = "sistemas@humagroperu.com";
        $mail->FromName = "HUMAGRO FERTILIZANTES";
        $mail->Subject = $titulo;
        $mail->Body = $this->msjRepTecnicoNuevo();
        $mail->IsHTML(true);
        $mail->AddAddress('gerentetecniconacional@humagroperu.com', "Diego Diaz");
        $mail->AddAddress('gerentetecnicosur@humagroperu.com', "Helio Gonzales");
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder");

//        if (isset($_POST['copiamail'])) {
//            $mail->AddAddress($_SESSION['email_usuario'], "");
//        }

        $archivo = '../controller/pdf_reptecnico/' . $this->codrep . '.pdf';
        $mail->AddAttachment($archivo, $this->codrep);

        foreach ($imagenes as $value) {
            $url = '../site/archivos/reptecnico/' . $value[1];
            $mail->AddAttachment($url, $value[1]);
        }

        if ($mail->Send()) {
            //echo '<br/><div class="alert alert-success" id="mensaje">Se envio un documento PDF adjunto</div>';
        } else {
            //echo '<br/><div class="alert alert-danger" id="mensaje">Error. No se pudo enviar el email</div>';
        }
    }

    function sendmailRegTecnicotoClientes($correos) {

        //ENVIAR MAIL                           
        $cadena = '';
        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();

        //$de = $_SESSION['email_usuario'];
        //$nombre = $_SESSION['nombreUsuario'];


        $mail->From = $this->de;
        $mail->FromName = $this->nombre;
        $mail->Subject = $this->asunto;
        $mail->Body = $this->msj;
        $mail->IsHTML(true);
        if (!empty($correos)) {
            foreach ($correos as $value) {
                if (isset($value)) {
                    $cadena.= $value . ', ';
                    $mail->AddAddress($value);
                }
            }
        }

        if (!empty($this->para)) {
            $mail->AddAddress($this->para, "");
            $cadena.= $this->para . ', ';
        }



        //$mail->AddAddress('gerentetecnicosur@humagroperu.com', "Helio Gonzales");
        //$mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder"); //Copia Oculta Juan Leder
        $mail->addBCC($this->de, $this->nombre); //Copia Oculta al remitente


        $archivo = '../controller/pdf_reptecnico/' . $this->codrep . '.pdf';
        $mail->AddAttachment($archivo, $this->codrep);
        if ($mail->Send()) {
            echo '<br/><div class="alert alert-success" id="mensaje">Se envio a ' . $cadena . 'con éxito</div>';
        } else {
            echo '<br/><div class="alert alert-danger" id="mensaje">Error. No se pudo enviar el correo.</div>';
        }
    }

    function sendmailRegComercial_Prueba() {
        require_once '../site/html2pdf_v4.03/html2pdf.class.php';

        //Recogemos el contenido de la vista
        ob_start();
        $reporte = $this->listarRepTecnicoxCod();
        $rptaHuma = $this->obtRespuestasHumarepTecnico();
        $imagenes = $this->cargarArchivosByCodRep();

        $_POST['reporte'] = $reporte;
        $_POST['rptaHuma'] = $rptaHuma;

        require_once '_plantilla_repcomercialv2.php';
        $html = ob_get_clean();

        //Le indicamos el tipo de hoja y la codificación de caracteres
        $mipdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8', array(2, 1.5, 1.5, 2));

        //Escribimos el contenido en el PDF
        $mipdf->writeHTML($html);

        //Generamos el PDF        
        $mipdf->Output('pdf_reptecnico/' . $this->codrep . '.pdf', 'F');

        //ENVIAR MAIL    
        $this->__set('asesor', trim($reporte[6]));
        $this->__set('nomcliente', trim($reporte[2]));
        $this->__set('nomfundo', trim($reporte[4]));
        $titulo = trim($this->codrep) . ' - ' . trim($this->asesor) . ' - ' . trim($this->nomcliente) . ' - ' . trim($this->nomfundo);

        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->From = "sistemas@humagroperu.com";
        $mail->FromName = "HUMAGRO FERTILIZANTES";
        $mail->Subject = $titulo;
        $mail->Body = $this->msjRepComercialNuevo();
        $mail->IsHTML(true);
        $mail->addAddress('juanleder@gmail.com', "Juan Leder");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder");

        $archivo = '../controller/pdf_reptecnico/' . $this->codrep . '.pdf';
        $mail->AddAttachment($archivo, $this->codrep);

        foreach ($imagenes as $value) {
            $url = '../site/archivos/repcomercial/' . $value[1];
            $mail->AddAttachment($url);
        }
        if ($mail->Send()) {
            // echo '<br/><div class="alert alert-success" id="mensaje">Se envio un documento PDF adjunto</div>';
        } else {
            //echo '<br/><div class="alert alert-danger" id="mensaje">Error. No se pudo enviar el email</div>';
        }
    }

    function sendmailRegComercial() {
        require_once '../site/html2pdf_v4.03/html2pdf.class.php';

        //Recogemos el contenido de la vista
        ob_start();
        $reporte = $this->listarRepTecnicoxCod();
        $rptaHuma = $this->obtRespuestasHumarepTecnico();
        $imagenes = $this->cargarArchivosByCodRep();

        $_POST['reporte'] = $reporte;
        $_POST['rptaHuma'] = $rptaHuma;

        require_once '_plantilla_repcomercialv2.php';
        $html = ob_get_clean();

        //Le indicamos el tipo de hoja y la codificación de caracteres
        $mipdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8', array(2, 1.5, 1.5, 2));

        //Escribimos el contenido en el PDF
        $mipdf->writeHTML($html);

        //Generamos el PDF        
        $mipdf->Output('../site/archivos/pdf_visitas/' . $this->codrep . '.pdf', 'F');

        //ENVIAR MAIL       
        $this->__set('asesor', trim($reporte[6]));
        $this->__set('nomcliente', trim($reporte[2]));
        $this->__set('nomfundo', trim($reporte[4]));
        $titulo = trim($this->codrep) . ' - ' . trim($this->asesor) . ' - ' . trim($this->nomcliente) . ' - ' . trim($this->nomfundo);

        require '../site/PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->From = "sistemas@humagroperu.com";
        $mail->FromName = "HUMAGRO FERTILIZANTES";
        $mail->Subject = $titulo;
        $mail->Body = $this->msjRepComercialNuevo();
        $mail->IsHTML(true);
        $mail->AddAddress('gerentetecniconacional@humagroperu.com', "Diego Diaz");
        $mail->AddAddress('acomercial@humagroperu.com', "");
        $mail->addCC('reportes@humagroperu.com', "Salvador Giha");
        $mail->addBCC('sistemas@humagroperu.com', "Juan Leder");

        $archivo = '../controller/pdf_reptecnico/' . $this->codrep . '.pdf';
        $mail->AddAttachment($archivo, $this->codrep);

        foreach ($imagenes as $value) {
            $url = '../site/archivos/repcomercial/' . $value[1];
            $mail->AddAttachment($url, $value[1]);
        }
        if ($mail->Send()) {
            //    echo '<br/><div class="alert alert-success" id="mensaje">Se envio un documento PDF adjunto</div>';
        } else {
            //    echo '<br/><div class="alert alert-danger" id="mensaje">Error. No se pudo enviar el email</div>';
        }
    }

    function ultimosReportes() {
        $sql = "select r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where tipo = 1 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc limit 40 ";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getAdjuntoByCodRep() {
        $sql = "select a.codarchivo, a.codigo, a.url, a.descripcion
            FROM intraarchivos as a  JOIN intrareportes as r ON a.codigo = r.codrep                
            WHERE r.codrep = '$this->codrep'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function ultimosReportesxUsuario() {
        $sql = "select r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep WHERE tipo = 1 AND r.coduse='$this->coduse' GROUP BY r.codrep, u.desuse, c.nombre, a.codigo  ORDER BY r.fechavisita desc limit 20";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function ultimosRepComercial() {
        $sql = "select r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		where tipo = 2 GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY r.fechavisita desc limit 40";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function ultimosRepComercialxUsuario() {
        $sql = "select r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep WHERE tipo = 2 AND r.coduse='$this->coduse' GROUP BY r.codrep, u.desuse, c.nombre, a.codigo  ORDER BY r.fechavisita desc limit 20";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarAsesoresxRepComercial() {
        $sql = "select distinct trim(r.coduse) as usuario, trim(desuse) as nombre from intrareportes as r JOIN aausdb01 as u ON r.coduse = u.coduse where r.tipo = 2 AND activo = 't';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarMeses() {
        $meses = array('01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO',
            '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');
        return $meses;
    }
    
    function getMes($numero){
        $mes = 'ENERO';
        switch ($numero){
            case '1': $mes = 'ENERO';  break;
            case '2': $mes = 'FEBRERO';  break;
            case '3': $mes = 'MARZO';  break;
            case '4': $mes = 'ABRIL';  break;
            case '5': $mes = 'MAYO';  break;
            case '6': $mes = 'JUNIO';  break;
            case '7': $mes = 'JULIO';  break;
            case '8': $mes = 'AGOSTO';  break;
            case '9': $mes = 'SEPTIEMBRE';  break;
            case '10': $mes = 'OCTUBRE';  break;
            case '11': $mes = 'NOVIEMBRE';  break;
            case '12': $mes = 'DICIEMBRE';  break;            
        }
        return $mes;
    }

    function cargarAsesoresxRepTecnico() {
        $sql = "select distinct trim(r.coduse), trim(desuse)  from intrareportes as r JOIN aausdb01 as u ON r.coduse = u.coduse where r.tipo = 1;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function cargarAsesoresxCoduse() {
        $sql = "select coduse, trim(desuse), vendedor, vt, vc, externo, store from aausdb01 where coduse = '$this->coduse';";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function cargarArchivosByCodRep() {
        $sql = "select codarchivo, url from intraarchivos where codigo = '$this->codrep'";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarIconoComercial($valor) {

        $rpta = '';

        switch ($valor) {

            case 1:
                $rpta = '<img src = "img/iconos/campo.jpg" height = "20" width="20" />';
                break;
            case 2:
                $rpta = '<img src = "img/iconos/phone.gif" height = "20" width="20" />';
                break;
            case 3:
                $rpta = '<img src = "img/iconos/descarte.png" height = "20" width="20" />';
                break;
            case 4:
                $rpta = '<img src = "img/iconos/llamada-perdida.png" height = "20" width="20" />';
                break;
        }
        return $rpta;
    }

    function generateRandomString($length) {
        $string = "";

        //character that can be used 
        $possible = "0123456789bcdfghjkmnpqrstvwxyz";
        for ($i = 0; $i < $length; $i++) {
            $char = substr($possible, rand(0, strlen($possible) - 1), 1);

            if (!strstr($string, $char)) {
                $string .= $char;
            }
        }
        return $string;
    }

    function eliminarReporte() {
        $rpta = false;
        //Eliminamos las respuestas HUMAGRO Y TESTIGO
        $sql1 = "DELETE FROM rpvcdb02 WHERE codrep = '$this->codrep'";

        //ELIMINAMOS LAS FOTOS        
        $sql2 = "DELETE FROM intraarchivos WHERE codigo = '$this->codrep'";
        $result = $this->consultas($sql1);
        $this->consultas($sql2);

        if ($result) {
            $sql3 = "DELETE FROM intrareportes WHERE codrep = '$this->codrep'";
            $result3 = $this->consultas($sql3);
            if ($result3) {
                $rpta = true;
            }
        }

        return $rpta;
    }

    function delete_intravisitas() {
        $sql = "DELETE FROM intravisitas WHERE codigo = '$this->codrep' ";
        $result = $this->consultas($sql);
        return $result;
    }

    function calcular_reportes($desde, $hasta, $tipo) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre, r.contacto,  r.atendido, r.codfundo, a.codigo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
		LEFT JOIN intraarchivos as a ON a.codigo = r.codrep	
		WHERE r.fechavisita BETWEEN '$desde' AND '$hasta' AND tipo = $tipo GROUP BY r.codrep, u.desuse, c.nombre, a.codigo ORDER BY u.desuse, r.fechavisita desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Reporte Estadistica
    //Consulta 1: Consultamos los dias que tiene esta consulta
    function mostrarDias($desde, $hasta, $tipo) {
        $sql = "SELECT date(fecreg) as fecha FROM intrareportes WHERE date(fecreg) BETWEEN '$desde' AND '$hasta' AND tipo = '$tipo' GROUP BY date(fecreg) ORDER BY date(fecreg) asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Consultar dias por Solicitud
    function mostrarDiasxSolicitud($desde, $hasta) {
        $sql = "SELECT date(fecreg) as fecha FROM prscdb01 WHERE date(fecreg) BETWEEN '$desde' AND '$hasta' GROUP BY date(fecreg) ORDER BY date(fecreg) asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Consultar dias por Propuestas Aprobadas
    function mostrarDiasxPropAprob($desde, $hasta) {
        $sql = "SELECT date(fecaprob) as fecha FROM propdb00 WHERE date(fecaprob) BETWEEN '$desde' AND '$hasta' GROUP BY date(fecaprob) ORDER BY date(fecaprob) asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

//Consulta 2: Recorrer las visitas comerciales
    function mostrarVisitas($fecha, $tipo) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg) AS fecregistro, u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, r.codcliente
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
		WHERE date(r.fecreg) = '$fecha' AND tipo = $tipo GROUP BY r.codrep, u.desuse, c.nombre, f.nombre ORDER BY fechavisita desc, horaingreso asc, u.desuse asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarVisitasxFechavisita($fecha, $tipo) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg) AS fecregistro, u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, r.codcliente
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
		WHERE date(r.fechavisita) = '$fecha' AND tipo = $tipo GROUP BY r.codrep, u.desuse, c.nombre, f.nombre ORDER BY fecregistro asc, horaingreso asc, u.desuse asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarVisitasComxDia($tipo, $fecha) {
        $sql = "SELECT r.codrep, r.fechavisita, r.fecreg , u.desuse, c.nombre as cliente, r.contacto, r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, c.codcliente
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
		WHERE tipo = $tipo AND date(r.fecreg) = '$fecha' GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, c.codcliente ORDER BY fechavisita desc, u.desuse asc, horaingreso asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarSolicitudPropxDia($fecha) {
        $sql = "select asesor, c.nombre as cliente, f.nombre as fundo, cultivo, ha, s.codsolicitud
                FROM prscdb01 as s JOIN intracliente as c ON s.codcliente = c.codcliente
                JOIN intrafundo as f ON f.codfundo = s.codfundo                                
                where date(s.fecreg) = '$fecha';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarPropAprobxDia($fecha) {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where date(p.fecaprob) = '$fecha' AND aprobado = 'APROBADO';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarPropEnviadasxDia($fecha) {
        $sql = "SELECT codprop, p.codcliente, p.contacto, p.fecaprob, u.desuse as asesor, elaboradopor, obs, desuse, c.nombre as cliente, cultivo, ha, monto, descuento, moneda
                FROM propdb00 as p JOIN intracliente as c ON p.codcliente = c.codcliente
                JOIN aausdb01 as u ON p.asesor = u.coduse
                where date(p.fecenvio) = '$fecha';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarSolicitudPropxSemana($desde, $hasta) {
        $sql = "select asesor, c.nombre as cliente, f.nombre as fundo, cultivo, ha, s.codsolicitud
                FROM prscdb01 as s JOIN intracliente as c ON s.codcliente = c.codcliente
                JOIN intrafundo as f ON f.codfundo = s.codfundo                                
                where date(s.fecreg) BETWEEN '$desde' AND '$hasta';";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Consula 3: Obtener los vendedores o asesores de este rango.
    function mostrarAsesores($desde, $hasta, $tipo) {
        $sql = "select u.desuse, r.coduse, count(r.atendido) as cantidad
                FROM intrareportes as r JOIN aausdb01 as u ON u.coduse = r.coduse                 		
		WHERE date(r.fecreg) BETWEEN '$desde' AND '$hasta' AND r.tipo = $tipo GROUP BY u.desuse, r.coduse ORDER BY cantidad desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarAsesoresxFechavisita($desde, $hasta, $tipo) {
        $sql = "select u.desuse, r.coduse, count(r.atendido) as cantidad
                FROM intrareportes as r JOIN aausdb01 as u ON u.coduse = r.coduse                 		
		WHERE date(r.fechavisita) BETWEEN '$desde' AND '$hasta' AND r.tipo = $tipo GROUP BY u.desuse, r.coduse ORDER BY cantidad desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarAsesoresAll($desde, $hasta) {
        $sql = "select u.desuse, r.coduse, count(r.atendido) as cantidad
                FROM intrareportes as r JOIN aausdb01 as u ON u.coduse = r.coduse                 		
		WHERE date(r.fecreg) BETWEEN '$desde' AND '$hasta' GROUP BY u.desuse, r.coduse ORDER BY cantidad desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Consula 3: Obtener los vendedores o asesores de este rango.
    function mostrarAsesoresxDia($fecha, $tipo) {
        $sql = "select u.desuse, r.coduse, count(r.atendido) as cantidad
                FROM intrareportes as r JOIN aausdb01 as u ON u.coduse = r.coduse                 		
		WHERE date(r.fecreg) = '$fecha' AND r.tipo = $tipo GROUP BY u.desuse, r.coduse ORDER BY cantidad desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarAsesoresVC() {
        $sql = "select coduse, desuse FROM aausdb01 where vc = 'SI' ORDER BY desuse asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarAsesoresVT() {
        $sql = "select coduse, desuse FROM aausdb01 where vt = 'SI' ORDER BY desuse asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Consulta 4: Obtener el numero de visitas por tipo de visita
    function mostrarNroxTipoVisitas($desde, $hasta, $tipo, $coduse, $tvisita) {
        $sql = "select r.coduse, r.atendido, count(atendido) AS cantidad
                FROM intrareportes as r JOIN aausdb01 as u ON u.coduse = r.coduse                 		
		WHERE date(r.fecreg) BETWEEN '$desde' AND '$hasta' AND r.tipo = $tipo AND r.coduse = '$coduse' AND atendido = $tvisita GROUP BY  r.coduse, r.atendido";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function mostrarNroxTipoVisitasFechavisita($desde, $hasta, $tipo, $coduse, $tvisita) {
        $sql = "select r.coduse, r.atendido, count(atendido) AS cantidad
                FROM intrareportes as r JOIN aausdb01 as u ON u.coduse = r.coduse                 		
		WHERE date(r.fechavisita) BETWEEN '$desde' AND '$hasta' AND r.tipo = $tipo AND r.coduse = '$coduse' AND atendido = $tvisita GROUP BY  r.coduse, r.atendido";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function mostrarAsesoresxDia_SolProp($fecha) {
        $sql = "SELECT u.desuse, s.coduse, count(s.coduse) as cantidad
                FROM prscdb01 as s JOIN aausdb01 as u ON u.coduse = s.coduse                 		
		WHERE date(s.fecreg) = '$fecha' GROUP BY u.desuse, s.coduse ORDER BY cantidad desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarAsesoresxSemana_SolProp($desde, $hasta) {
        $sql = "SELECT u.desuse, s.coduse, count(s.coduse) as cantidad
                FROM prscdb01 as s JOIN aausdb01 as u ON u.coduse = s.coduse                 		
		WHERE date(s.fecreg) BETWEEN '$desde' AND '$hasta' GROUP BY u.desuse, s.coduse ORDER BY cantidad desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarAsesorxSemana_PropAprob($desde, $hasta) {
        $sql = "SELECT u.desuse, p.asesor, count(p.asesor) as cantidad
                FROM propdb00 as p JOIN aausdb01 as u ON u.coduse = p.asesor                 		
		WHERE date(p.fecaprob) BETWEEN '$desde' AND '$hasta' GROUP BY u.desuse, p.asesor ORDER BY cantidad desc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarNroxTipoVisitasxDia($fecha, $tipo, $coduse, $tvisita) {
        $sql = "select r.coduse, r.atendido, count(atendido) AS cantidad
                FROM intrareportes as r JOIN aausdb01 as u ON u.coduse = r.coduse                 		
		WHERE date(r.fecreg) = '$fecha' AND r.tipo = $tipo AND r.coduse = '$coduse' AND atendido = $tvisita GROUP BY  r.coduse, r.atendido";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function mostrarVisitasAll($fecha, $usuario) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg) as fecregistro , u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, l.tipocultivo, r.codcliente, r.tipo
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
                LEFT JOIN intralote as l ON l.codlote = r.codlotehuma		
		WHERE date(r.fechavisita) = '$fecha' and r.coduse = '$usuario'  GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, l.tipocultivo 
		ORDER BY r.fechavisita desc, horaingreso asc, u.desuse asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarVisitasTecnicas($fecha, $tipo) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg) as fecregistro , u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, l.tipocultivo, r.codcliente
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
                LEFT JOIN intralote as l ON l.codlote = r.codlotehuma		
		WHERE tipo = '$tipo' AND date(r.fecreg) = '$fecha' GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, l.tipocultivo 
		ORDER BY r.fechavisita desc, horaingreso asc, u.desuse asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarVisitasTecnicasxFecVisita($fecha, $tipo) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg) as fecregistro , u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, l.tipocultivo, r.codcliente
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
                LEFT JOIN intralote as l ON l.codlote = r.codlotehuma		
		WHERE tipo = '$tipo' AND date(r.fechavisita) = '$fecha' GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, l.tipocultivo 
		ORDER BY fecregistro asc, horaingreso asc, u.desuse asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //MOSTRAR VISITAS TECNICAS POR DIA
    function mostrarVisitasTecnicasxDia($tipo, $fecha) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg) , u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, l.tipocultivo, c.codcliente
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
                LEFT JOIN intralote as l ON l.codlote = r.codlotehuma		
		WHERE tipo = $tipo AND date(r.fecreg)='$fecha' GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, l.tipocultivo, c.codcliente ORDER BY fechavisita desc, u.desuse asc, horaingreso asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function insertarAccion($accion) {

        $usuario = $_SESSION['usuario'];
        $pc = gethostname();

        $sql = "INSERT INTO aausdb03(usuario, accion, pc) VALUES ('$usuario', '$accion', '$pc' )";
        $result = $this->consultas($sql);
        return $result;
    }

    function arrayDias($desde, $hasta) {
        $fechas = array();
        while ($desde <= $hasta) {
            array_push($fechas, $desde);
            $desde = date('Y-m-d', strtotime($desde . '+1 day'));
        }
        return $fechas;
    }

    function getDiasEspanhol($fecha) {
        $dias = array('Dias', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
        $dia = $dias[date('N', strtotime($fecha))];
        return $dia;
    }

    function getDiaCompleto($fecha) {
        $dia = getDiasEspanhol($fecha);
        $fechaesp = date('d/m/Y', strtotime($fecha));
        $diacompleto = $dia . ', ' . $fechaesp;
        return $diacompleto;
    }

    function getVisitaTecnica($tipo) {
        $tipovisita = '';
        switch ($tipo) {
            case 1: $tipovisita = '<span class="vsi">VTSI</span>';
                break;
            case 2: $tipovisita = '<span class="vno">VTNO</span>';
                break;
            case 3: $tipovisita = '<span class="lsi">LTSI</span>';
                break;
            case 4: $tipovisita = '<span class="lno"">LTNO</span>';
                break;
        }

        return $tipovisita;
    }

    function getVisitaComercial($tipo) {
        $tipovisita = '';
        switch ($tipo) {
            case 1: $tipovisita = '<span class="vsi">VCSI</span>';
                break;
            case 3: $tipovisita = '<span class="vno">VCNO</span>';
                break;
            case 2: $tipovisita = '<span class="lsi">LCSI</span>';
                break;
            case 4: $tipovisita = '<span class="lno"">LCNO</span>';
                break;
        }

        return $tipovisita;
    }

    function getVendedores() {
        $sql = "SELECT desuse FROM aausdb01 WHERE vendedor = 'SI' and activo = true;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getTituloVerRepTecnico($atendido) {
        $titulo = '';
        switch ($atendido) {
            case 1: $titulo = 'REPORTE VISITA TÉCNICA ATENDIDA';
                break;
            case 2: $titulo = 'REPORTE LLAMADA TÉCNICA ATENDIDA';
                break;
            case 3: $titulo = 'REPORTE VISITA TÉCNICA NO ATENDIDA';
                break;
            case 4: $titulo = 'REPORTE LLAMADA TÉCNICA NO ATENDIDA';
                break;
        }
        return $titulo;
    }

    //***********************************************************************************************
    //CONSULTA PARA LOS REPORTES DIARIOS Y SEMANALES 2
    function mostrarVisitasxDia($fecha) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg), u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, l.tipocultivo, c.codcliente, r.tipo, r.nota
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
                LEFT JOIN intralote as l ON l.codlote = r.codlotehuma		
		WHERE date(r.fecreg)='$fecha' GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, l.tipocultivo, c.codcliente ORDER BY fechavisita desc, u.desuse asc, horaingreso asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarVisitasxCodRep($codrep) {
        //                                                                                                                              8                                                                  13                               16
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg), u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, l.tipocultivo, c.codcliente, r.tipo, r.nota
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
                LEFT JOIN intralote as l ON l.codlote = r.codlotehuma		
		WHERE r.codrep ='$codrep' GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, l.tipocultivo, c.codcliente ORDER BY fechavisita desc, u.desuse asc, horaingreso asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function mostrarActividadesxCodRep($codrep) {
        $sql = "SELECT codigo, a.codempresa, e.descia, lugar, nomtitular, fecinicio, horainicio, horafin, descripcion, adjunto1, tactividad, fecreg
                FROM intraactividad AS a JOIN bhmcdb01 as e ON a.codempresa = e.codcia where codigo = '$codrep' order by fecinicio desc, nomtitular asc, horainicio asc";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function mostrarVisitasSemanalesxDia($fecha) {
        $sql = "SELECT r.codrep, r.fechavisita, date(r.fecreg) as fecregistro, u.desuse, c.nombre as cliente, r.contacto,  r.atendido, r.codfundo, horaingreso, horasalida, f.nombre as fundo, r.cultivo, r.coduse, l.tipocultivo, c.codcliente, r.tipo, r.nota
                FROM intrareportes as r JOIN intracliente as c ON r.codcliente = c.codcliente
                JOIN aausdb01 as u ON u.coduse = r.coduse 
                LEFT JOIN intrafundo as f ON f.codfundo = r.codfundo			
                LEFT JOIN intralote as l ON l.codlote = r.codlotehuma		
		WHERE date(r.fechavisita)='$fecha' GROUP BY r.codrep, u.desuse, c.nombre, f.nombre, l.tipocultivo, c.codcliente ORDER BY u.desuse asc, horaingreso asc, horasalida asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarActividadesxDia($fecha) {
        $sql = "SELECT codigo, a.codempresa, e.descia, lugar, nomtitular, fecinicio, horainicio, horafin, descripcion, adjunto1, tactividad
                FROM intraactividad AS a JOIN bhmcdb01 as e ON a.codempresa = e.codcia where date(fecreg) = '$fecha' order by fecinicio desc, nomtitular asc, horainicio asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function mostrarActividadesSemanalxDia($fecha) {
        $sql = "SELECT codigo, a.codempresa, e.descia, lugar, nomtitular, fecinicio, horainicio, horafin, descripcion, adjunto1, tactividad, a.fecreg
                FROM intraactividad AS a JOIN bhmcdb01 as e ON a.codempresa = e.codcia where date(fecinicio) = '$fecha' order by fecinicio desc, nomtitular asc, horainicio asc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getVisitasXDia($fecha) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg FROM intravisitas where date(fecreg) = '$fecha' order by coduse, horainicio;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getVisitasXSemana($fecha) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg FROM intravisitas where date(fecinicio) = '$fecha' order by coduse, horainicio;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //************* CONSULTAS DE VISITAS
    //QUERY01: CONSULTAR POR MES Y  AÑO
    function consultar_query01($mes, $ano, $asesor, $dias) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg 
                FROM intravisitas 
                WHERE extract(month from fecinicio) = '$mes' AND extract(year from fecinicio) = '$ano' AND coduse = '$asesor' AND date(fecinicio)= date(fecreg+'$dias')
                ORDER BY fecinicio asc, horainicio asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //QUERY02: CONSULTAR TODAS LAS VISITAS POR MES Y ANO
    function consultar_query02($mes, $ano, $asesor) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg 
                FROM intravisitas 
                WHERE extract(month from fecinicio) = '$mes' AND extract(year from fecinicio) = '$ano' AND coduse = '$asesor'
                ORDER BY fecinicio asc, horainicio asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //QUERY03: CONSULTAR VISITAS DE 4 O MÁS DIAS DE ATRASO
    function consultar_query03($mes, $ano, $asesor) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg 
                FROM intravisitas 
                WHERE extract(month from fecinicio) = '$mes' AND extract(year from fecinicio) = '$ano' AND coduse = '$asesor' AND date(fecinicio)<= date(fecreg+'-4 day')
                ORDER BY fecinicio asc, horainicio asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //QUERY04: CONSULTAR POR RANGO DE FECHA Y POR DIAS DE ATRASO DE 0 A 3 DIAS
    function consultar_query04($desde, $hasta, $asesor, $dias) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg 
                FROM intravisitas 
                WHERE date(fecinicio) BETWEEN '$desde' AND '$hasta' AND coduse = '$asesor' AND date(fecinicio)= date(fecreg+'$dias')
                ORDER BY fecinicio asc, horainicio asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //QUERY05: CONSULTAR TODAS LAS VISITAS POR RANGO DE FECHAS
    function consultar_query05($desde, $hasta, $asesor) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg 
                FROM intravisitas 
                WHERE date(fecinicio) BETWEEN '$desde' AND '$hasta' AND coduse = '$asesor'
                ORDER BY fecinicio asc, horainicio asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //QUERY06: CONSULTAR VISITAS DE 4 O MÁS DIAS DE ATRASO POR RANGO DE FECHAS
    function consultar_query06($desde, $hasta, $asesor) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg 
                FROM intravisitas 
                WHERE date(fecinicio) BETWEEN '$desde' AND '$hasta' AND coduse = '$asesor' AND date(fecinicio)<= date(fecreg+'-4 day')
                ORDER BY fecinicio asc, horainicio asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //QUERY GENERAL POR DIA
    function consultar_query_day($fecha, $asesor) {
        $sql = "SELECT codigo, fecinicio, horainicio, horafin, tipo, coduse, fecreg 
                FROM intravisitas 
                WHERE date(fecinicio) = '$fecha' AND coduse = '$asesor'
                ORDER BY fecinicio asc, horainicio asc;";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function ventasEnero2017() {
        $sql = "SELECT asesor, u.desuse, count(codprop) as cantidad, sum(monto) as total from propdb00 as p join aausdb01 as u ON u.coduse = p.asesor where date(p.fecreg) between '2017-01-01' and '2017-01-31' and aprobado = 'APROBADO' group by asesor, u.desuse  order by total desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    //Editar Reporte Comercial Modo Administrador
    function update_repcom_admin() {
        $sql = "UPDATE intrareportes SET "
                . "contacto = '$this->contacto', "
                . "fechavisita = '$this->fechavisita', "
                . "horaingreso = '$this->horaingreso',"
                . "horasalida = '$this->horasalida', "
                . "fecreg = '$this->fecreg', "
                . "fecmod = now(), "
                . "usemod = '$this->usemod' "
                . "WHERE codrep = '$this->codrep'; ";
        $result = $this->consultas($sql);
        return $result;
    }

    //SOLUCION PARA LA HORA CON UN DIGITO
    function arreglarHora($hora, $minuto) {
        $h = strlen($hora);
        $m = strlen($minuto);
        if ($h == 1) {
            $hora = '0' . $hora;
        }
        if ($m == 1) {
            $minuto = '0' . $minuto;
        }
        $resultado = $hora . ':' . $minuto;
        return $resultado;
    }

    function generarHoraActualizada($name, $class, $hora) {
        $hour = array('06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        $array_minutos = array('00', '15', '30', '45');

        $select = ' <select name="' . $name . '" id="' . $name . '" class="' . $class . '">
                        <option value="' . $hora . '">' . $hora . '</option>                            
                        <option value="' . $hora . '">..::Cambiar por</option>';
        for ($i = 0; $i < count($hour); $i++) {
            foreach ($array_minutos as $min) {
                $select .= '<option value="' . $hour[$i] . ':' . $min . '">' . $hour[$i] . ':' . $min . '</option>';
            }
        }
        $select .='</select>';
        return $select;
    }

    function getPropAprobDolarByMes($ano, $mes) {
        $sql = "SELECT asesor, u.desuse, count(codprop) as cantidad, sum(monto) as total "
                . "FROM propdb00 as p join aausdb01 as u ON u.coduse = p.asesor where extract(year from fecaprob)='$ano' and extract(month from fecaprob)='$mes' and aprobado = 'APROBADO' and moneda = '$' group by asesor, u.desuse  order by total desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

    function getPropAprobDolarByAsesorByAno($ano, $asesor) {
        $sql = "SELECT asesor, count(codprop) as cantidad, sum(monto) as total from propdb00 as p where extract(year from fecaprob)='$ano' and aprobado = 'APROBADO' and moneda = '$' and asesor = '$asesor' group by asesor  order by total desc";
        $result = $this->consultas($sql);
        $lista = $this->n_fila($result);
        return $lista;
    }

    function getPropAprobDolarByAno($ano) {
        $sql = "SELECT asesor, u.desuse, count(codprop) as cantidad, sum(monto) as total "
                . "FROM propdb00 as p JOIN aausdb01 as u  ON u.coduse = p.asesor where extract(year from fecaprob)='$ano' and aprobado = 'APROBADO' and moneda = '$' group by asesor, u.desuse order by total desc";
        $result = $this->consultas($sql);
        $lista = $this->n_Arreglo($result);
        return $lista;
    }

}
