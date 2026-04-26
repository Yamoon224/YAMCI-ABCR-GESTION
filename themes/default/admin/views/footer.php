<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

        </div>
        <!-- / Content -->

        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
          <div class="container-xxl">
            <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
                &copy; <?= date('Y') . ' ' . $Settings->site_name ?>
                <?php if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
                    echo ' — Page rendue en <strong>{elapsed_time}</strong>s, mémoire : {memory_usage}';
                } ?>
              </div>
              <div>
                <a href="<?= site_url() ?>" class="footer-link me-3"><?= lang('home') ?></a>
                <a href="<?= admin_url() ?>" class="footer-link"><?= lang('dashboard') ?></a>
              </div>
            </div>
          </div>
        </footer>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
      </div>
      <!-- / Content wrapper -->
    </div>
    <!-- / Layout page -->
  </div>
  <!-- Overlay -->
  <div class="layout-overlay layout-menu-toggle"></div>
  <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Modals -->
<div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true"></div>
<div class="modal fade" id="myModal2" tabindex="-1" aria-hidden="true"></div>
<div id="modal-loading" style="display:none;">
  <div class="modal-backdrop fade show"></div>
  <div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100" style="z-index:9999;">
    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
  </div>
</div>
<div id="ajaxCall" style="display:none;position:fixed;top:10px;right:10px;z-index:9999;">
  <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
</div>

<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->envato_username, $Settings->purchase_code); ?>

<script>
var dt_lang = <?= $dt_lang ?>, dp_lang = <?= $dp_lang ?>, site = <?= json_encode(['url' => base_url(), 'base_url' => admin_url(), 'assets' => $assets, 'settings' => $Settings, 'dateFormats' => $dateFormats]) ?>;
var lang = {
  paid: '<?= lang('paid') ?>', pending: '<?= lang('pending') ?>', completed: '<?= lang('completed') ?>',
  ordered: '<?= lang('ordered') ?>', received: '<?= lang('received') ?>', partial: '<?= lang('partial') ?>',
  sent: '<?= lang('sent') ?>', r_u_sure: '<?= lang('r_u_sure') ?>', due: '<?= lang('due') ?>',
  returned: '<?= lang('returned') ?>', transferring: '<?= lang('transferring') ?>', active: '<?= lang('active') ?>',
  inactive: '<?= lang('inactive') ?>', unexpected_value: '<?= lang('unexpected_value') ?>',
  select_above: '<?= lang('select_above') ?>', download: '<?= lang('download') ?>',
  required_invalid: '<?= lang('required_invalid') ?>'
};
</script>

<?php
$s2_lang_file = read_file('./assets/config_dumps/s2_lang.js');
foreach (lang('select2_lang') as $s2_key => $s2_line) {
    $s2_data[$s2_key] = str_replace(['{', '}'], ['"+', '+"'], $s2_line);
}
$s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
?>

<!-- Core Materialize JS (jQuery + Migrate chargés dans <head>) -->
<script src="<?= $assets ?>materialize/vendor/libs/popper/popper.js"></script>
<script src="<?= $assets ?>materialize/vendor/js/bootstrap.js"></script>
<script src="<?= $assets ?>materialize/vendor/libs/node-waves/node-waves.js"></script>
<script src="<?= $assets ?>materialize/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?= $assets ?>materialize/vendor/libs/pickr/pickr.js"></script>
<script src="<?= $assets ?>materialize/vendor/js/menu.js"></script>
<script src="<?= $assets ?>materialize/js/main.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- jQuery UI -->
<script src="<?= $assets ?>js/jquery-ui.min.js"></script>

<!-- Plugins legacy requis par core.js -->
<script src="<?= $assets ?>js/jquery.cookie.js"></script>
<script src="<?= $assets ?>js/bootstrapValidator.min.js"></script>
<!-- moment.js (requis par daterangepicker dans core.js) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<!-- iCheck (checkboxes/radios) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<!-- Bootstrap DateTimePicker Stefan Petre ($.fn.datetimepicker) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/2.4.4/js/bootstrap-datetimepicker.min.js"></script>
<!-- DateRangePicker Dan Grossman ($.fn.daterangepicker) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<!-- Shim $.fn.perfectScrollbar → new PerfectScrollbar() (compatibilité core.js) -->
<script>(function($){
  if(typeof PerfectScrollbar!=='undefined'&&!$.fn.perfectScrollbar){
    $.fn.perfectScrollbar=function(opt){
      if(opt==='destroy')return this.each(function(){if(this._ps){this._ps.destroy();delete this._ps;}});
      return this.each(function(){if(!this._ps){try{this._ps=new PerfectScrollbar(this,typeof opt==='object'?opt:{});}catch(e){}}});
    };
  }
})(jQuery);</script>

<!-- DateTimePicker (core.js) -->
<script src="<?= $assets ?>js/core.js"></script>

<!-- Page-specific scripts -->
<?= ($m == 'purchases' && ($v == 'add' || $v == 'edit' || $v == 'purchase_by_csv')) ? '<script src="' . $assets . 'js/purchases.js"></script>' : '' ?>
<?= ($m == 'transfers' && ($v == 'add' || $v == 'edit')) ? '<script src="' . $assets . 'js/transfers.js"></script>' : '' ?>
<?= ($m == 'sales' && ($v == 'add' || $v == 'edit')) ? '<script src="' . $assets . 'js/sales.js"></script>' : '' ?>
<?= ($m == 'returns' && ($v == 'add' || $v == 'edit')) ? '<script src="' . $assets . 'js/returns.js"></script>' : '' ?>
<?= ($m == 'quotes' && ($v == 'add' || $v == 'edit')) ? '<script src="' . $assets . 'js/quotes.js"></script>' : '' ?>
<?= ($m == 'products' && ($v == 'add_adjustment' || $v == 'edit_adjustment')) ? '<script src="' . $assets . 'js/adjustments.js"></script>' : '' ?>

<!-- Calculator -->
<script src="<?= $assets ?>js/jquery.calculator.min.js"></script>

<script>
var oTable = '', r_u_sure = "<?= lang('r_u_sure') ?>";
<?= $s2_file_date ?>
if ($.fn.dataTable) {
    $.extend(true, $.fn.dataTable.defaults, {"oLanguage": dt_lang});
}
if ($.fn.datetimepicker && $.fn.datetimepicker.dates) {
    $.fn.datetimepicker.dates['sma'] = dp_lang;
}

// Activer l'élément de menu courant
$(document).ready(function () {
    $('.mm_<?= $m ?>').addClass('active open');
    $('.mm_<?= $m ?> > .menu-link').closest('li').addClass('active open');
    $('#<?= $m ?>_<?= $v ?>').addClass('active');

    // Bootstrap 3 → 5 compat: data-toggle → data-bs-toggle pour les modals
    $('[data-bs-toggle="modal"]').each(function() {
        var target = $(this).data('target');
        if (target && !$(this).attr('data-bs-toggle')) {
            $(this).attr('data-bs-toggle', 'modal').attr('data-bs-target', target);
        }
    });

    // Alertes dismissibles legacy
    $(document).on('click', '[data-bs-dismiss="alert"]', function() {
        $(this).closest('.alert').remove();
    });
});
</script>

<?= (DEMO) ? '<script src="' . $assets . 'js/ppp_ad.min.js"></script>' : '' ?>
<script src="<?= base_url('assets/custom/custom.js') ?>"></script>
</body>
</html>