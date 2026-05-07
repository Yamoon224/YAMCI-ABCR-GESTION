<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center gap-2 py-2 px-3 bg-white border-bottom">
        <span class="bg-success bg-opacity-10 rounded-2 p-2 lh-1">
            <i class="fa fa-plus text-success"></i>
        </span>
        <h5 class="mb-0 fw-semibold"><?= lang('count_stock'); ?></h5>
    </div>
    <div class="card-body p-3 p-lg-4">
        <?php
        $attrib = ['role' => 'form', 'id' => 'stForm'];
        echo admin_form_open_multipart('products/count_stock', $attrib);
        ?>
        <div class="row g-3">

            <!-- Informations -->
            <div class="col-12">
                <div class="card border shadow-none rounded-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-primary border-opacity-25">
                        <i class="fa fa-info-circle text-primary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-primary"><?= lang('information') ?></span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">

                            <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
                            <div class="col-sm-6 col-md-4">
                                <label class="form-label fw-semibold small mb-1" for="warehouse"><?= lang('warehouse') ?> <span class="text-danger">*</span></label>
                                <?php
                                $wh[] = '';
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $Settings->default_warehouse), 'id="warehouse" class="form-control form-control-sm select" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required" style="width:100%;"');
                                ?>
                            </div>
                            <?php } else {
                                $warehouse_input = ['type' => 'hidden', 'name' => 'warehouse', 'id' => 'warehouse', 'value' => $this->session->userdata('warehouse_id')];
                                echo form_input($warehouse_input);
                            } ?>

                            <?php if ($Owner || $Admin) { ?>
                            <div class="col-sm-6 col-md-4">
                                <label class="form-label fw-semibold small mb-1" for="date"><?= lang('date') ?> <span class="text-danger">*</span></label>
                                <?php echo form_input('date', ($_POST['date'] ?? $this->sma->hrld(date('Y-m-d H:i:s'))), 'class="form-control form-control-sm" id="date" required="required"'); ?>
                            </div>
                            <?php } ?>

                            <div class="col-sm-6 col-md-4">
                                <label class="form-label fw-semibold small mb-1" for="ref"><?= lang('reference') ?></label>
                                <?php echo form_input('reference_no', ($_POST['reference_no'] ?? ''), 'class="form-control form-control-sm" id="ref"'); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Type -->
            <div class="col-12">
                <label class="form-label fw-semibold small mb-2"><?= lang('type') ?> <span class="text-danger">*</span></label>
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input type" type="radio" value="full" name="type" id="full" <?= $this->input->post('type') ? 'checked' : ''; ?> required>
                        <label class="form-check-label fw-semibold" for="full"><?= lang('full') ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input type" type="radio" value="partial" name="type" id="partial" <?= ($this->input->post('type') == 'partial') ? 'checked' : ''; ?>>
                        <label class="form-check-label fw-semibold" for="partial"><?= lang('partial') ?></label>
                    </div>
                </div>
            </div>

            <!-- Filtres partiels -->
            <div class="col-12 partials" style="display:none;">
                <div class="card border shadow-none rounded-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-warning border-opacity-50">
                        <i class="fa fa-filter text-warning fs-6"></i>
                        <span class="fw-bold small text-uppercase text-warning"><?= lang('filter') ?? 'Filtres' ?></span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="brand"><?= lang('brands') ?></label>
                                <?php
                                $bs = [];
                                foreach ($brands as $brand) { $bs[$brand->id] = $brand->name; }
                                echo form_dropdown('brand[]', $bs, ($_POST['brand'] ?? 0), 'id="brand" class="form-control form-control-sm select" data-placeholder="' . lang('select') . ' ' . lang('brand') . '" style="width:100%;" multiple');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="category"><?= lang('categories') ?></label>
                                <?php
                                $cs = [];
                                foreach ($categories as $category) { $cs[$category->id] = $category->name; }
                                echo form_dropdown('category[]', $cs, ($_POST['category'] ?? 0), 'id="category" class="form-control form-control-sm select" data-placeholder="' . lang('select') . ' ' . lang('category') . '" style="width:100%;" multiple');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="col-12 d-flex gap-2">
                <button type="submit" name="count_stock" value="1" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4">
                    <i class="fa fa-check"></i> <?= lang('submit') ?>
                </button>
                <button type="button" class="btn btn-outline-danger d-inline-flex align-items-center gap-2" id="reset">
                    <i class="fa fa-times"></i> <?= lang('reset') ?>
                </button>
            </div>

        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#brand option[value=''], #category option[value='']").remove();
        $('.type').on('change', function(){
            if ($(this).val() === 'partial')
                $('.partials').slideDown();
            else
                $('.partials').slideUp();
        });
        // Déclencher si partial déjà sélectionné au chargement
        $('.type:checked').trigger('change');
        $("#date").datetimepicker({format: site.dateFormats.js_ldate, fontAwesome: true, language: 'sma', weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0, startDate: "<?= $this->sma->hrld(date('Y-m-d H:i:s')); ?>"});

    });
</script>
