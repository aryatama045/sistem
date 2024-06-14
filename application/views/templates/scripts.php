<!-- Vendor Scripts Start -->
<script src="<?= base_url('assets/') ?>js/vendor/jquery-3.5.1.min.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/OverlayScrollbars.min.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/autoComplete.min.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/clamp.min.js"></script>
<script src="<?= base_url('assets/') ?>icon/acorn-icons.js"></script>
<script src="<?= base_url('assets/') ?>icon/acorn-icons-interface.js"></script>
<script src="<?= base_url('assets/') ?>icon/acorn-icons-learning.js"></script>
<script src="<?= base_url('assets/') ?>icon/acorn-icons-commerce.js"></script>
<script src="<?= base_url('assets/') ?>icon/acorn-icons-medical.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/jquery.validate/jquery.validate.min.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/jquery.validate/additional-methods.min.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/bootstrap-submenu.js"></script>
<script src="<?= base_url('assets/') ?>js/datatables.min.js"></script>
<script src="<?= base_url('assets/') ?>js/vendor/bootstrap-notify.min.js"></script>
<!-- Vendor Scripts End -->

<!-- Template Base Scripts Start -->
<script src="<?= base_url('assets/') ?>js/base/helpers.js"></script>
<script src="<?= base_url('assets/') ?>js/base/globals.js"></script>
<script src="<?= base_url('assets/') ?>js/base/nav.js"></script>
<script src="<?= base_url('assets/') ?>js/base/settings.js"></script>
<!-- Template Base Scripts End -->

<script src="<?= base_url('assets/') ?>js/pages/customerDetails.js"></script>
<script src="<?= base_url('assets/') ?>js/pages/profile.standard.js"></script>
<script src="<?= base_url('assets/') ?>js/plugins/notifies.js"></script>



<script src="<?= base_url('assets/') ?>js/vendor/select2.full.min.js"></script>

<script src="<?= base_url('assets/') ?>js/vendor/datepicker/bootstrap-datepicker.min.js"></script>

<script src="<?= base_url('assets/') ?>js/vendor/datepicker/locales/bootstrap-datepicker.es.min.js"></script>

<script src="<?= base_url('assets/') ?>js/vendor/fancybox.umd.js"></script>

<!-- Page Specific Scripts Start -->
<script src="<?= base_url('assets/') ?>js/common.js"></script>
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<!-- Page Specific Scripts End -->

<?php $url = $this->uri->segment(1); if($url != 'dashboard'){  ?>
<script src="<?= base_url('assets/') ?>js/base/search.js"></script>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $('#selectTanggal').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        });
        $(function() {
            $('#selectTanggalAwal').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        });
        $(function() {
            $('#selectTanggalAkhir').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        });
    });
</script>


<script>
    Fancybox.bind('[data-fancybox="gallery"]', {

    Toolbar: {
        display: {
        left: ["infobar"],
        middle: [
            "zoomIn",
            "zoomOut",
            "toggle1to1",
            "rotateCCW",
            "rotateCW",
            "flipX",
            "flipY",
        ],
        right: ["slideshow", "thumbs", "close"],
        },
    },
    });

    Fancybox.bind('[data-fancybox="foto-profil"]', {

        Toolbar: {
            display: {
            left: ["infobar"],
            middle: [
                "zoomIn",
                "zoomOut",
                "toggle1to1",
                "rotateCCW",
                "rotateCW",
                "flipX",
                "flipY",
            ],
            right: ["slideshow", "thumbs", "close"],
            },
        },
    });
</script>



