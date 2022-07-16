
<div class="container-fluid">
    <div class="row flex-nowrap">
        <nav class="col-auto bg-light sidebar">
            <div class="min-vh-100">
                <ul class="nav flex-column" id="menu">
                    <li class="nav-item my-2">
                        <a href="{{ route('admin.applications') }}" class="nav-link active">
                            <i class="fa-solid fa-browser"></i>
                            Applications
                        </a>
                    </li>
                    <li class="nav-item m-2">
                        <a href="{{ route('admin.logout') }}" class="nav-link">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="col">
            {{ $slot }}
        </div>
    </div>
</div>
