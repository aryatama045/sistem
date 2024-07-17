

<div class="row">

    <?php if(validation_errors()){ ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>

    <?php if($this->session->flashdata('success')){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong><?php echo $this->session->flashdata('success'); ?> </strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <?php if($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong><?php echo $this->session->flashdata('error'); ?> </strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>


    <?php $this->load->view('pmb/profile_menu') ?>

    <?php $status = $pmb['status_terkini']; ?>

    <!-- Right Side Start -->
    <div class="col-12 col-xl-8 col-xxl-9 mb-5 tab-content">
        <!-- Status Terkini Tab Start -->
        <div class="tab-pane fade <?php if($status=='1'){ echo 'show active';} ?>" id="statusTerkiniTab" role="tabpanel">
          <?php $this->load->view('pmb/1_status_terkini'); ?>
        </div>
        <!-- Status Terkini Tab End -->

        <!-- Biodata Tab Start -->
        <div class="tab-pane fade <?php if($status=='2'){ echo 'show active';} ?>" id="biodataTab" role="tabpanel">
            <?php $this->load->view('pmb/2_biodata'); ?>
        </div>
        <!-- Biodata Tab End -->

        <!-- Upload Foto Tab Start -->
        <div class="tab-pane fade <?php if($status=='3'){ echo 'show active';} ?>" id="uploadFotoTab" role="tabpanel">
            <?php $this->load->view('pmb/3_upload_foto'); ?>
        </div>
        <!-- Upload Foto Tab End -->

        <!-- Upload Berkas Tab Start -->
        <div class="tab-pane fade <?php if($status=='4'){ echo 'show active';} ?>" id="uploadBerkasTab" role="tabpanel">
            <?php $this->load->view('pmb/4_upload_berkas'); ?>
        </div>
        <!-- Upload Berkas Tab End -->

        <!-- Pembayaran Tagihan Tab Start -->
        <div class="tab-pane fade <?php if($status=='5'){ echo 'show active';} ?>" id="pembayaranTagihanTab" role="tabpanel">
            <?php $this->load->view('pmb/5_pembayaran_tagihan'); ?>
        </div>
        <!-- Pembayaran Tagihan Tab End -->

        <!-- Finalisasi Data Tab Start -->
        <div class="tab-pane fade <?php if($status=='6'){ echo 'show active';} ?>" id="finalisasiDataTab" role="tabpanel">
            <?php $this->load->view('pmb/6_finalisasi_data'); ?>
        </div>
        <!-- Finalisasi Data Tab End -->

        <!-- About Tab Start -->
        <div class="tab-pane fade" id="aboutTab" role="tabpanel">
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


