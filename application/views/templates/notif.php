<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php elseif($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if(validation_errors()): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo validation_errors(); ?>
        </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo $errors; ?>
        </div>
<?php endif; ?>