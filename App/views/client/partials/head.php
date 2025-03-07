<header style="background-color:rgb(120, 199, 255);">
    <div class="container-xl">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <a class="navbar-brand fs-3" href="/">IT CV</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item" style="margin-bottom: 0px">
                            <a class="nav-link" href="/jobs">Jobs</a>
                        </li>
                        <li class="nav-item" style="margin-bottom: 0px">
                            <a class="nav-link" href="/companies">Công Ty</a>
                        </li>
                    </ul>

                </div>
                <?php

                use Framework\Auth;

                if (Auth::check()) {

                    $user = Auth::user();
                ?>
                    <div class="dropdown">
                        <button class="btn bbtn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hi <?= $user['name']; ?>
                        </button>
                        <ul class="dropdown-menu">
                            <?php if ($user['role_name'] === 'Admin'){ ?>
                                <li><a href="/admin-panel/dashboard" class="dropdown-item">Quản trị</a></li>
                            <?php } else if($user['role_name'] === 'HR'){ ?>
                                <li><a href="/admin-panel/resumes" class="dropdown-item">Quản lý CV</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <form action="/auth/logout" method="POST">
                                <li><button class="dropdown-item">Đăng xuất</button></li>
                            </form>

                        </ul>
                    </div>
                <?php } else { ?>
                    <a class="btn btn-primary" href="/auth/login">Đăng nhập/Đăng ký</a>
                <?php } ?>
            </div>
        </nav>
    </div>
</header>