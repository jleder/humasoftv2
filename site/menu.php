<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
$menu = new Menu();
?>
<ul class="nav main-menu">
    <li>
        <a href="Dashboard.php">
            <i class="fa fa-dashboard"></i>
            <span class="hidden-xs">DASHBOARD</span>
        </a>
    </li>

    <?php
    $listMenu1 = $menu->getMenu($_SESSION['usuario'], '2', 1);
    foreach ($listMenu1 as $menu1) {
        $codpadre1 = $menu1['codigo'];
        ?>
        <li class="dropdown"> 
            <a href="#" class="dropdown-toggle">
                <i class="<?php echo $menu1['icono'] ?>"></i>
                <span class="hidden-xs"><?php echo $menu1['nombre']; ?></span>
            </a>
            <ul class="dropdown-menu">
                <?php
                $listMenu2 = $menu->getMenu($_SESSION['usuario'], '3', $codpadre1);
                foreach ($listMenu2 as $menu2) {

                    if ($menu2['es_padre'] == 'f') {
                        echo '<li><a href="' . trim($menu2['ruta']) . '">' . trim($menu2['nombre']) . '</a></li>';
                    } else {
                        ?>
                        <li class="dropdown">                                                        
                            <a href="#" class="dropdown-toggle">                                                
                                <i class="<?php echo $menu2['icono']; ?>"></i>
                                <span class="hidden-xs"><?php echo $menu2['nombre']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                $codpadre2 = $menu2['codigo'];
                                $listMenu3 = $menu->getMenu($_SESSION['usuario'], '4', $codpadre2);
                                foreach ($listMenu3 as $menu3) {
//                                    echo '<li><a class="ajax-link" href="' . $menu3['ruta'] . '">' . $menu3['nombre'] . '</a></li>';
                                    echo '<li><a href="' . $menu3['ruta'] . '">' . $menu3['nombre'] . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </li>
    <?php } ?>                                
</ul>