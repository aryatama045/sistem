<div class="row">
		<div class="col-12">
			<h1>Manage User</h1>
			<div class="top-right-button-container">
				<div class="btn-group">
					<a class="btn btn-outline-primary btn-lg" href="<?= base_url('cuti_normal/create') ?>" >
						Tambah User
					</a>
				</div>
			</div>
			<div class="separator"></div>
			<br>
		</div>
	</div>

	<div id="messages"></div>

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

	<div class="row">
		<div class="col-12 ">
			<div class="card">
				<div class="card-body">
					<table id="manageTable" class="table table-bordered data-table">
						<thead>
							<tr>
								<th>NO.DOK </th>
								<th>TGL.DOK</th>
								<th>KETERANGAN</th>
								<th class="empty">&nbsp;</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input name="no_dok_tdk_masuk" placeholder="No Doc" class="form-control" type="text" disabled>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
    <script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
    <?php //echo $this->load->assets('users', 'manage_users', 'js');  ?>
<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
    var manageTable;
    $(document).ready(function() {

        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            // 'orderCellsTop': true,
            // 'fixedHeader': true,
            'processing': true,
            'serverSide': true,
            'scrollX': true,
            'ajax': {
                'url': base_url + 'users/manage_user/fetchDataUser',
                'type': 'POST',
            },
            'order': [0, 'DESC'],
            'columnDefs': [{
                    targets: 0,
                    className: 'text-left'
                },
                {
                    targets: 1,
                    className: 'text-center'
                },
            ]
        });
        $("#manageTable_filter").css("display", "none");

        $('.search-input-text').on('keyup', function(event) { // for text boxes
            var i = $(this).attr('data-column'); // getting column index
            var v = $(this).val(); // getting search input value
            var keycode = event.which;
            if (keycode == 13) {
                manageTable.columns(i).search(v).draw();
            }
        });
        $('.search-input-select').on('change', function() { // for select box
            var i = $(this).attr('data-column');
            var v = $(this).val();
            manageTable.columns(i).search(v).draw();
        });

    });
</script>


