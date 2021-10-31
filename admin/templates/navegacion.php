  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENÚ PRINCIPAL</li>

        <!-- DASHBOARD -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard</a></li>
          </ul>
        </li>

        <!-- EVENTOS -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Eventos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <!-- <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span> -->
          </a>
          <ul class="treeview-menu">
            <li><a href="lista-evento.php"><i class="fa fa-list-alt"></i>Ver Todos</a></li>
            <li><a href="crear-evento.php"><i class="fa fa-plus-square"></i>Agregar</a></li>
          </ul>
        </li>

        <!-- CATEGORÍA EVENTOS -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Categoría Eventos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="lista-categoria.php"><i class="fa fa-list-alt"></i>Ver Todos</a></li>
            <li><a href="crear-categoria.php"><i class="fa fa-plus-square"></i>Agregar</a></li>
          </ul>
        </li>


        <!-- INVITADOS -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-o"></i>
            <span>Invitados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="lista-invitados.php"><i class="fa fa-list-alt"></i>Ver Todos</a></li>
            <li><a href="crear-invitado.php"><i class="fa fa-plus-square"></i>Agregar</a></li>
          </ul>
        </li>

        <!-- REGISTRADOS -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-address-book-o"></i>
            <span>Registrados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="lista-registrados.php"><i class="fa fa-list-alt"></i>Ver Todos</a></li>
            <li><a href="crear-registrados.php"><i class="fa fa-plus-square"></i>Agregar</a></li>
          </ul>
        </li>

        <!-- ADMINISTRADORES -->
        <!-- Esta seccion solo la pueden ver los administradores,su nivel es el 1 -->
        <?php if($_SESSION['nivel'] == 1) :?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-unlock-alt"></i>
            <span>Administradores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="lista-admin.php"><i class="fa fa-list-alt"></i>Ver Todos</a></li>
            <li><a href="crear-admin.php"><i class="fa fa-plus-square"></i>Agregar</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- TESTIMONIALES -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-comments-o"></i>
            <span>Testimoniales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-list-alt"></i>Ver Todos</a></li>
            <li><a href="#"><i class="fa fa-plus-square"></i>Agregar</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>