<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('admin.works') }}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-briefcase"></i>
                <p>
                    Examples work
                    <span class="right badge badge-info">New</span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.menu') }}" class="nav-link">
                <i class="nav-icon fas fa-link"></i>
                <p>Menu</p>
            </a>
        </li>
        <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
            Forms
            <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="pages/forms/general.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>General Elements</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="pages/forms/advanced.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Advanced Elements</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="pages/forms/editors.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Editors</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="pages/forms/validation.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Validation</p>
            </a>
            </li>
        </ul>
        </li>
    </ul>
</nav>