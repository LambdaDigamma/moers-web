<div class="sidebar" data-color="azure" data-background-color="danger">
    <div class="logo">
        <a href="" class="simple-text logo-normal">
            Mein Moers
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {{ (Request::is('*dashboard*') ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('admin') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ (Request::is('*users*') ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('entrust-gui::users.index') }}">
                    <i class="material-icons">people</i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item {{ (Request::is('*roles*') ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('entrust-gui::roles.index') }}">
                    <i class="material-icons">label</i>
                    <p>Roles</p>
                </a>
            </li>
            <li class="nav-item {{ (Request::is('*permissions*') ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('entrust-gui::permissions.index') }}">
                    <i class="material-icons">build</i>
                    <p>Permissions</p>
                </a>
            </li>
        </ul>
    </div>
</div>