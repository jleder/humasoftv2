<style>
    .x_content {
        padding: 0 5px 6px;
        position: relative;
        width: 100%;
        float: left;
        clear: both;
        margin-top: 5px;
    }

    ul.msg_list li {
        background: #f7f7f7;
        padding: 5px;
        display: flex;
        margin: 6px 6px 0;
        width: 96% !important;
    }
    ul.msg_list li:last-child {
        margin-bottom: 6px;
        padding: 10px;
    }
    ul.msg_list li p {
        padding: 3px 5px !important;                            
    }
    ul.msg_list li p .image img {
        border-radius: 2px 2px 2px 2px;
        -webkit-border-radius: 2px 2px 2px 2px;
        float: left;
        margin-right: 10px;
        width: 11%;
    }
    ul.msg_list li p .time {
        font-size: 11px;
        font-style: italic;
        font-weight: bold;
        position: absolute;
        right: 35px;
    }
    ul.msg_list li p .message {
        display: block !important;
        font-size: 11px;
    }
    .dropdown-menu.msg_list span {
        white-space: normal;
    }

    .navbar-nav .open .dropdown-menu.msg_list {
        width: 300px;
    }

    .thumbnail .image {
        height: 120px;
        overflow: hidden;
    }

    .product-image img {
        width: 90%;
    }

    ul.msg_list li p .time {
        font-size: 11px;
        font-style: italic;
        font-weight: bold;
        position: absolute;
        right: 35px;
    }

    ul.msg_list li p .message {
        display: block !important;
        font-size: 11px;
    }


</style>  

<?php
include_once '../controller/C_Propuestas.php';

$pro = new C_Propuesta();

$coditem = $_GET['coditem'];
$corredor = $_GET['corredor'];
?>
<h4>Comentarios</h4>
<div class="x_content">
    <ul class="list-unstyled msg_list">
        <?php
        $pro->__set('coditem', $coditem);
        $comentarios = $pro->getComentariosByCodItem();
        if (count($comentarios) > 0) {
            foreach ($comentarios as $comment) {
                ?>


                <li>
                    <p>
                        <span class="image">
                            <img src="img/usuarios/<?php echo $comment['imagen']; ?>" alt="img" />
                        </span>
                        <span>
                            <span><?php echo $comment["desuse"]; ?></span>
                            <span class="time"><?php echo date("d/m/y h:i", strtotime($comment["fecreg"])); ?></span>
                        </span>
                        <span class="message">                                                                                                
                            <?php echo $comment["comentario"]; ?>                                                                                                
                            <span class="time"><button onclick="delete_comentario('<?php echo $coditem; ?>', '<?php echo $corredor; ?>', '<?php echo $comment["codigo"]; ?>')" type="button" class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span></button></span>
                        </span>                                                                                            
                    </p>
                </li>                                                                                    
                <?php
            }
        } else {
            echo '<span class="alert alert-primary">No se encontraron comentarios.</span>';
        }
        ?>
    </ul>
</div>

