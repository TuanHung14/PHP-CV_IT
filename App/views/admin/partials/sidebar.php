<?php

use Framework\Template; ?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="navbar-brand fs-3" href="/">IT CV</a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                    </div>
                    <div class="profile-name">
                        <!-- <h5 class="mb-0 font-weight-normal"> Klein</h5> -->
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <?php
            $content = '
                      <a class="nav-link" href="/admin-panel/dashboard">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                ';
            echo Template::can('view_dashboard', $content);
            ?>
        </li>
        <li class="nav-item menu-items">
            <?php
            $content = '
                     <a class="nav-link" data-bs-toggle="collapse" href="#companies" aria-expanded="false" aria-controls="companies">
                        <span class="menu-icon">
                            <i class="fa fa-institution"></i>
                        </span>
                        <span class="menu-title">Companies</span>
                         <i class="menu-arrow"></i>
                    </a>
                ';
            echo Template::can('view_companies', $content);
            ?>

            <div class="collapse" id="companies">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/admin-panel/company">Danh sách</a></li>
                    <?php
                    $content = '<li class="nav-item"> <a class="nav-link" href="/admin-panel/company/create">Thêm công ty</a></li>';
                    echo Template::can('create_companies', $content);
                    ?>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <?php
            $content = '<a class="nav-link" data-bs-toggle="collapse" href="#skill" aria-expanded="false" aria-controls="skill">
                            <span class="menu-icon">
                                <i class="fa fa-flash"></i>
                            </span>
                            <span class="menu-title">Skill</span>
                            <i class="menu-arrow"></i>
                        </a>';
            echo Template::can('view_skills', $content);
            ?>

            <div class="collapse" id="skill">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/admin-panel/skills">Danh sách</a></li>
                    <?php
                    $content = '<li class="nav-item"> <a class="nav-link" href="/admin-panel/skill/create">Thêm kỹ năng</a></li>';
                    echo Template::can('create_skills', $content);
                    ?>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <?php
            $content = ' <a class="nav-link" data-bs-toggle="collapse" href="#job" aria-expanded="false" aria-controls="job">
                            <span class="menu-icon">
                                <i class="fa fa-suitcase"></i>
                            </span>
                            <span class="menu-title">Jobs</span>
                            <i class="menu-arrow"></i>
                        </a>';
            echo Template::can('view_jobs', $content);
            ?>

            <div class="collapse" id="job">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/admin-panel/jobs">Danh sách</a></li>
                    <?php
                    $content = '<li class="nav-item"> <a class="nav-link" href="/admin-panel/job/create">Thêm công việc</a></li>';
                    echo Template::can('create_jobs', $content);
                    ?>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <?php
            $content = '<a class="nav-link" data-bs-toggle="collapse" href="#post_job" aria-expanded="false" aria-controls="job">
                            <span class="menu-icon">
                                <i class="fa fa-suitcase"></i>
                            </span>
                            <span class="menu-title">Post Jobs</span>
                            <i class="menu-arrow"></i>
                        </a>';
            echo Template::can('view_post_jobs', $content);
            ?>
            <div class="collapse" id="post_job">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/admin-panel/post_jobs">Danh sách</a></li>
                    <?php
                    $content = '<li class="nav-item"> <a class="nav-link" href="/admin-panel/post_job/create">Thêm bài đăng công việc</a></li>';
                    echo Template::can('create_post_jobs', $content);
                    ?>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <?php
            $content = ' <a class="nav-link" href="/admin-panel/users">
                            <span class="menu-icon">
                                <i class="mdi mdi-contacts"></i>
                            </span>
                            <span class="menu-title">Users</span>
                            <i class="menu-arrow"></i>
                        </a>';
            echo Template::can('view_users', $content);
            ?>

        </li>
        <li class="nav-item menu-items">
            <?php
            $content = ' <a class="nav-link" href="/admin-panel/resumes">
                            <span class="menu-icon">
                                <i class="mdi mdi-contacts"></i>
                            </span>
                            <span class="menu-title">Resumes</span>
                            <i class="menu-arrow"></i>
                        </a>';
            echo Template::can('view_resumes', $content);
            ?>

        </li>
        <li class="nav-item menu-items">
            <?php
            $content = '<a class="nav-link" data-bs-toggle="collapse" href="#permission" aria-expanded="false"
                            aria-controls="permission">
                            <span class="menu-icon">
                                <i class="fa fa-group"></i>
                            </span>
                            <span class="menu-title">Permissions</span>
                            <i class="menu-arrow"></i>
                        </a>';
            echo Template::can('view_permissions', $content);
            ?>

            <div class="collapse" id="permission">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/admin-panel/permissions">Danh sách</a></li>
                    <?php
                    $content = '<li class="nav-item"> <a class="nav-link" href="/admin-panel/permission/create">Thêm quyền</a></li>';
                    echo Template::can('create_permissions', $content);
                    ?>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <?php
            $content = '<a class="nav-link" data-bs-toggle="collapse" href="#role" aria-expanded="false" aria-controls="role">
                            <span class="menu-icon">
                                <i class="fa fa-group"></i>
                            </span>
                            <span class="menu-title">roles</span>
                            <i class="menu-arrow"></i>
                        </a>';
            echo Template::can('view_roles', $content);
            ?>

            <div class="collapse" id="role">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/admin-panel/roles">Danh sách</a></li>
                    <?php
                    $content = '<li class="nav-item"> <a class="nav-link" href="/admin-panel/role/create">Thêm role</a></li>';
                    echo Template::can('create_roles', $content);
                    ?>
                </ul>
            </div>
        </li>

    </ul>
</nav>