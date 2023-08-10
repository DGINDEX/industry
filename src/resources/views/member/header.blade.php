<?php
use Illuminate\Support\Facades\Auth; ?>

<!-- Sidebar toggle button-->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <!-- Notifications Dropdown Menu -->

</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-user"></span>&nbsp;{{ Auth::check() ? Auth::user()->company->company_name : null }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a href="{{ url('/member') }}" class="dropdown-item">
                企業詳細
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ url('/member') }}/logout/" class="dropdown-item">ログアウト</a>
        </div>
    </li>

</ul>
