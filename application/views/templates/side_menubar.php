

<div id="nav" class="nav-container d-flex">
    <div class="nav-content d-flex">
        <!-- Logo Start -->
        <div class="logo position-relative">
            <a href="<?= base_url('dashboard') ?>">
            <!-- Logo can be added directly -->
            <img src="https://www.aroleprindo.ac.id/wp-content/uploads/2014/10/Logo-ARO-LEPRINDO-white-e1567699964208.png" alt="logo" />

            <!-- Or added via css to provide different ones for different color themes -->
            <!-- <div class="img"></div> -->
            </a>
        </div>
        <!-- Logo End -->

        <!-- User Menu Start -->
        <div class="user-container d-flex">
            <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="profile" alt="profile" src="<?= base_url('assets/') ?>img/profile/profile-1.webp" />
                <div class="name">ADIMAS SATRIO PRASIDA</div>
            </a>
            <div class="dropdown-menu dropdown-menu-end user-menu wide">
                <div class="row mb-3 ms-0 me-0">
                    <div class="col-12 ps-1 mb-2">
                        <div class="text-extra-small text-primary">ACCOUNT</div>
                    </div>
                    <div class="col-6 ps-1 pe-1">
                        <ul class="list-unstyled">
                            <li>
                            <a href="#">User Info</a>
                            </li>
                            <li>
                            <a href="#">Preferences</a>
                            </li>
                            <li>
                            <a href="#">Calendar</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 pe-1 ps-1">
                        <ul class="list-unstyled">
                            <li>
                            <a href="#">Security</a>
                            </li>
                            <li>
                            <a href="#">Billing</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mb-1 ms-0 me-0">
                    <div class="col-12 p-1 mb-2 pt-2">
                    <div class="text-extra-small text-primary">APPLICATION</div>
                    </div>
                    <div class="col-6 ps-1 pe-1">
                    <ul class="list-unstyled">
                        <li>
                        <a href="#">Themes</a>
                        </li>
                        <li>
                        <a href="#">Language</a>
                        </li>
                    </ul>
                    </div>
                    <div class="col-6 pe-1 ps-1">
                    <ul class="list-unstyled">
                        <li>
                        <a href="#">Devices</a>
                        </li>
                        <li>
                        <a href="#">Storage</a>
                        </li>
                    </ul>
                    </div>
                </div>
                <div class="row mb-1 ms-0 me-0">
                    <div class="col-12 p-1 mb-3 pt-3">
                    <div class="separator-light"></div>
                    </div>
                    <div class="col-6 ps-1 pe-1">
                    <ul class="list-unstyled">
                        <li>
                        <a href="#">
                            <i data-acorn-icon="help" class="me-2" data-acorn-size="17"></i>
                            <span class="align-middle">Help</span>
                        </a>
                        </li>
                        <li>
                        <a href="#">
                            <i data-acorn-icon="file-text" class="me-2" data-acorn-size="17"></i>
                            <span class="align-middle">Docs</span>
                        </a>
                        </li>
                    </ul>
                    </div>
                    <div class="col-6 pe-1 ps-1">
                    <ul class="list-unstyled">
                        <li>
                        <a href="#">
                            <i data-acorn-icon="gear" class="me-2" data-acorn-size="17"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                        </li>
                        <li>
                        <a href="#">
                            <i data-acorn-icon="logout" class="me-2" data-acorn-size="17"></i>
                            <span class="align-middle">Logout</span>
                        </a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- User Menu End -->

        <!-- Icons Menu Start -->
        <ul class="list-unstyled list-inline text-center menu-icons">

            <li class="list-inline-item">
                <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">
                    <i data-acorn-icon="search" data-acorn-size="18"></i>
                </a>
            </li>

            <li class="list-inline-item">
                <a href="#" id="pinButton" class="pin-button">
                    <i data-acorn-icon="lock-on" class="unpin" data-acorn-size="18"></i>
                    <i data-acorn-icon="lock-off" class="pin" data-acorn-size="18"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" id="colorButton">
                    <i data-acorn-icon="light-on" class="light" data-acorn-size="18"></i>
                    <i data-acorn-icon="light-off" class="dark" data-acorn-size="18"></i>
                </a>
            </li>

            <li>
                <a href="<?= base_url('login/logout'); ?>">
                    <i data-acorn-icon="logout" class="me-2" data-acorn-size="17" title="Logout"></i>
                </a>
            </li>


        </ul>
        <!-- Icons Menu End -->

        <!-- Menu Start -->
        <div class="menu-container flex-grow-1">
            <?php echo $menu ?>
        </div>
        <!-- Menu End -->

        <!-- Mobile Buttons Start -->
        <div class="mobile-buttons-container">
            <!-- Menu Button Start -->
            <a href="#" id="mobileMenuButton" class="menu-button">
                <i data-acorn-icon="menu"></i>
            </a>
            <!-- Menu Button End -->
        </div>
        <!-- Mobile Buttons End -->
    </div>

    <div class="nav-shadow"></div>
</div>