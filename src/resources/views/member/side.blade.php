<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-item has-treeview">
                <a href="{{ url('/member') }}" class="nav-link @if ($__env->yieldContent('active_menu_parent') === 'company') active @endif"
                    >
                    <i class="nav-icon fas fa-building fa-3x"></i>
                    <p>企業管理</p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="{{ url('/member') }}/matching/" class="nav-link @if ($__env->yieldContent('active_menu_parent') === 'matching') active @endif" >
                    <i class="nav-icon fas fa-handshake fa-3x"></i>
                    <p>案件管理</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
