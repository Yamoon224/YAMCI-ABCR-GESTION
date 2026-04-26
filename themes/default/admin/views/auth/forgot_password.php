<?php defined('BASEPATH') or exit('No direct script access allowed');
$assets = base_url('themes/default/admin/assets/');
?><!DOCTYPE html>
<html lang="en" data-assets-path="<?= $assets ?>materialize/" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= lang('forgot_password') ?></title>
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
            <span class="app-brand-text fw-semibold fs-5"><?= SITE_NAME ?></span>
          </a>
        </div>
        <h4 class="mb-1"><?= $this->lang->line('forgot_password_heading') ?></h4>
        <p class="mb-5 text-muted"><?= $this->lang->line('type_email_to_reset') ?></p>

        <?php if ($message) { ?><div class="alert alert-success mb-4"><?= $message ?></div><?php } ?>
        <?php if ($error) { ?><div class="alert alert-danger mb-4"><?= $error ?></div><?php } ?>

        <?php echo form_open('auth/forgot_password', 'class="mb-5"'); ?>
          <div class="form-floating form-floating-outline mb-5">
            <input type="email" class="form-control" id="email" name="forgot_email"
                   placeholder="<?= $this->lang->line('email_address') ?>" required autofocus />
            <label for="email"><?= $this->lang->line('email_address') ?></label>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <a href="<?= admin_url('auth/login') ?>" class="btn btn-outline-secondary">
              <i class="fa fa-chevron-left me-1"></i> <?= $this->lang->line('back') ?>
            </a>
            <button type="submit" class="btn btn-primary">
              <?= $this->lang->line('submit') ?> <i class="fa fa-envelope ms-1"></i>
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
</body>
</html>