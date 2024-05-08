<nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
    <ul class="breadcrumb pt-0">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><?= $modul ?></li>

        <?php if(!is_null($pagetitle)){ ?>
            <li class="breadcrumb-item"><?= $pagetitle ?></li>
        <?php } ?>

        <?php if(!is_null($function)){ ?>
            <li class="breadcrumb-item"><?= $function ?></li>
        <?php } ?>
    </ul>
</nav>