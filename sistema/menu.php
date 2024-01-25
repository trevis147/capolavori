<style type="text/css">
    #navbar {
        box-shadow: none;
    }
    .main-container {
        margin-top: 110px;
    }
    #sidebar h4 {
        padding: 11px 8px;
        background-color: #333;
        color: #fff;
        height: 40px;
        font-size: 15px;    
        margin-bottom: 0;
        position: relative;
        padding-left: 50px;
    }
    #sidebar h4 i {
        color: #fff;
        height: 40px;
        width: 40px;
        position: absolute;
        top: 0;
        left: 0;
        background-color: #000;
        text-align: center;
        line-height: 40px;
    }
    #sidebar.menu-min h4 span {
        display: none;
    }
    #sidebar .nav.nav-list {
        margin-bottom: 15px;
    }    
    #sidebar .nav.nav-list li:last-child {
        border-bottom: 2px solid #d3d3d3;
    }
    .nav-list>li:hover:before {
        display: none;
    }
    .nav.nav-list:first-of-type h4 {
        margin-top: 0;
    }
</style>

<div id="sidebar" class="sidebar responsive">
    <?php     
        $q = Query('SELECT * FROM grupo_menu WHERE Ativo = 1 AND Grupo_menu IN (SELECT DISTINCT(Grupo_menu) from menu_sistema WHERE Ativo = 1) ORDER BY Titulo ASC',0);
        if(mysqli_num_rows($q) > 0){
           while($grupo = mysqli_fetch_assoc($q)){
    ?>
        <ul class="nav nav-list">
            <h4>
                <i class="fa fa-home"></i>
                <span><?php echo $grupo['Titulo']     ?></span>
            </h4>
            <?php     
                $q_menu = Query('SELECT * FROM menu_sistema WHERE Grupo_menu = '.$grupo['Grupo_menu'].' AND Ativo = 1 ORDER BY Titulo ASC',0);
                while($r = mysqli_fetch_assoc($q_menu)){ 
            ?>
                <li>
                    <a href="<?php  echo $Config['Url'];  ?>registros.php?1=<?php echo $r['Titulo'];   ?>">
                        <span class="menu-text"><?php echo ucfirst(str_replace('_',' ',$r['Rotulo'])); ?></span>
                    </a>
                </li> 
            <?php  }  ?>
        </ul>
    <?php   } }  ?>
     

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>