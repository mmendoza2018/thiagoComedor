<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <!-- sidebar-brand  -->
        <div class="text-center">
            <a href="menu.php" id="index" class="my-2 text-center"><img src="assets/img/logo.png" class="mx-auto img-fluid mt-1" alt="gyt"></a>
        </div>
        <!-- sidebar-header  -->
        <div class="sidebar-item sidebar-header d-flex flex-nowrap">
            <div class="user-pic">
                <img class="img-responsive img-rounded mx-2 mt-0" src="assets/plugins/sidebar/src/img/user.jpg" with="80" alt="User picture">
            </div>
            <div class="user-info">
                <span class="user-name">
                    <strong><?php echo $_SESSION["datos_trabajador"][0]["nombres"] ?></strong>
                </span>
                <!-- <span class="user-role">Administrator</span> -->
            </div>
        </div>
        <!-- sidebar-menu  -->
        <div class="sidebar-item sidebar-menu">
            <ul>
                <li class="header-menu"><span>General</span></li>
                <li class="sidebar-dropdown active">
                    <a href="#">
                    <i class="fas fa-donate"></i>
                        <span class="menu-text">ORDENES DE PEDIDO</span>
                        <span class="badge badge-pill badge-warning">New</span>
                    </a>
                    <div class="sidebar-submenu" style="display: block;">
                        <ul>
                            <li><a href="#" id="btnFormComensales">Comensales</a></li>
                            <li><a href="#" id="btnRegistroVentas">Registro Ventas</a></li>
                            <li><a href="#" id="btnlistadoVentas">Listado Ventas</a></li>
                            <li><a href="#" id="btnEstadisticas">Estadisticas</a></li>
                            <li><a href="#" id="btnlectorQr">lector</a></li>
                            <li><a href="#" id="btnPrueba">Prueba</a></li>
                        </ul>
                    </div>
                </li>
                <li class="header-menu">
                    <span>Mantenimientos</span>
                </li>
                <!-- <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="fas fa-truck-monster"></i>
                        <span class="menu-text">Equipos</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li><a href="#" id="AlertasDocEquipo">Alertas doc. equipos</a></li>
                            <li class="sidebar-dropdown-child">
                                <a href="#"><span class="menu-text2">Informacion general</span> </a>
                                <div class="sidebar-submenu-child" style="display: none;">
                                    <ul>
                                    <li><a href="#" id="marca">Marcas</a></li>
                                    <li><a href="#" id="modelo">Modelos</a></li>
                                    <li><a href="#" id="familia">Familias</a></li>
                                    <li><a href="#" id="propietario">Propietarios</a></li>
                                    <li><a href="#" id="tipoDocEquipo">Tipos documentos</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="sidebar-dropdown-child d-none">
                                <a href="#" tyle="pointer-events: none; display: inline-block;"><span class="menu-text2">Información mecanica</span> </a>
                                <div class="sidebar-submenu-child" style="display: none;">
                                    <ul>
                                        <li><a href="#" id="tipoSisEquipo">Tipo sistema</a></li>
                                        <li><a href="#" id="sistemaEquipo">sistema equipo</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li> -->
            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-footer  -->
    <div class="sidebar-footer">
        <div class="dropdown ">
            <!-- show -->

            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <a href="php/cerrar_sesion.php" class="text-danger"><i class="fas fa-reply-all"></i></a>
            </a>
           
            <!-- <div class="dropdown-menu notifications" aria-labelledby="dropdownMenuMessage">
                <div class="notifications-header">
                    <a href="php/cerrar_sesion.php" class="text-danger"><i class=""></i></a>
                </div>
                <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="#">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas fa-check text-success border border-success"></i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. In totam explicabo</div>
                            <div class="notification-time">
                                6 minutes ago
                            </div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas fa-exclamation text-info border border-info">a</i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. In totam explicabo</div>
                            <div class="notification-time">
                                Today
                            </div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="notification-content">
                        <div class="icon">
                            <i class='bx bxs-like bx-tada'></i>fsdf
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. In totam explicabo</div>
                            <div class="notification-time">
                                Yesterday
                            </div>
                        </div>
                    </div>
                </a> 
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="#">View all notifications</a>
            </div> -->
        </div>
        <div class="dropdown">
            <!-- <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-envelope"></i>
                <span class="badge badge-pill badge-success notification">7</span>
            </a> -->
            <div class="dropdown-menu messages" aria-labelledby="dropdownMenuMessage">
                <!-- <div class="messages-header">
                    <i class="fa fa-envelope"></i>
                    Messages
                </div> -->
                <!-- <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <div class="message-content">
                        <div class="pic">
                        </div>
                        <div class="content">
                            <div class="message-title">
                                <strong> Jhon doe</strong>
                            </div>
                            <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. In totam explicabo</div>
                        </div>
                    </div>

                </a> -->
                <!-- <a class="dropdown-item" href="#">
                    <div class="message-content">
                        <div class="pic">
                        </div>
                        <div class="content">
                            <div class="message-title">
                                <strong> Jhon doe</strong>
                            </div>
                            <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. In totam explicabo</div>
                        </div>
                    </div>

                </a> -->
                <!-- <a class="dropdown-item" href="#">
                    <div class="message-content">
                        <div class="pic">
                        </div>
                        <div class="content">
                            <div class="message-title">
                                <strong> Jhon doe</strong>
                            </div>
                            <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit. In totam explicabo</div>
                        </div>
                    </div>
                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="#">View all messages</a>

            </div>
        </div>
        <div class="dropdown">
            <!--  <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cog"></i>
                <span class="badge-sonar"></span>
            </a> -->
            <div class="dropdown-menu" aria-labelledby="dropdownMenuMessage">
                <a class="dropdown-item" href="#">My profile</a>
                <a class="dropdown-item" href="#">Help</a>
                <a class="dropdown-item" href="#">Setting</a>
            </div>
        </div>
    <!--     <div>
            <a id="pin-sidebar" class="pt-1" href="#"> <i class="fas fa-caret-left fa-2x"></i></a>
        </div> -->
        <div class="pinned-footer">
            <a href="#">
                <i class="fas fa-caret-right fa-2x"></i>
                <!-- <i class="far fa-stop-circle"></i> -->
            </a>
        </div>
    </div>
</nav>