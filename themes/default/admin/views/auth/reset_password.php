<?php defined('BASEPATH') or exit('No direct script access allowed');
$assets = base_url('themes/default/admin/assets/');
?><!DOCTYPE html>
<html lang="en" data-assets-path="<?= $assets ?>materialize/" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? lang('reset_password') ?></title>
  <link rel="shortcut icon" href="<?= $assets ?>images/icon.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/css/core.css" />
  <link rel="stylesheet" href="<?= $assets ?>materialize/css/demo.css" />
  <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/css/pages/page-auth.css" />
  <script src="<?= $assets ?>materialize/vendor/js/helpers.js"></script>
  <script src="<?= $assets ?>materialize/js/config.js"></script>
</head>
<body class="layout-wide customizer-hide">
<div class="authentication-wrapper authentication-basic container-p-y">
  <div class="authentication-inner py-6">
    <div class="card">
      <div class="card-body">
        <div class="app-brand justify-content-center mb-6">
          <a href="<?= admin_url() ?>" class="app-brand-link">
            <span class="app-brand-text fw-semibold fs-5"><?= $Settings->site_name ?></span>
          </a>
        </div>
        <h4 class="mb-1"><?= lang('reset_password') ?></h4>
        <p class="mb-5 text-muted"><?= lang('type_new_password') ?></p>

        <?php if ($Settings->mmode) { ?>
        <div class="alert alert-warning mb-4"><?= lang('site_is_offline') ?></div>
        <?php } ?>
        <?php if ($error) { ?><div class="alert alert-danger mb-4"><?= $error ?></div><?php } ?>
        <?php if ($message) { ?><div class="alert alert-success mb-4"><?= $message ?></div><?php } ?>

        <?php echo admin_form_open('auth/reset_password', 'class="mb-5"'); ?>
          <?php echo form_hidden('code', $code ?? ''); ?>
          <div class="mb-4">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline flex-grow-1">
                <input type="password" class="form-control" id="new_password" name="new_password"
                       placeholder="·········" required
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
                <label for="new_password"><?= lang('new_password') ?></label>
              </div>
              <span class="input-group-text cursor-pointer" id="togglePwd1">
                <i class="fa fa-eye-slash"></i>
              </span>
            </div>
            <div class="form-text text-muted small"><?= lang('pasword_hint') ?></div>
          </div>
          <div class="mb-5">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline flex-grow-1">
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password"
                       placeholder="·········" required />
                <label for="confirm_new_password"><?= lang('confirm_password') ?></label>
              </div>
              <span class="input-group-text cursor-pointer" id="togglePwd2">
                <i class="fa fa-eye-slash"></i>
              </span>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <a href="<?= admin_url('auth/login') ?>" class="btn btn-outline-secondary">
              <i class="fa fa-chevron-left me-1"></i> <?= lang('back') ?>
            </a>
            <button type="submit" class="btn btn-primary">
              <?= lang('submit') ?> <i class="fa fa-check ms-1"></i>
            </button>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<script src="<?= $assets ?>materialize/vendor/libs/jquery/jquery.js"></script>
<script src="<?= $assets ?>materialize/vendor/libs/popper/popper.js"></script>
<script src="<?= $assets ?>materialize/vendor/js/bootstrap.js"></script>
<script src="<?= $assets ?>materialize/js/main.js"></script>
<script>
$(document).ready(function() {
  $('#togglePwd1').on('click', function() {
    var inp = $('#new_password');
    var icon = $(this).find('i');
    inp.attr('type', inp.attr('type') === 'password' ? 'text' : 'password');
    icon.toggleClass('fa-eye fa-eye-slash');
  });
  $('#togglePwd2').on('click', function() {
    var inp = $('#confirm_new_password');
    var icon = $(this).find('i');
    inp.attr('type', inp.attr('type') === 'password' ? 'text' : 'password');
    icon.toggleClass('fa-eye fa-eye-slash');
  });
});
</script>
</body>
</html>