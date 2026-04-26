<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="<?= $Settings->user_language ?>" dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr' ?>" data-assets-path="<?= $assets ?>materialize/" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?= $title ?? $Settings->site_name ?></title>
  <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?= admin_url() ?>'; }</script>
  <link rel="shortcut icon" href="<?= $assets ?>images/icon.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/fonts/iconify-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <!-- Materialize CSS -->
  <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/css/core.css" />
  <link rel="stylesheet" href="<?= $assets ?>materialize/css/demo.css" />
  <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/css/pages/page-auth.css" />

  <!-- Thème stocké : appliqué avant helpers.js pour éviter le flash -->
  <script>(function(){var t=localStorage.getItem('templateCustomizer-vertical-menu-template--Theme');if(t)document.documentElement.setAttribute('data-bs-theme',t);})();</script>

  <!-- Helpers & Config -->
  <script src="<?= $assets ?>materialize/vendor/js/helpers.js"></script>
  <script src="<?= $assets ?>materialize/js/config.js"></script>
</head>

<body class="layout-wide customizer-hide">

<!-- Login Tab -->
<div id="tab-login">
<div class="authentication-wrapper authentication-cover">
  <div class="authentication-inner row m-0">
    <!-- Image gauche -->
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
      <img src="<?= $assets ?>images/auth-login-illustration-light.png"
           class="auth-cover-illustration w-100" alt="auth-illustration"
           data-app-light-img="auth-login-illustration-light.png"
           data-app-dark-img="auth-login-illustration-dark.png" />
    </div>

    <!-- Formulaire de connexion -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
      <div class="w-px-400 mx-auto pt-12 pt-lg-0">
        <?php if ($Settings->logo2) { ?>
        <img src="<?= base_url('assets/uploads/logos/' . $Settings->logo2) ?>" alt="<?= $Settings->site_name ?>" class="d-block mx-auto mb-3" style="max-height:60px;" />
        <?php } ?>
        <h4 class="mb-1 text-center"><?= $Settings->site_name ?></h4>
        <p class="mb-5 text-muted text-center"><?= lang('login_to_your_account') ?> 👋</p>

        <?php if ($Settings->mmode) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          <?= lang('site_offline') ?>
        </div>
        <?php } ?>
        <?php if ($error) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          <?= $error ?>
        </div>
        <?php } ?>
        <?php if ($message) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          <?= $message ?>
        </div>
        <?php } ?>

        <?php echo admin_form_open('auth/login', 'class="mb-5"'); ?>
          <div class="form-floating form-floating-outline mb-5">
            <input type="text" class="form-control" id="identity" name="identity"
                   value="<?= DEMO ? 'owner@tecdiary.com' : '' ?>"
                   placeholder="<?= lang('username') ?>" required autofocus />
            <label for="identity"><i class="fa fa-user me-2 text-muted"></i><?= lang('username') ?></label>
          </div>
          <div class="mb-5">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline flex-grow-1">
                <input type="password" id="password" class="form-control" name="password"
                       value="<?= DEMO ? '12345678' : '' ?>"
                       placeholder="·········" required />
                <label for="password"><i class="fa fa-key me-2 text-muted"></i><?= lang('pw') ?></label>
              </div>
              <span class="input-group-text cursor-pointer" id="togglePwd">
                <i class="icon-base ri ri-eye-off-line icon-20px"></i>
              </span>
            </div>
          </div>

          <?php if ($Settings->captcha) { ?>
          <div class="mb-4">
            <div class="row g-2 align-items-center">
              <div class="col-6"><?= $image ?></div>
              <div class="col-6">
                <div class="input-group">
                  <a href="<?= admin_url('auth/reload_captcha') ?>" class="input-group-text reload-captcha">
                    <i class="fa fa-refresh"></i>
                  </a>
                  <?= form_input($captcha, '', 'class="form-control"') ?>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>

          <div class="mb-5">
            <div class="form-check">
              <?= form_checkbox('remember', '1', false, 'id="remember" class="form-check-input"') ?>
              <label class="form-check-label" for="remember"><?= lang('remember_me') ?></label>
            </div>
          </div>
          <button class="btn btn-primary d-flex align-items-center justify-content-center w-100" type="submit">
            <?= lang('login') ?> <i class="fa fa-sign-in ms-2"></i>
          </button>
          <p class="text-center mt-3 mb-0"><a href="#" class="forgot-link" id="showForgot"><?= lang('forgot_your_password') ?></a></p>
        <?php echo form_close(); ?>

        <?php if ($Settings->allow_reg) { ?>
        <p class="text-center mt-4">
          <span><?= lang('dont_have_account') ?></span>
          <a href="#" id="showRegister"><strong><?= lang('click_here') ?></strong></a>
          <span><?= lang('to_register') ?></span>
        </p>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Mot de passe oublié -->
<div id="tab-forgot" style="display:none;">
<div class="authentication-wrapper authentication-basic container-p-y">
  <div class="authentication-inner py-6">
    <div class="card">
      <div class="card-body">
        <div class="app-brand justify-content-center flex-column align-items-center mb-6">
          <?php if ($Settings->logo2) { ?>
          <img src="<?= base_url('assets/uploads/logos/' . $Settings->logo2) ?>" alt="<?= $Settings->site_name ?>" class="d-block mx-auto mb-2" style="max-height:60px;" />
          <?php } ?>
          <a href="<?= admin_url() ?>" class="app-brand-link text-center">
            <span class="app-brand-text fw-semibold fs-5"><?= $Settings->site_name ?></span>
          </a>
        </div>
        <h6 class="mb-1"><?= lang('forgot_password') ?> <small class="text-muted fw-normal fs-6"><?= lang('type_email_to_reset') ?></small></h6>

        <?php if ($error) { ?><div class="alert alert-danger mb-4"><?= $error ?></div><?php } ?>
        <?php if ($message) { ?><div class="alert alert-success mb-4"><?= $message ?></div><?php } ?>

        <?php echo admin_form_open('auth/forgot_password', 'class="mb-5"'); ?>
          <div class="form-floating form-floating-outline mb-5">
            <input type="email" class="form-control" id="forgot_email" name="forgot_email"
                   placeholder="<?= lang('email_address') ?>" required />
            <label for="forgot_email"><?= lang('email_address') ?></label>
          </div>
          <div class="d-flex justify-content-between">
            <a href="#" class="btn btn-outline-secondary" id="backToLogin">
              <i class="fa fa-chevron-left me-1"></i> <?= lang('back') ?>
            </a>
            <button type="submit" class="btn btn-primary">
              <?= lang('submit') ?> <i class="fa fa-envelope ms-1"></i>
            </button>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
</div>

<?php if ($Settings->allow_reg) { ?>
<!-- Inscription -->
<div id="tab-register" style="display:none;">
<div class="authentication-wrapper authentication-basic container-p-y">
  <div class="authentication-inner py-6">
    <div class="card">
      <div class="card-body">
        <div class="app-brand justify-content-center mb-6">
          <span class="app-brand-text fw-semibold fs-5"><?= $Settings->site_name ?></span>
        </div>
        <h4 class="mb-1"><?= lang('register_account_heading') ?></h4>

        <?php echo admin_form_open('auth/register', 'class="mb-5"'); ?>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="first_name" id="first_name"
                       placeholder="<?= lang('first_name') ?>" required />
                <label for="first_name"><?= lang('first_name') ?></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="last_name" id="last_name"
                       placeholder="<?= lang('last_name') ?>" required />
                <label for="last_name"><?= lang('last_name') ?></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="company" id="company"
                       placeholder="<?= lang('company') ?>" />
                <label for="company"><?= lang('company') ?></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="phone" id="phone"
                       placeholder="<?= lang('phone') ?>" required />
                <label for="phone"><?= lang('phone') ?></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="username" id="reg_username"
                       placeholder="<?= lang('username') ?>" required />
                <label for="reg_username"><?= lang('username') ?></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="email" class="form-control" name="email" id="reg_email"
                       placeholder="<?= lang('email_address') ?>" required />
                <label for="reg_email"><?= lang('email') ?></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="password" class="form-control" name="password" id="password1"
                       placeholder="········" required
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
                <label for="password1"><?= lang('password') ?></label>
              </div>
              <div class="form-text text-muted small"><?= lang('pasword_hint') ?></div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                       placeholder="········" required />
                <label for="confirm_password"><?= lang('confirm_password') ?></label>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
              <a href="#" class="btn btn-outline-secondary" id="backToLoginFromReg">
                <i class="fa fa-chevron-left me-1"></i> <?= lang('back') ?>
              </a>
              <button type="submit" class="btn btn-primary">
                <?= lang('register_now') ?> <i class="fa fa-user ms-1"></i>
              </button>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
</div>
<?php } ?>

<!-- Materialize JS -->
<script src="<?= $assets ?>materialize/vendor/libs/jquery/jquery.js"></script>
<script src="<?= $assets ?>materialize/vendor/libs/popper/popper.js"></script>
<script src="<?= $assets ?>materialize/vendor/js/bootstrap.js"></script>
<script src="<?= $assets ?>materialize/vendor/libs/node-waves/node-waves.js"></script>
<script src="<?= $assets ?>materialize/js/main.js"></script>

<script>
$(document).ready(function () {
  // Afficher le bon onglet via le hash
  var hash = window.location.hash;
  if (hash === '#forgot_password') {
    $('#tab-login').hide(); $('#tab-forgot').show(); $('#tab-register').hide();
  } else if (hash === '#register') {
    $('#tab-login').hide(); $('#tab-forgot').hide(); $('#tab-register').show();
  }

  $('#showForgot').on('click', function(e) {
    e.preventDefault();
    $('#tab-login').hide(); $('#tab-forgot').show();
  });
  $('#backToLogin, #backToLoginFromReg').on('click', function(e) {
    e.preventDefault();
    $('#tab-forgot, #tab-register').hide(); $('#tab-login').show();
  });
  $('#showRegister').on('click', function(e) {
    e.preventDefault();
    $('#tab-login').hide(); $('#tab-register').show();
  });

  // Toggle password visibility
  $('#togglePwd').on('click', function() {
    var input = $('#password');
    var icon = $(this).find('i');
    if (input.attr('type') === 'password') {
      input.attr('type', 'text');
      icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
    } else {
      input.attr('type', 'password');
      icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
    }
  });
});
</script>
</body>
</html>