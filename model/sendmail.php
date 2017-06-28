<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$codprop = 'ABGC-VI-011116-V01';
require '../site/PHPMailer/class.phpmailer.php';
$mail = new PHPMailer();
$body = bodymail_propinsert_gerente($codprop);
$mailremite = $_SESSION['email_usuario'];
$nomremite = $_SESSION['nombreUsuario'];
$mail->From = "$mailremite";
$mail->FromName = "$nomremite";
$mail->Subject = 'PROPUESTA REGISTRADA NÚMERO: ' . $codprop;
$mail->Body = $body;
$mail->IsHTML(true);
//$mail->addAddress('aprobaciones@humagroperu.com', "Salvador Giha");
$mail->addAddress('sistemas@humagroperu.com', "Juan Leder"); //Copia oculta
//$mail->addBCC('juanleder@gmail.com', "Juan Led");        
if($mail->Send()){
    echo 'se fue';
}else {
    echo 'no se fue';
}

function bodymail_propinsert_gerente($codprop) {
        $url1 = 'http://humagroperu.ddns.net:8070/humasoft/site/_propuestav2_aprob02_verweb.php?cod=' . $codprop;
        $url2 = 'http://humagroperu.ddns.net:8070/humasoft/site/_propuestav2.web.php';
        
        $body = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Propuesta Registrada</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">                    
                    <style>
                        #contenedor { margin: auto; width: 70%;}
                        #heading{ background-color: #161716; color: #fafafa; padding: 6px;}
                        #body {background: #d9e7dd; padding: 20px; font-family: sans-serif; }
                        .text_titulo { font-size: 12px; font-weight: bolder; font-family: cursive;}
                        .btn { font-size: 12px; padding-left: 10px; padding-top: 10px; color: white; background-color: #46a45d; font-family: "Source Sans Pro", sans-serif; text-decoration: none; text-align: center;}            
                    </style>
                </head>
                <body>
                    <div id="contenedor">
                        <div id="heading">            
                                <br/>
                            <p class="text_titulo">
                                <span style="font-size: 20px;">HUMA GRO PERU</span><br/>
                                AGRO MICRO BIOTECH SAC
                            </p>
                        </div>
                        <div id="body">                            
                            ¡Felicitaciones! La Propuesta Nro: ' . $codprop . ', fue registrada con éxito.                            
                            <div>
                                <br/>
                                <a href="'.$url2.'" target="_blank" class="btn">LISTAR PROPUESTAS</a>  <a href="'.$url1.'" target="_blank" class="btn">VER PROPUESTA</a>
                            </div>
                        </div>            
                    </div>                            
                </body>
            </html>';
        return $body;
    }