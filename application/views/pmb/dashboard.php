<div class="row">

    <?php include_once('profile_menu.php') ?>

        <!-- Right Side Start -->
        <div class="col-12 col-xl-8 col-xxl-9 mb-5 tab-content">
            <!-- Overview Tab Start -->
            <div class="tab-pane fade show active" id="statusTerkiniTab" role="tabpanel">

              <div class="card mb-5">
                  <div class="card-body">
                      <!-- Greeting -->
                      <h2> Selamat Datang, <?= capital($this->session->userdata('name')); ?></h2>
                      <p>Lanjutkan proses pendaftaran dengan mengisi data diri anda secara lengkap dan melakukan upload berkas.</p>

                      <hr class="mb-2">

                      <!-- Status Terkini Dots -->
                      <div class="border-0 pb-0 wizard mt-5 mb-5" id="wizardBasic">
                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                          <li class="nav-item" role="presentation">
                            <a class="nav-link text-center" role="tab" data-index="1" >
                              <div class="mb-1 title d-none d-sm-block">Biodata Pendaftar</div>
                            </a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link text-center"role="tab" data-index="1">
                              <div class="mb-1 title d-none d-sm-block">Upload Foto</div>
                            </a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link text-center" role="tab" data-index="2">
                              <div class="mb-1 title d-none d-sm-block">Upload Berkas</div>
                            </a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link text-center" role="tab" data-index="2">
                              <div class="mb-1 title d-none d-sm-block">Pembayaran</div>
                            </a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link text-center"  role="tab" data-index="2">
                              <div class="mb-1 title d-none d-sm-block">Finalisasi</div>
                            </a>
                          </li>
                        </ul>
                      </div>

                      <!-- Notif -->
                      <div class="alert alert-warning mt-4" role="alert">
                        <p>Anda belum melakukan <b>Finalisasi Data !!</b></p>
                        <hr>
                        <p>Setelah melengkapi biodata diri, upload foto, dan upload berkas segera lakukan <b>finalisasi data</b> untuk dapat megikuti tahap selanjutnya.</p>
                      </div>

                  </div>
              </div>


            </div>
            <!-- Overview Tab End -->

            <!-- Projects Tab Start -->
            <div class="tab-pane fade" id="projectsTab" role="tabpanel">
                <h2 class="small-title">Projects</h2>

                <!-- Search Start -->
                <div class="row mb-3 g-2">
                  <div class="col mb-1">
                    <div class="d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground">
                      <input class="form-control" placeholder="Search" />
                      <span class="search-magnifier-icon">
                        <i data-acorn-icon="search"></i>
                      </span>
                      <span class="search-delete-icon d-none">
                        <i data-acorn-icon="close"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-auto text-end mb-1">
                    <div class="dropdown-as-select d-inline-block" data-childselector="span">
                      <button class="btn p-0 shadow" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="btn btn-foreground-alternate dropdown-toggle sw-13">All</span>
                      </button>
                      <div class="dropdown-menu shadow dropdown-menu-end">
                        <a class="dropdown-item active" href="#">All</a>
                        <a class="dropdown-item" href="#">Active</a>
                        <a class="dropdown-item" href="#">Inactive</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Search End -->

                <!-- Projects Content Start -->
                <div class="row row-cols-1 row-cols-sm-2 g-2">
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Basic Introduction to Bread Making</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 4</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-up" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Active</span>
                          </div>
                          <div>
                            <i data-acorn-icon="check-square" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Completed</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">4 Facts About Old Baking Techniques</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 3</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-up" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Active</span>
                          </div>
                          <div>
                            <i data-acorn-icon="clock" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Pending</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Apple Cake Recipe for Starters</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 8</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="lock-on" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Locked</span>
                          </div>
                          <div>
                            <i data-acorn-icon="sync-horizontal" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Continuing</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">A Complete Guide to Mix Dough for the Molds</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 12</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-up" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Active</span>
                          </div>
                          <div>
                            <i data-acorn-icon="check-square" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Completed</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">14 Facts About Sugar Products</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 2</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-down" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Inactive</span>
                          </div>
                          <div>
                            <i data-acorn-icon="archive" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Archived</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Easy and Efficient Tricks for Baking Crispy Breads</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 2</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-up" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Active</span>
                          </div>
                          <div>
                            <i data-acorn-icon="clock" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Pending</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Apple Cake Recipe for Starters</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 6</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-down" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Inactive</span>
                          </div>
                          <div>
                            <i data-acorn-icon="archive" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Archived</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Simple Guide to Mix Dough</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 22</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="lock-on" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Locked</span>
                          </div>
                          <div>
                            <i data-acorn-icon="check-square" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Completed</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">10 Secrets Every Southern Baker Knows</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 3</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-up" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Active</span>
                          </div>
                          <div>
                            <i data-acorn-icon="sync-horizontal" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Continuing</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Recipes for Sweet and Healty Treats</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 1</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-down" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Inactive</span>
                          </div>
                          <div>
                            <i data-acorn-icon="clock" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Pending</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Better Ways to Mix Dough for the Molds</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 20</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-up" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Active</span>
                          </div>
                          <div>
                            <i data-acorn-icon="clock" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Pending</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-body">
                        <h6 class="heading mb-3">
                          <a href="#" class="stretched-link">
                            <span class="clamp-line sh-5" data-line="2">Introduction to Baking Cakes</span>
                          </a>
                        </h6>
                        <div>
                          <div class="mb-2">
                            <i data-acorn-icon="category" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Contributors: 13</span>
                          </div>
                          <div class="mb-2">
                            <i data-acorn-icon="trend-up" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Active</span>
                          </div>
                          <div>
                            <i data-acorn-icon="check-square" class="text-muted me-2" data-acorn-size="17"></i>
                            <span class="align-middle text-alternate">Completed</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Projects Content End -->
            </div>
            <!-- Projects Tab End -->

            <!-- Permissions Tab Start -->
            <div class="tab-pane fade" id="permissionsTab" role="tabpanel">
                <h2 class="small-title">Permissions</h2>
                <div class="row row-cols-1 g-2">
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <label class="form-check custom-icon mb-0 checked-opacity-100">
                          <input type="checkbox" class="form-check-input" checked />
                          <span class="form-check-label">
                            <span class="content opacity-50">
                              <span class="heading mb-1 lh-1-25">Create</span>
                              <span class="d-block text-small text-muted">
                                Chocolate cake biscuit donut cotton candy soufflé cake macaroon. Halvah chocolate cotton candy sweet roll jelly-o candy danish
                                dragée.
                              </span>
                            </span>
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <label class="form-check custom-icon mb-0 checked-opacity-100">
                          <input type="checkbox" class="form-check-input" checked />
                          <span class="form-check-label">
                            <span class="content opacity-50">
                              <span class="heading mb-1 lh-1-25">Publish</span>
                              <span class="d-block text-small text-muted">Jelly beans wafer candy caramels fruitcake macaroon sweet roll.</span>
                            </span>
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <label class="form-check custom-icon mb-0 checked-opacity-100">
                          <input type="checkbox" class="form-check-input" checked />
                          <span class="form-check-label">
                            <span class="content opacity-50">
                              <span class="heading mb-1 lh-1-25">Edit</span>
                              <span class="d-block text-small text-muted">Jelly cake jelly sesame snaps jelly beans jelly beans.</span>
                            </span>
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <label class="form-check custom-icon mb-0 checked-opacity-100">
                          <input type="checkbox" class="form-check-input" />
                          <span class="form-check-label">
                            <span class="content opacity-50">
                              <span class="heading mb-1 lh-1-25">Delete</span>
                              <span class="d-block text-small text-muted">Danish oat cake pudding.</span>
                            </span>
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <label class="form-check custom-icon mb-0 checked-opacity-100">
                          <input type="checkbox" class="form-check-input" checked />
                          <span class="form-check-label">
                            <span class="content opacity-50">
                              <span class="heading mb-1 lh-1-25">Add User</span>
                              <span class="d-block text-small text-muted">Soufflé chocolate cake chupa chups danish brownie pudding fruitcake.</span>
                            </span>
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <label class="form-check custom-icon mb-0 checked-opacity-100">
                          <input type="checkbox" class="form-check-input" />
                          <span class="form-check-label">
                            <span class="content opacity-50">
                              <span class="heading mb-1 lh-1-25">Edit User</span>
                              <span class="d-block text-small text-muted">Biscuit powder brownie powder sesame snaps jelly-o dragée cake.</span>
                            </span>
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <label class="form-check custom-icon mb-0 checked-opacity-100">
                          <input type="checkbox" class="form-check-input" />
                          <span class="form-check-label">
                            <span class="content opacity-50">
                              <span class="heading mb-1 lh-1-25">Delete User</span>
                              <span class="d-block text-small text-muted">
                                Liquorice jelly powder fruitcake oat cake. Gummies tiramisu cake jelly-o bonbon. Marshmallow liquorice croissant.
                              </span>
                            </span>
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Permissions Tab End -->

              <!-- Friends Tab Start -->
              <div class="tab-pane fade" id="friendsTab" role="tabpanel">
                <h2 class="small-title">Friends</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-3 g-2 mb-5">
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-1.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Blaine Cottrell</div>
                                <div class="text-small text-muted">Project Manager</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-4.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Cherish Kerr</div>
                                <div class="text-small text-muted">Development Lead</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-8.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Kirby Peters</div>
                                <div class="text-small text-muted">Accounting</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-5.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Olli Hawkins</div>
                                <div class="text-small text-muted">Client Relations Lead</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-2.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Zayn Hartley</div>
                                <div class="text-small text-muted">Customer Engagement</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-3.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Esperanza Lodge</div>
                                <div class="text-small text-muted">UX Designer</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-4.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Kerr Jackson</div>
                                <div class="text-small text-muted">Frontend Developer</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-6.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Kathryn Mengel</div>
                                <div class="text-small text-muted">Team Leader</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-6.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Joisse Kaycee</div>
                                <div class="text-small text-muted">Copywriter</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="card-body">
                        <div class="row g-0 sh-6">
                          <div class="col-auto">
                            <img src="img/profile/profile-7.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                          </div>
                          <div class="col">
                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                              <div class="d-flex flex-column">
                                <div>Zayn Hartley</div>
                                <div class="text-small text-muted">Visual Effect Designer</div>
                              </div>
                              <div class="d-flex">
                                <button type="button" class="btn btn-outline-primary btn-sm ms-1">Follow</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Friends Tab End -->

              <!-- About Tab Start -->
              <div class="tab-pane fade" id="aboutTab" role="tabpanel">
                <h2 class="small-title">About</h2>
                <div class="card">
                  <div class="card-body">
                    <div class="mb-5">
                      <p class="text-small text-muted mb-2">ME</p>
                      <p>
                        Jujubes brownie marshmallow apple pie donut ice cream jelly-o jelly-o gummi bears. Tootsie roll chocolate bar dragée bonbon cheesecake
                        icing. Danish wafer donut cookie caramels gummies topping.
                      </p>
                    </div>
                    <div class="mb-5">
                      <p class="text-small text-muted mb-2">INTERESTS</p>
                      <p>
                        Chocolate cake biscuit donut cotton candy soufflé cake macaroon. Halvah chocolate cotton candy sweet roll jelly-o candy danish dragée.
                        Apple pie cotton candy tiramisu biscuit cake muffin tootsie roll bear claw cake. Cupcake cake fruitcake.
                      </p>
                    </div>
                    <div>
                      <p class="text-small text-muted mb-2">CONTACT</p>
                      <a href="#" class="d-block body-link mb-1">
                        <i data-acorn-icon="screen" class="me-2" data-acorn-size="17"></i>
                        <span class="align-middle">blainecottrell.com</span>
                      </a>
                      <a href="#" class="d-block body-link">
                        <i data-acorn-icon="email" class="me-2" data-acorn-size="17"></i>
                        <span class="align-middle">contact@blainecottrell.com</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- About Tab End -->
        </div>
        <!-- Right Side End -->
</div>


