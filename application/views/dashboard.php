

    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
        <div class="row">
            <!-- Title Start -->
            <div class="col-12 col-md-7">
                <a class="muted-link pb-2 d-inline-block hidden" href="#">
                    <span class="align-middle lh-1 text-small">&nbsp;</span>
                </a>
                <h1 class="mb-0 pb-0 display-4" id="title">Welcome, <?= $this->session->userdata('username'); ?> ! <br>
                    <span class="text-small text-muted">Tahun Ajaran : <?= $tahun_ajaran ?> - Semeseter <?= $semester ?></span></h1>
            </div>
            <!-- Title End -->
        </div>
    </div>
    <!-- Title and Top Buttons End -->

    <!-- Stats Start -->
    <div class="row">
        <div class="col-12">
            <div class="mb-5">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="dollar" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">EARNINGS</div>
                            <div class="text-primary cta-4">$ 315.20</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="cart" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">ORDERS</div>
                            <div class="text-primary cta-4">16</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="server" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">SESSIONS</div>
                            <div class="text-primary cta-4">463</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="user" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">USERS</div>
                            <div class="text-primary cta-4">17</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="arrow-top-left" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">RETURNS</div>
                            <div class="text-primary cta-4">2</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="message" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">COMMENTS</div>
                            <div class="text-primary cta-4">5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= $menu ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3>#To add permission#</h3>
            <p>Name format: method_name-controller_name.</p>
            <p>Example: if the controller name is 'roles; and 'edit' is a method then name will be <code>'edit-roles'</code></p>
            <code>
            $this->Permission->add([
                'name' => 'add-roles',
                'display_name' => 'Create Role',
                'status' => 1,
            ]);
            </code>

            <h3>#To add role#</h3>
            <code>
                $this->Role->add([
                'name' => 'editor',
                'display_name' => 'editor',
                'description' => 'Editor can edit and publish posts',
                'status' => 1,
                ]);
            </code>

            <h3>#To assign permissions with role#</h3>
            <p>$permissions will be a permission id or an array of permission id</p>
            <code>
                $this->Role->addPermissions($role_id, $permissions);
            </code>

            <h3>#To add User#</h3>
            <code>
                $this->User->add([
                'name' => 'Likhon',
                'username' => 'likhon',
                'password' => password_hash('admin', PASSWORD_BCRYPT),
                'status' => 1,
                ]);
            </code>

            <h3>#To assign roles with user#</h3>
            <p>$roles will be a role id or an array of role id</p>
            <code>
                $this->User->addRoles($user_id, $roles);
            </code>

            <div class="mt-5"></div>

            <h3>#To activate auth library#</h3>
            <p>To enable authentication put these line in controller's construction method:</p>

            <pre><strong>
                $this->load->library(['auth']);
                $this->auth->route_access();
            </strong></pre>

            <p>If you want to authenticate only some methods of a controller then use</p>
            <p>$methods is a single or array of method name of a controller</p>
            <samp>$this->auth->only['edit', 'delete']</samp><br>

            <code>$this->auth->only($methods)</code>

            <p> Or if you need to not check authentication for some methods then use:</p>
            <code>$this->auth->except($methods)</code>

            <p>Check if current user is logged in.</p>
            <code>
                if( check() ) {}
            </code>

            <p>Check if current user has a permission by its name.</p>
            <code>
                if( can($permissions) ) {}
            </code>
            <p>Example: <samp>if( can('edit-posts') ) {} or if( can(['edit-posts', 'publish-posts']) ) {}</samp></p>
        </div>
    </div>
    <!-- Stats End -->



    <script src="<?= base_url('assets/') ?>js/base/search.js"></script>
