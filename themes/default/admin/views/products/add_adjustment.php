<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var count = 1, an = 1;
    var type_opt = {'addition': '<?= lang('addition'); ?>', 'subtraction': '<?= lang('subtraction'); ?>'};
    $(document).ready(function () {
        if (localStorage.getItem('remove_qals')) {
            if (localStorage.getItem('qaitems')) {
                localStorage.removeItem('qaitems');
            }
            if (localStorage.getItem('qaref')) {
                localStorage.removeItem('qaref');
            }
            if (localStorage.getItem('qawarehouse')) {
                localStorage.removeItem('qawarehouse');
            }
            if (localStorage.getItem('qanote')) {
                localStorage.removeItem('qanote');
            }
            if (localStorage.getItem('qadate')) {
                localStorage.removeItem('qadate');
            }
            localStorage.removeItem('remove_qals');
        }

        <?php if ($adjustment_items) {
    ?>
        localStorage.setItem('qaitems', JSON.stringify(<?= $adjustment_items; ?>));
        <?php
} ?>
        <?php if ($warehouse_id) {
        ?>
        localStorage.setItem('qawarehouse', '<?= $warehouse_id; ?>');
        $('#qawarehouse').select2('readonly', true);
        <?php
    } ?>

        <?php if ($Owner || $Admin) {
        ?>
        if (!localStorage.getItem('qadate')) {
            $("#qadate").datetimepicker({
                format: site.dateFormats.js_ldate,
                fontAwesome: true,
                language: 'sma',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0
            }).datetimepicker('update', new Date());
        }
        $(document).on('change', '#qadate', function (e) {
            localStorage.setItem('qadate', $(this).val());
        });
        if (qadate = localStorage.getItem('qadate')) {
            $('#qadate').val(qadate);
        }
        <?php
    } ?>

        $("#add_item").autocomplete({
            source: '<?= admin_url('products/qa_suggestions'); ?>',
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_adjustment_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
    });
</script>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center gap-2 py-2 px-3 bg-white border-bottom">
        <span class="bg-success bg-opacity-10 rounded-2 p-2 lh-1">
            <i class="fa fa-plus text-success"></i>
        </span>
        <h5 class="mb-0 fw-semibold"><?= lang('add_adjustment'); ?></h5>
    </div>
    <div class="card-body p-3 p-lg-4">
        <?php
        $attrib = ['role' => 'form'];
        echo admin_form_open_multipart('products/add_adjustment' . ($count_id ? '/' . $count_id : ''), $attrib);
        ?>
        <div class="row g-3">

            <!-- Identification -->
            <div class="col-12">
                <div class="card border shadow-none rounded-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-primary border-opacity-25">
                        <i class="fa fa-info-circle text-primary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-primary"><?= lang('information') ?></span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <?php if ($Owner || $Admin) { ?>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="qadate"><?= lang('date') ?> <span class="text-danger">*</span></label>
                                <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ''), 'class="form-control form-control-sm datetime" id="qadate" required="required"'); ?>
                            </div>
                            <?php } ?>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="qaref"><?= lang('reference_no') ?></label>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ''), 'class="form-control form-control-sm" id="qaref"'); ?>
                            </div>

                            <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="qawarehouse"><?= lang('warehouse') ?> <span class="text-danger">*</span></label>
                                <?php
                                $wh[''] = '';
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ($warehouse_id ? $warehouse_id : $Settings->default_warehouse)), 'id="qawarehouse" class="form-control form-control-sm select" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required" ' . ($warehouse_id ? 'readonly' : '') . ' style="width:100%;"'); ?>
                            </div>
                            <?php } else {
                                $warehouse_input = ['type' => 'hidden', 'name' => 'warehouse', 'id' => 'qawarehouse', 'value' => $this->session->userdata('warehouse_id')];
                                echo form_input($warehouse_input);
                            } ?>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="document"><?= lang('document') ?></label>
                                <input id="document" type="file" name="document" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recherche produit -->
            <div class="col-12">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa fa-barcode fa-lg"></i></span>
                    <?php echo form_input('add_item', '', 'class="form-control" id="add_item" placeholder="' . lang('add_product_to_order') . '"'); ?>
                </div>
            </div>

            <!-- Tableau produits -->
            <div class="col-12">
                <label class="form-label fw-semibold small mb-1"><?= lang('products') ?> <span class="text-danger">*</span></label>
                <div class="table-responsive">
                    <table id="qaTable" class="table table-bordered table-sm table-hover table-striped">
                        <thead class="table-light">
                        <tr>
                            <th><?= lang('product_name') . ' (' . lang('product_code') . ')'; ?></th>
                            <th style="width:15%"><?= lang('variant'); ?></th>
                            <th style="width:12%"><?= lang('type'); ?></th>
                            <th style="width:10%"><?= lang('quantity'); ?></th>
                            <?php if ($Settings->product_serial) { echo '<th>' . lang('serial_no') . '</th>'; } ?>
                            <th style="width:36px; text-align:center;"><i class="fa fa-trash-o text-muted"></i></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>

            <!-- Note -->
            <div class="col-12">
                <label class="form-label fw-semibold small mb-1" for="qanote"><?= lang('note') ?></label>
                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ''), 'class="form-control form-control-sm" id="qanote" rows="3"'); ?>
            </div>

            <!-- Boutons -->
            <div class="col-12 d-flex gap-2">
                <button type="submit" name="add_adjustment" value="1" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4">
                    <i class="fa fa-check"></i> <?= lang('submit') ?>
                </button>
                <button type="button" class="btn btn-outline-danger d-inline-flex align-items-center gap-2" id="reset">
                    <i class="fa fa-times"></i> <?= lang('reset') ?>
                </button>
            </div>

        </div>
        <?= form_hidden('count_id', $count_id); ?>
        <?php echo form_close(); ?>
    </div>
</div>
