<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!empty($variants)) {
    foreach ($variants as $variant) {
        $vars[] = addslashes($variant->name);
    }
} else {
    $vars = [];
}
?>
<style>
    /* === Select2 : taille identique aux form-control (Bootstrap 5 standard) === */
    .select2-container .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px) !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
        line-height: 1.5 !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        padding: 0 !important;
        font-size: 1rem !important;
        color: #212529;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: calc(1.5em + 0.75rem) !important;
        top: 0 !important;
    }

    .select2-container .select2-selection--single .select2-selection__clear {
        margin-top: 0 !important;
        font-size: 1rem;
        line-height: 1.5;
    }

    .select2-dropdown {
        font-size: 1rem !important;
        border-color: #ced4da !important;
    }

    .select2-search--dropdown .select2-search__field {
        font-size: 1rem !important;
        padding: 0.375rem 0.75rem !important;
        border-color: #ced4da !important;
        border-radius: 0.375rem;
    }

    .select2-results__option {
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #86b7fe !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25) !important;
        outline: none !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('.gen_slug').change(function (e) {
            console.log($(this).val());
            getSlug($(this).val(), 'products');
        });

        // Options select2 globales : recherche toujours visible, taille sm
        var s2opts = { minimumResultsForSearch: 0, width: '100%' };
        var s2clear = $.extend({}, s2opts, { allowClear: true, placeholder: ' ' });

        // Init tous les selects
        $('#type').select2(s2opts);
        $('#barcode_symbology').select2(s2opts);
        $('#brand').select2(s2clear);
        $('#category').select2(s2clear);
        $('#unit').select2(s2clear);
        $('#default_sale_unit').select2(s2opts);
        $('#default_purchase_unit').select2(s2opts);
        $('#tax_rate').select2(s2clear);
        $('#tax_method').select2(s2opts);
        $('#awarehouse').select2(s2opts);

        // Subcategory (chargé dynamiquement)
        $("#subcategory").select2("destroy").empty().select2($.extend({}, s2opts, {
            placeholder: "<?= lang('select_category_to_load') ?>",
            data: [{ id: '', text: '<?= lang('select_category_to_load') ?>' }]
        }));

        $('#category').on('change', function () {
            var v = $(this).val();
            $('#modal-loading').show();
            if (v) {
                $.ajax({
                    type: "get", async: false,
                    url: "<?= admin_url('products/getSubCategories') ?>/" + v,
                    dataType: "json",
                    success: function (scdata) {
                        if (scdata != null) {
                            scdata.push({ id: '', text: '<?= lang('select_subcategory') ?>' });
                            $("#subcategory").select2("destroy").empty().select2($.extend({}, s2opts, {
                                placeholder: "<?= lang('select_subcategory') ?>",
                                data: scdata
                            }));
                        } else {
                            $("#subcategory").select2("destroy").empty().select2($.extend({}, s2opts, {
                                placeholder: "<?= lang('no_subcategory') ?>",
                                data: [{ id: '', text: '<?= lang('no_subcategory') ?>' }]
                            }));
                        }
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_error') ?>');
                        $('#modal-loading').hide();
                    }
                });
            } else {
                $("#subcategory").select2("destroy").empty().select2($.extend({}, s2opts, {
                    placeholder: "<?= lang('select_category_to_load') ?>",
                    data: [{ id: '', text: '<?= lang('select_category_to_load') ?>' }]
                }));
            }
            $('#modal-loading').hide();
        });

        $('#code').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center gap-2 py-3 border-bottom bg-white rounded-top-3">
        <span class="bg-primary bg-opacity-10 rounded-2 p-2 lh-1">
            <i class="fa fa-plus text-primary"></i>
        </span>
        <h5 class="mb-0 fw-semibold"><?= lang('add_product') ?></h5>
    </div>
    <div class="card-body p-4">

        <?php
        $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('products/add', $attrib);
        ?>

        <div class="row g-3">

            <!-- ══════════════════════════════
                 COLONNE PRINCIPALE (col-lg-8)
            ══════════════════════════════ -->
            <div class="col-lg-8">

                <!-- ── Identification ── -->
                <div class="card border shadow-none rounded-3 mb-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-primary border-opacity-25">
                        <i class="fa fa-tag text-primary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-primary ls-1">Identification</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="name"><?= lang('product_name') ?> <span class="text-danger">*</span></label>
                                <?= form_input('name', ($_POST['name'] ?? ($product ? $product->name : '')), 'class="form-control form-control-sm' . ($Settings->use_code_for_slug ? '' : ' gen_slug') . '" id="name" required="required"'); ?>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="second_name"><?= lang('Autre nom') ?></label>
                                <?= form_input('second_name', set_value('second_name'), 'class="form-control form-control-sm" id="second_name"'); ?>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="code"><?= lang('product_code') ?> <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <?= form_input('code', ($_POST['code'] ?? ($product ? $product->code : '')), 'class="form-control form-control-sm' . ($Settings->use_code_for_slug ? ' gen_slug' : '') . '" id="code" required="required"') ?>
                                    <span class="input-group-text" id="random_num" style="cursor:pointer;" title="<?= lang('generate') ?>">
                                        <i class="fa fa-random"></i>
                                    </span>
                                </div>
                                <div class="form-text small"><?= lang('you_scan_your_barcode_too') ?></div>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="slug"><?= lang('lien') ?> <span class="text-danger">*</span></label>
                                <?= form_input('slug', set_value('slug'), 'class="form-control form-control-sm" id="slug" required="required"'); ?>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="barcode_symbology"><?= lang('Code barre') ?> <span class="text-danger">*</span></label>
                                <?php
                                $bs = ['code25' => 'Code25', 'code39' => 'Code39', 'code128' => 'Code128', 'ean8' => 'EAN8', 'ean13' => 'EAN13', 'upca' => 'UPC-A', 'upce' => 'UPC-E'];
                                echo form_dropdown('barcode_symbology', $bs, ($_POST['barcode_symbology'] ?? ($product ? $product->barcode_symbology : 'code128')), 'class="form-select form-select-sm" id="barcode_symbology" required="required"');
                                ?>
                            </div>

                            <div class="col-sm-6 standard_combo">
                                <label class="form-label fw-semibold small mb-1" for="weight"><?= lang('Poids') ?></label>
                                <?= form_input('weight', set_value('weight'), 'class="form-control form-control-sm" id="weight"'); ?>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="brand"><?= lang('brand') ?></label>
                                <?php
                                $br[''] = '';
                                foreach ($brands as $brand) {
                                    $br[$brand->id] = $brand->name;
                                }
                                echo form_dropdown('brand', $br, ($_POST['brand'] ?? ($product ? $product->brand : '')), 'class="form-select form-select-sm" id="brand"')
                                ?>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="category"><?= lang('category') ?> <span class="text-danger">*</span></label>
                                <?php
                                $cat[''] = '';
                                foreach ($categories as $category) {
                                    $cat[$category->id] = $category->name;
                                }
                                echo form_dropdown('category', $cat, ($_POST['category'] ?? ($product ? $product->category_id : '')), 'class="form-select form-select-sm" id="category" required="required"')
                                ?>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold small mb-1" for="subcategory"><?= lang('subcategory') ?></label>
                                <div id="subcat_data"><?php
                                echo form_input('subcategory', ($product ? $product->subcategory_id : ''), 'class="form-control form-control-sm" id="subcategory" placeholder="' . lang('select_category_to_load') . '"');
                                ?></div>
                            </div>

                        </div>
                    </div>
                </div><!-- /card identification -->

                <!-- ── Variantes (standard) ── -->
                <div class="card border shadow-none rounded-3 mb-3 standard">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-secondary border-opacity-25">
                        <i class="fa fa-list-ul text-secondary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-secondary">Variantes</span>
                    </div>
                    <div class="card-body p-3">
                        <div id="attrs"></div>
                        <div class="d-flex align-items-center justify-content-between rounded-2 border px-3 py-2 mb-3" style="background:#f8f9fc;">
                            <div>
                                <div class="fw-semibold small"><?= lang('product_has_attributes') ?></div>
                                <div class="text-muted" style="font-size:0.78rem;"><?= lang('eg_sizes_colors') ?></div>
                            </div>
                            <div class="form-check form-switch mb-0 ms-3">
                                <input type="checkbox" class="form-check-input" role="switch" name="attributes" id="attributes"
                                    <?= $this->input->post('attributes') || $product_options ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="attributes"></label>
                            </div>
                        </div>
                        <div id="attr-con" style="<?= $this->input->post('attributes') || $product_options ? '' : 'display:none;'; ?>">
                            <div class="mb-2" id="ui">
                                <div class="input-group input-group-sm">
                                    <?php echo form_input('attributesInput', '', 'class="form-control form-control-sm select-tags" id="attributesInput" placeholder="' . $this->lang->line('enter_attributes') . '"'); ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="addAttributes">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="attrTable" class="table table-bordered table-sm table-striped mb-0"
                                    style="<?= $this->input->post('attributes') || $product_options ? '' : 'display:none;'; ?>margin-top:8px;">
                                    <thead>
                                        <tr>
                                            <th><?= lang('name') ?></th>
                                            <th><?= lang('warehouse') ?></th>
                                            <th><?= lang('price_addition') ?></th>
                                            <th><i class="fa fa-times attr-remove-all" style="cursor:pointer;"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody><?php
                                    if ($this->input->post('attributes')) {
                                        $a = sizeof($_POST['attr_name']);
                                        for ($r = 0; $r <= $a; $r++) {
                                            if (isset($_POST['attr_name'][$r]) && (isset($_POST['attr_warehouse'][$r]) || isset($_POST['attr_quantity'][$r]))) {
                                                echo '<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' . $_POST['attr_name'][$r] . '"><span>' . $_POST['attr_name'][$r] . '</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value="' . $_POST['attr_warehouse'][$r] . '"><input type="hidden" name="attr_wh_name[]" value="' . $_POST['attr_wh_name'][$r] . '"><span>' . $_POST['attr_wh_name'][$r] . '</span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="' . $_POST['attr_price'][$r] . '"><span>' . $_POST['attr_price'][$r] . '</span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>';
                                            }
                                        }
                                    } elseif ($product_options) {
                                        foreach ($product_options as $option) {
                                            echo '<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' . $option->name . '"><span>' . $option->name . '</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value="' . $option->warehouse_id . '"><input type="hidden" name="attr_wh_name[]" value="' . $option->wh_name . '"><span>' . $option->wh_name . '</span></td><td class="quantity text-center"><input type="hidden" name="attr_quantity[]" value="' . $this->sma->formatQuantityDecimal($option->wh_qty) . '"><span>' . $this->sma->formatQuantity($option->wh_qty) . '</span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="' . $this->sma->formatMoney($option->price) . '"><span>' . $this->sma->formatMoney($option->price) . '</span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>';
                                        }
                                    }
                                    ?></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /card variantes -->

                <!-- ── Combo ── -->
                <div class="card border shadow-none rounded-3 mb-3 combo" style="display:none;">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-warning border-opacity-25">
                        <i class="fa fa-cubes text-warning fs-6"></i>
                        <span class="fw-bold small text-uppercase text-warning">Combo</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small mb-1" for="add_item"><?= lang('add_product') . ' (' . lang('not_with_variants') . ')' ?></label>
                            <?= form_input('add_item', '', 'class="form-control form-control-sm" id="add_item" placeholder="' . $this->lang->line('add_item') . '"') ?>
                        </div>
                        <label class="form-label fw-semibold small"><?= lang('combo_products') ?></label>
                        <div class="table-responsive">
                            <table id="prTable" class="table items table-striped table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th><?= lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')'; ?></th>
                                        <th><?= lang('quantity'); ?></th>
                                        <th><?= lang('unit_price'); ?></th>
                                        <th class="text-center"><i class="fa fa-trash-o" style="opacity:0.5;"></i></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /card combo -->

                <!-- ── Digital ── -->
                <div class="card border shadow-none rounded-3 mb-3 digital" style="display:none;">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-info border-opacity-25">
                        <i class="fa fa-download text-info fs-6"></i>
                        <span class="fw-bold small text-uppercase text-info">Digital</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small mb-1" for="digital_file"><?= lang('digital_file') ?></label>
                            <input id="digital_file" type="file" data-browse-label="<?= lang('browse'); ?>"
                                name="digital_file" data-show-upload="false" data-show-preview="false"
                                class="form-control form-control-sm file">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold small mb-1" for="file_link"><?= lang('file_link') ?></label>
                            <?= form_input('file_link', set_value('file_link'), 'class="form-control form-control-sm" id="file_link"'); ?>
                        </div>
                    </div>
                </div><!-- /card digital -->

                <!-- ── Fournisseur (standard) ── -->
                <div class="card border shadow-none rounded-3 mb-3 standard">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-secondary border-opacity-25">
                        <i class="fa fa-truck text-secondary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-secondary"><?= lang('supplier') ?></span>
                        <button type="button" class="btn btn-sm btn-outline-primary ms-auto py-0 px-2" id="addSupplier">
                            <i class="fa fa-plus me-1"></i><?= lang('add') ?>
                        </button>
                    </div>
                    <div class="card-body p-3">
                        <div id="supplier-con">
                            <div class="mb-2">
                                <?php
                                echo form_input('supplier', ($_POST['supplier'] ?? ''), 'class="form-control form-control-sm ' . ($product ? '' : 'suppliers') . '" id="' . ($product && !empty($product->supplier1) ? 'supplier1' : 'supplier') . '" placeholder="' . lang('select') . ' ' . lang('supplier') . '" style="width:100%;"');
                                ?>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <?= form_input('supplier_part_no', ($_POST['supplier_part_no'] ?? ''), 'class="form-control form-control-sm" id="supplier_part_no" placeholder="' . lang('supplier_part_no') . '"'); ?>
                                </div>
                                <div class="col-6">
                                    <?= form_input('supplier_price', ($_POST['supplier_price'] ?? ''), 'class="form-control form-control-sm" id="supplier_price" placeholder="' . lang('supplier_price') . '"'); ?>
                                </div>
                            </div>
                        </div>
                        <div id="ex-suppliers"></div>
                    </div>
                </div><!-- /card fournisseur -->

                <!-- ── Descriptions ── -->
                <div class="card border shadow-none rounded-3 mb-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-secondary border-opacity-25">
                        <i class="fa fa-align-left text-secondary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-secondary">Descriptions</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-lg-6 all">
                                <label class="form-label fw-semibold small mb-1" for="product_details"><?= lang('product_details') ?></label>
                                <?= form_textarea('product_details', ($_POST['product_details'] ?? ($product ? $product->product_details : '')), 'class="form-control form-control-sm" id="product_details" rows="4"'); ?>
                            </div>
                            <div class="col-lg-6 all">
                                <label class="form-label fw-semibold small mb-1" for="details"><?= lang('product_details_for_invoice') ?></label>
                                <?= form_textarea('details', ($_POST['details'] ?? ($product ? $product->details : '')), 'class="form-control form-control-sm" id="details" rows="4"'); ?>
                            </div>
                        </div>
                    </div>
                </div><!-- /card descriptions -->

            </div><!-- /col-lg-8 -->

            <!-- ══════════════════════════════
                 SIDEBAR (col-lg-4)
            ══════════════════════════════ -->
            <div class="col-lg-4">

                <!-- ── Type de produit ── -->
                <div class="card border shadow-none rounded-3 mb-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-primary border-opacity-25">
                        <i class="fa fa-tag text-primary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-primary"><?= lang('product_type') ?></span>
                    </div>
                    <div class="card-body p-3">
                        <?php
                        $opts = ['standard' => lang('standard'), 'combo' => lang('combo'), 'digital' => lang('digital'), 'service' => lang('service')];
                        echo form_dropdown('type', $opts, ($_POST['type'] ?? ($product ? $product->type : '')), 'class="form-select form-select-sm" id="type" required="required"');
                        ?>
                    </div>
                </div><!-- /card type -->

                <!-- ── Tarification ── -->
                <div class="card border shadow-none rounded-3 mb-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-success border-opacity-25">
                        <i class="fa fa-dollar text-success fs-6"></i>
                        <span class="fw-bold small text-uppercase text-success">Tarification</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">

                            <div class="col-12 standard">
                                <label class="form-label fw-semibold small mb-1" for="unit"><?= lang('product_unit') ?> <span class="text-danger">*</span></label>
                                <?php
                                $pu[''] = lang('select') . ' ' . lang('unit');
                                foreach ($base_units as $bu) {
                                    $pu[$bu->id] = $bu->name . ' (' . $bu->code . ')';
                                }
                                ?>
                                <?= form_dropdown('unit', $pu, set_value('unit', ($product ? $product->unit : '')), 'class="form-select form-select-sm" id="unit" required="required"'); ?>
                            </div>

                            <div class="col-6 standard">
                                <label class="form-label fw-semibold small mb-1" for="default_sale_unit"><?= lang('default_sale_unit') ?></label>
                                <?php $uopts[''] = lang('select_unit_first'); ?>
                                <?= form_dropdown('default_sale_unit', $uopts, ($product ? $product->sale_unit : ''), 'class="form-select form-select-sm" id="default_sale_unit"'); ?>
                            </div>

                            <div class="col-6 standard">
                                <label class="form-label fw-semibold small mb-1" for="default_purchase_unit"><?= lang('default_purchase_unit') ?></label>
                                <?= form_dropdown('default_purchase_unit', $uopts, ($product ? $product->purchase_unit : ''), 'class="form-select form-select-sm" id="default_purchase_unit"'); ?>
                            </div>

                            <div class="col-6 standard">
                                <label class="form-label fw-semibold small mb-1" for="cost"><?= lang('product_cost') ?> <span class="text-danger">*</span></label>
                                <?= form_input('cost', ($_POST['cost'] ?? ($product ? $this->sma->formatDecimal($product->cost) : '')), 'class="form-control form-control-sm" id="cost" required="required"') ?>
                            </div>

                            <div class="col-6 all">
                                <label class="form-label fw-semibold small mb-1" for="price"><?= lang('Prix de vente') ?> <span class="text-danger">*</span></label>
                                <?= form_input('price', ($_POST['price'] ?? ($product ? $this->sma->formatDecimal($product->price) : '')), 'class="form-control form-control-sm" id="price" required="required"') ?>
                            </div>

                            <div class="col-12 standard">
                                <label class="form-label fw-semibold small mb-1" for="alert_quantity"><?= lang('alert_quantity') ?></label>
                                <div class="input-group input-group-sm">
                                    <?= form_input('alert_quantity', ($_POST['alert_quantity'] ?? ($product ? $this->sma->formatQuantityDecimal($product->alert_quantity) : '')), 'class="form-control form-control-sm" id="alert_quantity"') ?>
                                    <span class="input-group-text">
                                        <input type="checkbox" class="form-check-input mt-0" name="track_quantity"
                                            id="track_quantity" value="1" <?= ($product ? (isset($product->track_quantity) ? 'checked' : '') : 'checked') ?>>
                                        <label class="form-check-label ms-1 small" for="track_quantity"><?= lang('track') ?></label>
                                    </span>
                                </div>
                            </div>

                            <?php if ($Settings->tax1) { ?>
                                <div class="col-6 all">
                                    <label class="form-label fw-semibold small mb-1" for="tax_rate"><?= lang('product_tax') ?></label>
                                    <?php
                                    $tr[''] = '';
                                    foreach ($tax_rates as $tax) {
                                        $tr[$tax->id] = $tax->name;
                                    }
                                    echo form_dropdown('tax_rate', $tr, ($_POST['tax_rate'] ?? ($product ? $product->tax_rate : $Settings->default_tax_rate)), 'class="form-select form-select-sm" id="tax_rate"')
                                    ?>
                                </div>
                                <div class="col-6 all">
                                    <label class="form-label fw-semibold small mb-1" for="tax_method"><?= lang('tax_method') ?></label>
                                    <?php
                                    $tm = ['1' => lang('exclusive'), '0' => lang('inclusive')];
                                    echo form_dropdown('tax_method', $tm, ($_POST['tax_method'] ?? ($product ? $product->tax_method : '')), 'class="form-select form-select-sm" id="tax_method"'); ?>
                                </div>
                            <?php } ?>

                            <?php if ($Settings->invoice_view == 2) { ?>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small mb-1" for="hsn_code"><?= lang('hsn_code') ?></label>
                                    <?= form_input('hsn_code', set_value('hsn_code', ($product ? $product->hsn_code : '')), 'class="form-control form-control-sm" id="hsn_code"'); ?>
                                </div>
                            <?php } ?>

                        </div>

                        <!-- Promotion -->
                        <div class="border-top mt-3 pt-3">
                            <div class="d-flex align-items-center justify-content-between rounded-2 border px-3 py-2 mb-2" style="background:#f8f9fc;">
                                <div class="fw-semibold small"><?= lang('promotion') ?></div>
                                <div class="form-check form-switch mb-0 ms-3">
                                    <input type="checkbox" class="form-check-input" role="switch" value="1" name="promotion"
                                        id="promotion" <?= $this->input->post('promotion') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="promotion"></label>
                                </div>
                            </div>
                            <div id="promo" class="rounded-2 bg-light p-2" style="display:none;">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small mb-1" for="promo_price"><?= lang('promo_price') ?></label>
                                        <?= form_input('promo_price', set_value('promo_price'), 'class="form-control form-control-sm" id="promo_price"'); ?>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small mb-1" for="start_date"><?= lang('start_date') ?></label>
                                        <?= form_input('start_date', set_value('start_date'), 'class="form-control form-control-sm tip date" id="start_date"'); ?>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small mb-1" for="end_date"><?= lang('end_date') ?></label>
                                        <?= form_input('end_date', set_value('end_date'), 'class="form-control form-control-sm tip date" id="end_date"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- /card tarification -->

                <!-- ── Images ── -->
                <div class="card border shadow-none rounded-3 mb-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-info border-opacity-25">
                        <i class="fa fa-image text-info fs-6"></i>
                        <span class="fw-bold small text-uppercase text-info">Images</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-2 all">
                            <label class="form-label fw-semibold small mb-1" for="product_image"><?= lang('product_image') ?></label>
                            <input id="product_image" type="file" data-browse-label="<?= lang('browse'); ?>"
                                name="product_image" data-show-upload="false" data-show-preview="false"
                                accept="image/*" class="form-control form-control-sm file">
                        </div>
                        <div class="mb-2 all">
                            <label class="form-label fw-semibold small mb-1" for="images"><?= lang('product_gallery_images') ?></label>
                            <input id="images" type="file" data-browse-label="<?= lang('browse'); ?>"
                                name="userfile[]" multiple="true" data-show-upload="false" data-show-preview="false"
                                class="form-control form-control-sm file" accept="image/*">
                        </div>
                        <div id="img-details"></div>
                    </div>
                </div><!-- /card images -->

                <!-- ── Options ── -->
                <div class="card border shadow-none rounded-3 mb-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-secondary border-opacity-25">
                        <i class="fa fa-cogs text-secondary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-secondary">Options</span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-bottom-3">
                            <li class="list-group-item d-flex align-items-center justify-content-between px-3 py-2">
                                <label class="form-check-label small fw-semibold mb-0" for="featured"><?= lang('Sponorisé') ?></label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" name="featured" id="featured" value="1"
                                        <?= isset($_POST['featured']) ? 'checked' : '' ?>>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center justify-content-between px-3 py-2">
                                <label class="form-check-label small fw-semibold mb-0" for="hide_pos"><?= lang('Masquer en POS') ?></label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" name="hide_pos" id="hide_pos" value="1"
                                        <?= isset($_POST['hide_pos']) ? 'checked' : '' ?>>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center justify-content-between px-3 py-2">
                                <label class="form-check-label small fw-semibold mb-0" for="hide"><?= lang('Masquer dans shop') ?></label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" name="hide" id="hide" value="1"
                                        <?= isset($_POST['hide']) ? 'checked' : '' ?>>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center justify-content-between px-3 py-2">
                                <label class="form-check-label small fw-semibold mb-0" for="extras"><?= lang('custom_fields') ?></label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" name="cf" id="extras" value=""
                                        <?= isset($_POST['cf']) ? 'checked' : '' ?>>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div><!-- /card options -->

                <!-- ── Champs personnalisés ── -->
                <div class="card border shadow-none rounded-3 mb-3" id="extras-con" style="display:none;">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-secondary border-opacity-25">
                        <i class="fa fa-sliders text-secondary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-secondary"><?= lang('custom_fields') ?></span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <?php foreach (['cf1','cf2','cf3','cf4','cf5','cf6'] as $cf): $cfn = str_replace('cf','pcf',$cf); ?>
                            <div class="col-6 all">
                                <label class="form-label fw-semibold small mb-1" for="<?= $cf ?>"><?= lang($cfn) ?></label>
                                <?= form_input($cf, ($_POST[$cf] ?? ($product ? $product->$cf : '')), 'class="form-control form-control-sm" id="' . $cf . '"') ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div><!-- /card custom fields -->

                <!-- ── Bouton submit ── -->
                <div class="d-grid">
                    <button type="submit" name="add_product" class="btn btn-primary">
                        <i class="fa fa-check me-1"></i><?= lang('add_product') ?>
                    </button>
                </div>

            </div><!-- /col-lg-4 sidebar -->

        </div><!-- /row g-3 -->

        <?= form_close() ?>

    </div><!-- /card-body main -->
</div><!-- /card main -->

<script type="text/javascript">
    $(document).ready(function () {
        $('form[data-toggle="validator"]').bootstrapValidator({ excluded: [':disabled'] });
        var audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3');
        var audio_error = new Audio('<?= $assets ?>sounds/sound3.mp3');
        var items = {};
        <?php
        if ($combo_items) {
            foreach ($combo_items as $item) {
                //echo 'ietms['.$item->id.'] = '.$item.';';
                if ($item->code) {
                    echo 'add_product_item(' . json_encode($item) . ');';
                }
            }
        }
        ?>
        <?= isset($_POST['cf']) ? '$("#extras").iCheck("check");' : '' ?>
        $('#extras').on('ifChecked', function () {
            $('#extras-con').slideDown();
        });
        $('#extras').on('ifUnchecked', function () {
            $('#extras-con').slideUp();
        });
        // Bootstrap 5 form-switch fallback
        $('#extras').on('change', function () {
            $(this).is(':checked') ? $('#extras-con').slideDown() : $('#extras-con').slideUp();
        });

        <?= isset($_POST['promotion']) ? '$("#promotion").iCheck("check");' : '' ?>
        $('#promotion').on('ifChecked', function (e) {
            $('#promo').slideDown();
        });
        $('#promotion').on('ifUnchecked', function (e) {
            $('#promo').slideUp();
        });
        // Bootstrap 5 form-switch fallback
        $('#promotion').on('change', function () {
            $(this).is(':checked') ? $('#promo').slideDown() : $('#promo').slideUp();
        });

        $('.attributes').on('ifChecked', function (event) {
            $('#options_' + $(this).attr('id')).slideDown();
        });
        $('.attributes').on('ifUnchecked', function (event) {
            $('#options_' + $(this).attr('id')).slideUp();
        });
        //$('#cost').removeAttr('required');
        $('#digital_file').change(function () {
            if ($(this).val()) {
                $('#file_link').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'file_link');
            } else {
                $('#file_link').attr('required', 'required');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'file_link');
            }
        });
        $('#type').change(function () {
            var t = $(this).val();
            if (t !== 'standard') {
                $('.standard').slideUp();
                $('#unit').attr('disabled', true);
                $('#cost').attr('disabled', true);
                $('#track_quantity').iCheck('uncheck');
            } else {
                $('.standard').slideDown();
                $('#track_quantity').iCheck('check');
                $('#unit').attr('disabled', false);
                $('#cost').attr('disabled', false);
            }
            if (t !== 'digital') {
                $('.digital').slideUp();
                $('#file_link').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'file_link');
            } else {
                $('.digital').slideDown();
                $('#file_link').attr('required', 'required');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'file_link');
            }
            if (t !== 'combo') {
                $('.combo').slideUp();
            } else {
                $('.combo').slideDown();
            }
            if (t == 'standard' || t == 'combo') {
                $('.standard_combo').slideDown();
            } else {
                $('.standard_combo').slideUp();
            }
        });

        var t = $('#type').val();
        if (t !== 'standard') {
            $('.standard').slideUp();
            $('#unit').attr('disabled', true);
            $('#cost').attr('disabled', true);
            $('#track_quantity').iCheck('uncheck');
        } else {
            $('.standard').slideDown();
            $('#track_quantity').iCheck('check');
            $('#unit').attr('disabled', false);
            $('#cost').attr('disabled', false);
        }
        if (t !== 'digital') {
            $('.digital').slideUp();
            $('#file_link').removeAttr('required');
            $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'file_link');
        } else {
            $('.digital').slideDown();
            $('#file_link').attr('required', 'required');
            $('form[data-toggle="validator"]').bootstrapValidator('addField', 'file_link');
        }
        if (t !== 'combo') {
            $('.combo').slideUp();
        } else {
            $('.combo').slideDown();
        }
        if (t == 'standard' || t == 'combo') {
            $('.standard_combo').slideDown();
        } else {
            $('.standard_combo').slideUp();
        }

        $("#add_item").autocomplete({
            source: '<?= admin_url('products/suggestions'); ?>',
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');

                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_product_item(ui.item);
                    if (row) {
                        $(this).val('');
                    }
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>');
                }
            }
        });

        <?php
        if ($this->input->post('type') == 'combo') {
            $c = isset($_POST['combo_item_code']) ? sizeof($_POST['combo_item_code']) : 0;
            for ($r = 0; $r <= $c; $r++) {
                if (isset($_POST['combo_item_code'][$r]) && isset($_POST['combo_item_quantity'][$r]) && isset($_POST['combo_item_price'][$r])) {
                    $items[] = ['id' => $_POST['combo_item_id'][$r], 'name' => $_POST['combo_item_name'][$r], 'code' => $_POST['combo_item_code'][$r], 'qty' => $_POST['combo_item_quantity'][$r], 'price' => $_POST['combo_item_price'][$r]];
                }
            }
            echo '
            var ci = ' . (isset($items) ? json_encode($items) : "''") . ';
            $.each(ci, function() { add_product_item(this); });
            ';
        }
        ?>
        function add_product_item(item) {
            if (item == null) {
                return false;
            }
            item_id = item.id;
            if (items[item_id]) {
                items[item_id].qty = (parseFloat(items[item_id].qty) + 1).toFixed(2);
            } else {
                items[item_id] = item;
            }
            var pp = 0;
            $("#prTable tbody").empty();
            $.each(items, function () {
                var row_no = this.id;
                var newTr = $('<tr id="row_' + row_no + '" class="item_' + this.id + '" data-item-id="' + row_no + '"></tr>');
                tr_html = '<td><input name="combo_item_id[]" type="hidden" value="' + this.id + '"><input name="combo_item_name[]" type="hidden" value="' + this.name + '"><input name="combo_item_code[]" type="hidden" value="' + this.code + '"><span id="name_' + row_no + '">' + this.code + ' - ' + this.name + '</span></td>';
                tr_html += '<td><input class="form-control-sm text-center rquantity" name="combo_item_quantity[]" type="text" value="' + formatDecimal(this.qty) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                tr_html += '<td><input class="form-control-sm text-center rprice" name="combo_item_price[]" type="text" value="' + formatDecimal(this.price) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="combo_item_price_' + row_no + '" onClick="this.select();"></td>';
                tr_html += '<td class="text-center"><i class="fa fa-times tip del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                newTr.html(tr_html);
                newTr.prependTo("#prTable");
                pp += formatDecimal(parseFloat(this.price) * parseFloat(this.qty));
            });
            $('.item_' + item_id).addClass('warning');
            $('#price').val(pp);
            return true;
        }

        function calculate_price() {
            var rows = $('#prTable').children('tbody').children('tr');
            var pp = 0;
            $.each(rows, function () {
                pp += formatDecimal(parseFloat($(this).find('.rprice').val()) * parseFloat($(this).find('.rquantity').val()));
            });
            $('#price').val(pp);
            return true;
        }

        $(document).on('change', '.rquantity, .rprice', function () {
            calculate_price();
        });

        $(document).on('click', '.del', function () {
            var id = $(this).attr('id');
            delete items[id];
            $(this).closest('#row_' + id).remove();
            calculate_price();
        });
        var su = 2;
        $('#addSupplier').click(function () {
            if (su <= 5) {
                $('#supplier_1').select2('destroy');
                var html = '<div style="clear:both;height:5px;"></div><div class="row"><div class="col-12"><div class="mb-3"><input type="hidden" name="supplier_' + su + '", class="form-control-sm" id="supplier_' + su + '" placeholder="<?= lang('select') . ' ' . lang('supplier') ?>" style="width:100%;display: block !important;" /></div></div><div class="col-6"><div class="mb-3"><input type="text" name="supplier_' + su + '_part_no" class="form-control-sm" id="supplier_' + su + '_part_no" placeholder="<?= lang('supplier_part_no') ?>" /></div></div><div class="col-6"><div class="mb-3"><input type="text" name="supplier_' + su + '_price" class="form-control-sm" id="supplier_' + su + '_price" placeholder="<?= lang('supplier_price') ?>" /></div></div></div>';
                $('#ex-suppliers').append(html);
                var sup = $('#supplier_' + su);
                suppliers(sup);
                su++;
            } else {
                bootbox.alert('<?= lang('max_reached') ?>');
                return false;
            }
        });

        var _URL = window.URL || window.webkitURL;
        $("input#images").on('change.bs.fileinput', function () {
            var ele = document.getElementById($(this).attr('id'));
            var result = ele.files;
            $('#img-details').empty();
            for (var x = 0; x < result.length; x++) {
                var fle = result[x];
                for (var i = 0; i <= result.length; i++) {
                    var img = new Image();
                    img.onload = (function (value) {
                        return function () {
                            ctx[value].drawImage(result[value], 0, 0);
                        }
                    })(i);
                    img.src = 'images/' + result[i];
                }
            }
        });
        var variants = <?= json_encode($vars); ?>;
        $(".select-tags").select2({
            tags: variants,
            tokenSeparators: [","],
            multiple: true
        });
        $(document).on('ifChecked', '#attributes', function (e) {
            $('#attr-con').slideDown();
        });
        $(document).on('ifUnchecked', '#attributes', function (e) {
            $(".select-tags").select2("val", "");
            $('.attr-remove-all').trigger('click');
            $('#attr-con').slideUp();
        });
        // Bootstrap 5 form-switch fallback
        $(document).on('change', '#attributes', function () {
            if ($(this).is(':checked')) {
                $('#attr-con').slideDown();
            } else {
                $(".select-tags").select2("val", "");
                $('.attr-remove-all').trigger('click');
                $('#attr-con').slideUp();
            }
        });
        $('#addAttributes').click(function (e) {
            e.preventDefault();
            var attrs_val = $('#attributesInput').val(), attrs;
            attrs = attrs_val.split(',');
            for (var i in attrs) {
                if (attrs[i] !== '') {
                    <?php if (!empty($warehouses)) {
                        foreach ($warehouses as $warehouse) {
                            echo '$(\'#attrTable\').show().append(\'<tr class="attr"><td><input type="hidden" name="attr_name[]" value="\' + attrs[i] + \'"><span>\' + attrs[i] + \'</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value="' . $warehouse->id . '"><span>' . $warehouse->name . '</span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="0"><span>0</span></span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>\');';
                            // echo '$(\'#attrTable\').show().append(\'<tr class="attr"><td><input type="hidden" name="attr_name[]" value="\' + attrs[i] + \'"><span>\' + attrs[i] + \'</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value="' . $warehouse->id . '"><span>' . $warehouse->name . '</span></td><td class="quantity text-center"><input type="hidden" name="attr_quantity[]" value="0"><span>0</span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="0"><span>0</span></span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>\');';
                        }
                    } else {
                        ?>
                        $('#attrTable').show().append('<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' + attrs[i] + '"><span>' + attrs[i] + '</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value=""><span></span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="0"><span>0</span></span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>');
                        // $('#attrTable').show().append('<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' + attrs[i] + '"><span>' + attrs[i] + '</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value=""><span></span></td><td class="quantity text-center"><input type="hidden" name="attr_quantity[]" value="0"><span></span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="0"><span>0</span></span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>');
                        <?php
                    } ?>
                }
            }
        });
        //$('#attributesInput').on('select2-blur', function(){
        //    $('#addAttributes').click();
        //});
        $(document).on('click', '.delAttr', function () {
            $(this).closest("tr").remove();
        });
        $(document).on('click', '.attr-remove-all', function () {
            $('#attrTable tbody').empty();
            $('#attrTable').hide();
        });
        var row, warehouses = <?= json_encode($warehouses); ?>;
        $(document).on('click', '.attr td:not(:last-child)', function () {
            row = $(this).closest("tr");
            $('#aModalLabel').text(row.children().eq(0).find('span').text());
            $('#awarehouse').select2("val", (row.children().eq(1).find('input').val()));
            // $('#aquantity').val(row.children().eq(2).find('input').val());
            $('#aprice').val(row.children().eq(3).find('span').text());
            $('#aModal').appendTo('body').modal('show');
        });

        // $('#aModal').on('shown.bs.modal', function () {
        //     $('#aquantity').focus();
        //     $(this).keypress(function( e ) {
        //         if ( e.which == 13 ) {
        //             $('#updateAttr').click();
        //         }
        //     });
        // });
        $(document).on('click', '#updateAttr', function () {
            var wh = $('#awarehouse').val(), wh_name;
            $.each(warehouses, function () {
                if (this.id == wh) {
                    wh_name = this.name;
                }
            });
            row.children().eq(1).html('<input type="hidden" name="attr_warehouse[]" value="' + wh + '"><input type="hidden" name="attr_wh_name[]" value="' + wh_name + '"><span>' + wh_name + '</span>');
            // row.children().eq(2).html('<input type="hidden" name="attr_quantity[]" value="' + ($('#aquantity').val() ? $('#aquantity').val() : 0) + '"><span>' + decimalFormat($('#aquantity').val()) + '</span>');
            // row.children().eq(3).html('<input type="hidden" name="attr_price[]" value="' + $('#aprice').val() + '"><span>' + currencyFormat($('#aprice').val()) + '</span>');
            row.children().eq(2).html('<input type="hidden" name="attr_price[]" value="' + $('#aprice').val() + '"><span>' + currencyFormat($('#aprice').val()) + '</span>');
            $('#aModal').modal('hide');
        });
    });

    <?php if ($product) {
        ?>
        $(document).ready(function () {
            var t = "<?= $product->type ?>";
            if (t !== 'standard') {
                $('.standard').slideUp();
                $('#cost').attr('required', 'required');
                $('#track_quantity').iCheck('uncheck');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'cost');
            } else {
                $('.standard').slideDown();
                $('#track_quantity').iCheck('check');
                $('#cost').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'cost');
            }
            if (t !== 'digital') {
                $('.digital').slideUp();
                $('#file_link').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'file_link');
            } else {
                $('.digital').slideDown();
                $('#file_link').attr('required', 'required');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'file_link');
            }
            if (t !== 'combo') {
                $('.combo').slideUp();
                //$('#add_item').removeAttr('required');
                //$('form[data-toggle="validator"]').bootstrapValidator('removeField', 'add_item');
            } else {
                $('.combo').slideDown();
                //$('#add_item').attr('required', 'required');
                //$('form[data-toggle="validator"]').bootstrapValidator('addField', 'add_item');
            }
            $("#code").parent('.form-group').addClass("has-error");
            $("#code").focus();
            $("#product_image").parent('.form-group').addClass("text-warning");
            $("#images").parent('.form-group').addClass("text-warning");
            $.ajax({
                type: "get", async: false,
                url: "<?= admin_url('products/getSubCategories') ?>/" + <?= $product->category_id ?>,
                dataType: "json",
                success: function (scdata) {
                    if (scdata != null) {
                        $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_subcategory') ?>").select2({
                            placeholder: "<?= lang('select_category_to_load') ?>",
                            data: scdata
                        });
                    } else {
                        $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('no_subcategory') ?>").select2({
                            placeholder: "<?= lang('no_subcategory') ?>",
                            data: [{ id: '', text: '<?= lang('no_subcategory') ?>' }]
                        });
                    }
                }
            });
            <?php if ($product->supplier1) {
                ?>
                select_supplier('supplier1', "<?= $product->supplier1; ?>");
                $('#supplier_price').val("<?= $product->supplier1price == 0 ? '' : $this->sma->formatDecimal($product->supplier1price); ?>");
                <?php
            } ?>
            <?php if ($product->supplier2) {
                ?>
                $('#addSupplier').click();
                select_supplier('supplier_2', "<?= $product->supplier2; ?>");
                $('#supplier_2_price').val("<?= $product->supplier2price == 0 ? '' : $this->sma->formatDecimal($product->supplier2price); ?>");
                <?php
            } ?>
            <?php if ($product->supplier3) {
                ?>
                $('#addSupplier').click();
                select_supplier('supplier_3', "<?= $product->supplier3; ?>");
                $('#supplier_3_price').val("<?= $product->supplier3price == 0 ? '' : $this->sma->formatDecimal($product->supplier3price); ?>");
                <?php
            } ?>
            <?php if ($product->supplier4) {
                ?>
                $('#addSupplier').click();
                select_supplier('supplier_4', "<?= $product->supplier4; ?>");
                $('#supplier_4_price').val("<?= $product->supplier4price == 0 ? '' : $this->sma->formatDecimal($product->supplier4price); ?>");
                <?php
            } ?>
            <?php if ($product->supplier5) {
                ?>
                $('#addSupplier').click();
                select_supplier('supplier_5', "<?= $product->supplier5; ?>");
                $('#supplier_5_price').val("<?= $product->supplier5price == 0 ? '' : $this->sma->formatDecimal($product->supplier5price); ?>");
                <?php
            } ?>
            function select_supplier(id, v) {
                $('#' + id).val(v).select2({
                    minimumInputLength: 1,
                    data: [],
                    initSelection: function (element, callback) {
                        $.ajax({
                            type: "get", async: false,
                            url: "<?= admin_url('suppliers/getSupplier') ?>/" + $(element).val(),
                            dataType: "json",
                            success: function (data) {
                                callback(data[0]);
                            }
                        });
                    },
                    ajax: {
                        url: site.base_url + "suppliers/suggestions",
                        dataType: 'json',
                        quietMillis: 15,
                        data: function (term, page) {
                            return {
                                term: term,
                                limit: 10
                            };
                        },
                        results: function (data, page) {
                            if (data.results != null) {
                                return { results: data.results };
                            } else {
                                return { results: [{ id: '', text: 'No Match Found' }] };
                            }
                        }
                    }
                });//.select2("val", "<?= $product->supplier1; ?>");
            }

            var whs = $('.wh');
            $.each(whs, function () {
                $(this).val($('#r' + $(this).attr('id')).text());
            });
        });
        <?php
    } ?>
    $(document).ready(function () {
        $('#unit').change(function (e) {
            var v = $(this).val();
            if (v) {
                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?= admin_url('products/getSubUnits') ?>/" + v,
                    dataType: "json",
                    success: function (data) {
                        $('#default_sale_unit').select2("destroy").empty().select2({ minimumResultsForSearch: 7 });
                        $('#default_purchase_unit').select2("destroy").empty().select2({ minimumResultsForSearch: 7 });
                        $.each(data, function () {
                            $("<option />", { value: this.id, text: this.name + ' (' + this.code + ')' }).appendTo($('#default_sale_unit'));
                            $("<option />", { value: this.id, text: this.name + ' (' + this.code + ')' }).appendTo($('#default_purchase_unit'));
                        });
                        $('#default_sale_unit').select2('val', v);
                        $('#default_purchase_unit').select2('val', v);
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_error') ?>');
                    }
                });
            } else {
                $('#default_sale_unit').select2("destroy").empty();
                $('#default_purchase_unit').select2("destroy").empty();
                $("<option />", { value: '', text: '<?= lang('select_unit_first') ?>' }).appendTo($('#default_sale_unit'));
                $("<option />", { value: '', text: '<?= lang('select_unit_first') ?>' }).appendTo($('#default_purchase_unit'));
                $('#default_sale_unit').select2({ minimumResultsForSearch: 7 }).select2('val', '');
                $('#default_purchase_unit').select2({ minimumResultsForSearch: 7 }).select2('val', '');
            }
        });
    });
</script>

<div class="modal fade" id="aModal" tabindex="-1" aria-labelledby="aModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aModalLabel"><?= lang('add_product_manually') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="awarehouse"><?= lang('warehouse') ?></label>
                    <?php
                    $wh[''] = '';
                    foreach ($warehouses as $warehouse) {
                        $wh[$warehouse->id] = $warehouse->name;
                    }
                    echo form_dropdown('warehouse', $wh, '', 'id="awarehouse" class="form-select-sm"');
                    ?>
                </div>
                <input type="hidden" id="aquantity" value="0">
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="aprice"><?= lang('price_addition') ?></label>
                    <input type="text" class="form-control-sm" id="aprice">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" class="btn btn-primary" id="updateAttr"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>