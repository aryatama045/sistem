
  <div id="nav" class="nav-container d-flex">

    <div class="nav-content d-flex">

      <!-- Logo Start -->
      <div class="logo position-relative">
          <a href="<?= base_url('dashboard') ?>">
          <!-- Logo can be added directly -->
          <img src="https://www.aroleprindo.ac.id/wp-content/uploads/2014/10/Logo-ARO-LEPRINDO-white-e1567699964208.png" alt="logo" />

          </a>
      </div>
      <!-- Logo End -->

      <!-- Mobile Buttons Start -->
      <div class="mobile-buttons-container">
        <!-- Scrollspy Mobile Button Start -->
        <a href="#" id="scrollSpyButton" class="spy-button" data-bs-toggle="dropdown">
          <i data-acorn-icon="menu-dropdown"></i>
        </a>
        <!-- Scrollspy Mobile Button End -->

        <!-- Scrollspy Mobile Dropdown Start -->
        <div class="dropdown-menu dropdown-menu-end" id="scrollSpyDropdown"></div>
        <!-- Scrollspy Mobile Dropdown End -->

        <!-- Menu Button Start -->
        <a href="#" id="mobileMenuButton" class="menu-button">
          <i data-acorn-icon="menu"></i>
        </a>
        <!-- Menu Button End -->
      </div>
      <!-- Mobile Buttons End -->

    </div>

    <?php if($this->session->userdata('loginStatus') == TRUE){ ?>
    <div class="user-container d-flex">
      <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

        <?php if(!empty($pmb['foto_profil'])){ ?>
            <img src="<?= base_url('upload/berkas/'.$pmb['no_pendaftaran'].'/foto/'.$pmb['foto_profil']) ?>" class="profile" alt="profile" />
        <?php } else { ?>
            <img src="<?= base_url('assets/') ?>img/profile/profile.webp" class="profile" alt="profile" />
        <?php } ?>

        <div class="name"><?= capital($this->session->userdata('name')) ?></div>
      </a>
    <?php } ?>

      <div class="menu-container flex-grow-1">
          <ul id="menu" class="menu show">
          </ul>
      </div>

      <div class="dropdown-menu dropdown-menu-end user-menu wide" style="">
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
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-help me-2"><circle cx="10" cy="9.99997" r="3" transform="rotate(-135 10 9.99997)"></circle><path d="M3.63608 3.63602C4.41713 2.85497 5.68346 2.85497 6.46451 3.63602L7.87872 5.05023C8.65977 5.83128 8.65977 7.09761 7.87872 7.87866V7.87866C7.09767 8.6597 5.83134 8.6597 5.05029 7.87866L3.63608 6.46444C2.85503 5.68339 2.85503 4.41706 3.63608 3.63602V3.63602zM12.1214 12.1213C12.9025 11.3403 14.1688 11.3403 14.9499 12.1213L16.3641 13.5355C17.1451 14.3166 17.1451 15.5829 16.3641 16.3639V16.3639C15.583 17.145 14.3167 17.145 13.5356 16.3639L12.1214 14.9497C11.3404 14.1687 11.3404 12.9024 12.1214 12.1213V12.1213z"></path><path d="M5.93558 3.10715C9.00339 1.29528 13.021 1.70728 15.6569 4.34315C18.2927 6.97901 18.7047 10.9966 16.8929 14.0644M3.10715 5.93558C1.29528 9.00339 1.70728 13.021 4.34315 15.6569C6.97901 18.2927 10.9966 18.7047 14.0644 16.8929"></path><path d="M4.34326 15.6569L7.8788 12.1213M15.657 4.34315L12.1214 7.87869"></path></svg>
                  <span class="align-middle">Help</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-file-text me-2"><path d="M6.5 18H13.5C14.9045 18 15.6067 18 16.1111 17.6629C16.3295 17.517 16.517 17.3295 16.6629 17.1111C17 16.6067 17 15.9045 17 14.5V7.44975C17 6.83775 17 6.53175 16.9139 6.24786C16.8759 6.12249 16.8256 6.00117 16.7638 5.88563C16.624 5.62399 16.4076 5.40762 15.9749 4.97487L14.0251 3.02513L14.0251 3.02512C13.5924 2.59238 13.376 2.37601 13.1144 2.23616C12.9988 2.1744 12.8775 2.12415 12.7521 2.08612C12.4682 2 12.1622 2 11.5503 2H6.5C5.09554 2 4.39331 2 3.88886 2.33706C3.67048 2.48298 3.48298 2.67048 3.33706 2.88886C3 3.39331 3 4.09554 3 5.5V14.5C3 15.9045 3 16.6067 3.33706 17.1111C3.48298 17.3295 3.67048 17.517 3.88886 17.6629C4.39331 18 5.09554 18 6.5 18Z"></path><path d="M13 6 7 6M13 10 7 10M13 14 7 14"></path></svg>
                  <span class="align-middle">Docs</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-6 pe-1 ps-1">
            <ul class="list-unstyled">
              <li>
                <a href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-gear me-2"><path d="M8.32233 3.75427C8.52487 1.45662 11.776 1.3967 11.898 3.68836C11.9675 4.99415 13.2898 5.76859 14.4394 5.17678C16.4568 4.13815 18.0312 7.02423 16.1709 8.35098C15.111 9.10697 15.0829 10.7051 16.1171 11.4225C17.932 12.6815 16.2552 15.6275 14.273 14.6626C13.1434 14.1128 11.7931 14.9365 11.6777 16.2457C11.4751 18.5434 8.22404 18.6033 8.10202 16.3116C8.03249 15.0059 6.71017 14.2314 5.56062 14.8232C3.54318 15.8619 1.96879 12.9758 3.82906 11.649C4.88905 10.893 4.91709 9.29487 3.88295 8.57749C2.06805 7.31848 3.74476 4.37247 5.72705 5.33737C6.85656 5.88718 8.20692 5.06347 8.32233 3.75427Z"></path><path d="M10 8C11.1046 8 12 8.89543 12 10V10C12 11.1046 11.1046 12 10 12V12C8.89543 12 8 11.1046 8 10V10C8 8.89543 8.89543 8 10 8V8Z"></path></svg>
                  <span class="align-middle">Settings</span>
                </a>
              </li>
              <li>
                <a href="<?= base_url('login/logout'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-logout me-2"><path d="M7 15 2.35355 10.3536C2.15829 10.1583 2.15829 9.84171 2.35355 9.64645L7 5M3 10H13M12 18 14.5 18C15.9045 18 16.6067 18 17.1111 17.6629 17.3295 17.517 17.517 17.3295 17.6629 17.1111 18 16.6067 18 15.9045 18 14.5L18 5.5C18 4.09554 18 3.39331 17.6629 2.88886 17.517 2.67048 17.3295 2.48298 17.1111 2.33706 16.6067 2 15.9045 2 14.5 2L12 2"></path></svg>
                  <span class="align-middle">Logout</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>


    <div class="nav-shadow"></div>

  </div>