<?php $menus = $this->userpermission->menus();?>

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <div class="pcoded-navigatio-lavel" >Navigation <?php echo $this->router->fetch_class(); ?></div>
                <ul class="pcoded-item pcoded-left-item">
                    <?php foreach($menus as $menu):
                       
                        if(isset($menu->children)){
                            $class = "pcoded-hasmenu";
                            $link = "javascript:void(0)";
                        } else {
                            $class = "active pcoded-trigger";
                            $link = base_url()."admin/".$menu->slink;
                        }
                    ?>
                    <li class="<?php echo $class;?>">
                        <a href="<?php echo $link;?>">
                            <span class="pcoded-micon"><i class="<?php echo $menu->icon;?>"></i></span>
                            <span class="pcoded-mtext">
                                <?php echo $menu->menu_name;?>
                                <?php if(isset($menu->count)){ ?>
                                <span class="badge badge-info">
                                    <?php echo $menu->count;?>
                                </span>
                                <?php } ?>
                            </span>
                        </a>
                        <?php if(isset($menu->children)){ ?>
                        <ul class="pcoded-submenu">
                            <?php foreach($menu->children as $sub):?>
                            <li class=" ">
                                <a href="<?php echo base_url()."admin/".$sub->slink;?>">
                                    <span class="pcoded-mtext">
                                        <?php echo $sub->menu_name;?>
                                        <?php if(isset($sub->count)){ ?>
                                        <span class="badge badge-info">
                                            <?php echo $sub->count;?>
                                        </span>
                                        <?php } ?>
                                    </span>
                                </a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php endforeach;?>		
                </ul>
            </div>
        </nav>