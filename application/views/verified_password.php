<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="https://place-hold.it/100x100/127352/fff/fff?text=CUTI&fontsize=35&bold" type="image/x-icon" >

    <link rel="stylesheet" href="<?= base_url('theme/default/') ?>font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url('theme/default/') ?>font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/vendor/bootstrap-float-label.min.css" />
	<link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/dore.light.bluenavy.css" />
	<link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/main.css" />
</head>

<body class="background  no-footer">
    <!-- <div class="fixed-background"></div> -->
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="card-body">
                            <h6 class="mb-4">Set New Password</h6>
                                <?php if($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                                <?php elseif($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                                <?php endif; ?>

                                <?php if(validation_errors()): ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <?php echo validation_errors(); ?>
                                    </div>
                                <?php endif; ?>

                            <form action="<?php echo base_url('auth/save_forgot_password/'.$hash) ?>" method="post">

                                <label class="form-group has-float-label mb-4">
                                <input type="password" class="form-control" name="password" placeholder="New Password" autocomplete="off" required tabIndex="1" autofocus />
                                    <span>New Password</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input type="password" class="form-control" name="cpassword" placeholder="Konfirmasi Password" autocomplete="off" required tabIndex="2" autofocus/>
                                    <span>Konfirmasi Password</span>
                                </label>

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="<?= base_url('auth/login') ?>"> Back to Login !!</a>
                                    <button tabIndex="3" class="btn btn-primary btn-sm btn-shadow" type="submit"> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url('theme/default/') ?>js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('theme/default/') ?>js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('theme/default/') ?>js/dore.script.js"></script>
    <script src="<?= base_url('theme/default/') ?>js/scripts.single.theme.js"></script>

    <script type="text/javascript">
        $(document).on('keypress', 'input,select', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
                console.log($next.length);
                if (!$next.length) {
                $next = $('[tabIndex=1]');        }
                $next.focus() .click();
            }

        });
        $(document).ready(function() {
            $('#karyawan').on('keypress', function (e) {
                var id = $('[name=nama_login]').val();
                alert(id);
                $.ajax({
                    url: base_url + 'user/approve/get_karyawan',
                    method: "POST",
                    data: { id: id },
                    async: true,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        html += '' + data + '';
                        $('#nama_lengkap').html(html);
                    }
                });
            });
        });

        $('#nip').on('keyup', function(event) { // for text boxes
            tableKaryawan.ajax.reload(); //just reload table
        });
    </script>

    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function(){

        // Initialize
        $( "#nama_login" ).autocomplete({
            source: function( request, response ) {
            // Fetch data
            $.ajax({
                url: "<?php echo base_url() ?>auth/get_karyawan",
                type: 'post',
                dataType: "json",
                data: {
                search: request.term
                },
                success: function( data ) {
                    var html = '';
                        html += '<input type="text" disabled value="' + data + '" name="nama_lengkap" class="form-control" >';
                        $('#nama_lengkap').html(html);
                }
            });
            }
        });

        });
    </script>



</body>

</html>
