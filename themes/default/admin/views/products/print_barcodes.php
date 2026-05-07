<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
@media print {
    .no-print { display: none !important; }
    .card-header, .card-body > .row > .col-lg-12 > .card { box-shadow: none !important; }
}
.bc-config-card {
    background: #f8f9ff;
    border: 1px solid #e8edff;
    border-radius: 10px;
}
.bc-config-card .card-header-section {
    background: #fff;
    border-bottom: 1px solid #e8edff;
    border-radius: 10px 10px 0 0;
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.print-options-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 24px;
    align-items: center;
    padding: 10px 14px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}
.print-options-grid .form-check {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 5px;
}
.print-options-grid .form-check-input {
    width: 1em;
    height: 1em;
    margin-top: 0;
    cursor: pointer;
}
.print-options-grid .form-check-label {
    cursor: pointer;
    user-select: none;
}
</style>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center justify-content-between py-2 px-3 bg-white border-bottom no-print">
        <div class="d-flex align-items-center gap-2">
            <span class="bg-primary bg-opacity-10 rounded-2 p-2 lh-1">
                <i class="fa fa-barcode text-primary"></i>
            </span>
            <h5 class="mb-0 fw-semibold"><?= lang('print_barcode_label'); ?></h5>
        </div>
        <button type="button" onclick="window.print();return false;" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2">
            <i class="fa fa-print"></i> <?= lang('print') ?>
        </button>
    </div>

    <div class="card-body p-3 p-lg-4">
        <div class="row">
            <div class="col-12">

                <!-- Intro -->
                <div class="alert alert-info d-flex align-items-start gap-2 py-2 no-print" role="alert">
                    <i class="fa fa-info-circle mt-1 flex-shrink-0"></i>
                    <div class="small"><?php echo sprintf(
                        lang('print_barcode_heading'),
                        anchor('admin/system_settings/categories', lang('categories') . ' & ' . lang('subcategories')),
                        '',
                        anchor('admin/purchases', lang('purchases')),
                        anchor('admin/transfers', lang('transfers'))
                    ); ?></div>
                </div>

                <!-- Panneau de configuration -->
                <div class="bc-config-card no-print mb-4">
                    <div class="bc-config-card-body p-3">

                        <!-- Recherche produit -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small mb-1" for="add_item">
                                <i class="fa fa-search text-primary me-1"></i><?= lang('add_product') ?>
                            </label>
                            <?php echo form_input('add_item', '', 'class="form-control form-control-sm" id="add_item" placeholder="' . $this->lang->line('add_item') . '"'); ?>
                        </div>

                        <?= admin_form_open('products/print_barcodes', 'id="barcode-print-form"'); ?>

                        <!-- Tableau produits sélectionnés -->
                        <div class="table-responsive mb-3">
                            <table id="bcTable" class="table table-bordered table-sm table-hover table-striped mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th><?= lang('product_name') . ' (' . $this->lang->line('product_code') . ')'; ?></th>
                                    <th style="width:100px;"><?= lang('quantity'); ?></th>
                                    <th><?= lang('variants'); ?></th>
                                    <th class="text-center" style="width:36px;"><i class="fa fa-trash-o text-muted"></i></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Style d'impression -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small mb-1" for="style">
                                    <i class="fa fa-th text-primary me-1"></i><?= lang('style') ?>
                                </label>
                                <?php $opts = ['' => lang('select') . ' ' . lang('style'), 40 => lang('40_per_sheet'), 30 => lang('30_per_sheet'), 24 => lang('24_per_sheet'), 20 => lang('20_per_sheet'), 18 => lang('18_per_sheet'), 14 => lang('14_per_sheet'), 12 => lang('12_per_sheet'), 10 => lang('10_per_sheet'), 50 => lang('continuous_feed')]; ?>
                                <?= form_dropdown('style', $opts, set_value('style', 24), 'class="form-select form-select-sm" id="style" required="required"'); ?>
                                <div class="form-text small text-muted"><?= lang('barcode_tip'); ?></div>
                            </div>

                            <!-- Options format continu -->
                            <div class="col-md-6 cf-con" style="display:none;">
                                <label class="form-label fw-semibold small mb-1"><i class="fa fa-crop text-primary me-1"></i><?= lang('dimensions') ?? 'Dimensions' ?></label>
                                <div class="input-group input-group-sm">
                                    <?= form_input('cf_width', '', 'class="form-control form-control-sm" id="cf_width" placeholder="' . lang('width') . '"'); ?>
                                    <span class="input-group-text"><?= lang('inches'); ?></span>
                                    <?= form_input('cf_height', '', 'class="form-control form-control-sm" id="cf_height" placeholder="' . lang('height') . '"'); ?>
                                    <span class="input-group-text"><?= lang('inches'); ?></span>
                                </div>
                                <div class="mt-2">
                                    <?php $oopts = [0 => lang('portrait'), 1 => lang('landscape')]; ?>
                                    <?= form_dropdown('cf_orientation', $oopts, '', 'class="form-select form-select-sm" id="cf_orientation"'); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Options d'affichage sur l'étiquette -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small mb-2">
                                <i class="fa fa-eye text-primary me-1"></i><?= lang('print') ?> :
                            </label>
                            <div class="print-options-grid">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="site_name" type="checkbox" id="site_name" value="1" checked />
                                    <label class="form-check-label small" for="site_name"><?= lang('site_name'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="product_name" type="checkbox" id="product_name" value="1" checked />
                                    <label class="form-check-label small" for="product_name"><?= lang('product_name'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="price" type="checkbox" id="price" value="1" checked />
                                    <label class="form-check-label small" for="price"><?= lang('price'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="currencies" type="checkbox" id="currencies" value="1" />
                                    <label class="form-check-label small" for="currencies"><?= lang('currencies'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="unit" type="checkbox" id="unit" value="1" />
                                    <label class="form-check-label small" for="unit"><?= lang('unit'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="category" type="checkbox" id="category" value="1" />
                                    <label class="form-check-label small" for="category"><?= lang('category'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="variants" type="checkbox" id="variants" value="1" />
                                    <label class="form-check-label small" for="variants"><?= lang('variants'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="product_image" type="checkbox" id="product_image" value="1" />
                                    <label class="form-check-label small" for="product_image"><?= lang('product_image'); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="check_promo" type="checkbox" id="check_promo" value="1" checked />
                                    <label class="form-check-label small" for="check_promo"><?= lang('check_promo'); ?></label>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-center gap-3 pt-2">
                            <button type="submit" name="print" value="1" class="btn btn-primary px-4 d-inline-flex align-items-center gap-2">
                                <i class="fa fa-refresh"></i> <?= lang('update') ?>
                            </button>
                            <button type="button" id="reset" class="btn btn-outline-danger px-4 d-inline-flex align-items-center gap-2">
                                <i class="fa fa-times"></i> <?= lang('reset'); ?>
                            </button>
                        </div>

                        <?= form_close(); ?>
                    </div>
                </div>

                <!-- Zone d'aperçu des codes-barres -->
                <div id="barcode-con">
                    <?php
                    if ($this->input->post('print')) {
                        if (!empty($barcodes)) {
                            echo '<button type="button" onclick="window.print();return false;" class="btn btn-primary w-100 no-print mb-3"><i class="fa fa-print me-1"></i> ' . lang('print') . '</button>';
                            $c = 1;
                            if ($style == 12 || $style == 18 || $style == 24 || $style == 40) {
                                echo '<div class="barcodea4">';
                            } elseif ($style != 50) {
                                echo '<div class="barcode">';
                            }
                            foreach ($barcodes as $item) {
                                for ($r = 1; $r <= $item['quantity']; $r++) {
                                    echo '<div class="item style' . $style . '" ' .
                                    ($style == 50 && $this->input->post('cf_width') && $this->input->post('cf_height') ?
                                        'style="width:' . $this->input->post('cf_width') . 'in;height:' . $this->input->post('cf_height') . 'in;border:0;"' : '')
                                    . '>';
                                    if ($style == 50) {
                                        if ($this->input->post('cf_orientation')) {
                                            $ty        = (($this->input->post('cf_height') / $this->input->post('cf_width')) * 100) . '%';
                                            $landscape = '
                                                -webkit-transform-origin: 0 0;
                                                -moz-transform-origin:    0 0;
                                                -ms-transform-origin:     0 0;
                                                transform-origin:         0 0;
                                                -webkit-transform: translateY(' . $ty . ') rotate(-90deg);
                                                -moz-transform:    translateY(' . $ty . ') rotate(-90deg);
                                                -ms-transform:     translateY(' . $ty . ') rotate(-90deg);
                                                transform:         translateY(' . $ty . ') rotate(-90deg);
                                                ';
                                            echo '<div class="div50" style="width:' . $this->input->post('cf_height') . 'in;height:' . $this->input->post('cf_width') . 'in;border: 1px dotted #CCC;' . $landscape . '">';
                                        } else {
                                            echo '<div class="div50" style="width:' . $this->input->post('cf_width') . 'in;height:' . $this->input->post('cf_height') . 'in;border: 1px dotted #CCC;padding-top:0.025in;">';
                                        }
                                    }
                                    if ($item['image']) {
                                        echo '<span class="product_image"><img src="' . base_url('assets/uploads/thumbs/' . $item['image']) . '" alt="" /></span>';
                                    }
                                    if ($item['site']) {
                                        echo '<span class="barcode_site">' . $item['site'] . '</span>';
                                    }
                                    if ($item['name']) {
                                        echo '<span class="barcode_name">' . $item['name'] . '</span>';
                                    }
                                    if ($item['price']) {
                                        echo '<span class="barcode_price">' . lang('price') . ' ';
                                        if ($item['currencies']) {
                                            $rates = [];
                                            foreach ($currencies as $currency) {
                                                $rates[] = $currency->code . ': ' . $this->sma->formatMoney($item['rprice'] * $currency->rate, 'none');
                                            }
                                            echo implode(', ', $rates);
                                        } else {
                                            echo $item['price'];
                                        }
                                        echo '</span> ';
                                    }
                                    if ($item['unit']) {
                                        echo '<span class="barcode_unit">' . lang('unit') . ': ' . $item['unit'] . '</span>, ';
                                    }
                                    if ($item['category']) {
                                        echo '<span class="barcode_category">' . lang('category') . ': ' . $item['category'] . '</span> ';
                                    }
                                    if ($item['variants']) {
                                        echo '<span class="variants">' . lang('variants') . ': ';
                                        foreach ($item['variants'] as $variant) {
                                            echo $variant->name . ', ';
                                        }
                                        echo '</span> ';
                                    }
                                    echo '<span class="barcode_image"><img src="' . admin_url('products/barcode/' . $item['barcode'] . '/' . $item['bcs'] . '/' . $item['bcis']) . '" alt="' . $item['barcode'] . '" class="bcimg" /></span>';
                                    if ($style == 50) {
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    if ($style == 40) {
                                        if ($c % 40 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                        }
                                    } elseif ($style == 30) {
                                        if ($c % 30 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcode">';
                                        }
                                    } elseif ($style == 24) {
                                        if ($c % 24 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                        }
                                    } elseif ($style == 20) {
                                        if ($c % 20 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcode">';
                                        }
                                    } elseif ($style == 18) {
                                        if ($c % 18 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                        }
                                    } elseif ($style == 14) {
                                        if ($c % 14 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcode">';
                                        }
                                    } elseif ($style == 12) {
                                        if ($c % 12 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                        }
                                    } elseif ($style == 10) {
                                        if ($c % 10 == 0) {
                                            echo '</div><div class="clearfix"></div><div class="barcode">';
                                        }
                                    }
                                    $c++;
                                }
                            }
                            if ($style != 50) {
                                echo '</div>';
                            }
                            echo '<button type="button" onclick="window.print();return false;" class="btn btn-primary w-100 no-print mt-3"><i class="fa fa-print me-1"></i> ' . lang('print') . '</button>';
                        } else {
                            echo '<div class="alert alert-warning"><i class="fa fa-exclamation-triangle me-2"></i>' . lang('no_product_selected') . '</div>';
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var ac = false; bcitems = {};
    if (localStorage.getItem('bcitems')) {
        bcitems = JSON.parse(localStorage.getItem('bcitems'));
    }
    <?php if ($items) {
        ?>
    localStorage.setItem('bcitems', JSON.stringify(<?= $items; ?>));
        <?php
    } ?>
    $(document).ready(function() {
        <?php if ($this->input->post('print')) {
            ?>
            $( window ).load(function() {
                $('html, body').animate({
                    scrollTop: ($("#barcode-con").offset().top)-15
                }, 1000);
            });
            <?php
        } ?>
        if (localStorage.getItem('bcitems')) {
            loadItems();
        }
        $("#add_item").autocomplete({
            source: '<?= admin_url('products/get_suggestions'); ?>',
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
        check_add_item_val();

        $('#style').change(function (e) {
            localStorage.setItem('bcstyle', $(this).val());
            if ($(this).val() == 50) {
                $('.cf-con').slideDown();
            } else {
                $('.cf-con').slideUp();
            }
        });
        if (style = localStorage.getItem('bcstyle')) {
            $('#style').val(style);
            if (style == 50) {
                $('.cf-con').slideDown();
            } else {
                $('.cf-con').slideUp();
            }
        }

        $('#cf_width').change(function (e) {
            localStorage.setItem('cf_width', $(this).val());
        });
        if (cf_width = localStorage.getItem('cf_width')) {
            $('#cf_width').val(cf_width);
        }

        $('#cf_height').change(function (e) {
            localStorage.setItem('cf_height', $(this).val());
        });
        if (cf_height = localStorage.getItem('cf_height')) {
            $('#cf_height').val(cf_height);
        }

        $('#cf_orientation').change(function (e) {
            localStorage.setItem('cf_orientation', $(this).val());
        });
        if (cf_orientation = localStorage.getItem('cf_orientation')) {
            $('#cf_orientation').val(cf_orientation);
        }

        // Sauvegarde/restauration des cases à cocher via localStorage (natif BS5)
        var bcCheckboxMap = {
            'site_name': 'bcsite_name',
            'product_name': 'bcproduct_name',
            'price': 'bcprice',
            'currencies': 'bccurrencies',
            'unit': 'bcunit',
            'category': 'bccategory',
            'check_promo': 'bccheck_promo',
            'product_image': 'bcproduct_image',
            'variants': 'bcvariants'
        };
        $.each(bcCheckboxMap, function(id, key) {
            var stored = localStorage.getItem(key);
            if (stored !== null) {
                $('#' + id).prop('checked', stored == 1);
            }
            $('#' + id).on('change', function() {
                localStorage.setItem(key, this.checked ? 1 : 0);
                if (id === 'price' && !this.checked) {
                    $('#currencies').prop('checked', false);
                    localStorage.setItem('bccurrencies', 0);
                }
            });
        });

        $(document).on('change', '.checkbox', function() {
            var item_id = $(this).attr('data-item-id');
            var vt_id = $(this).attr('id');
            bcitems[item_id]['selected_variants'][vt_id] = this.checked ? 1 : 0;
            localStorage.setItem('bcitems', JSON.stringify(bcitems));
        });

        $(document).on('click', '.del', function () {
            var id = $(this).attr('id');
            delete bcitems[id];
            localStorage.setItem('bcitems', JSON.stringify(bcitems));
            $(this).closest('#row_' + id).remove();
        });

        $('#reset').click(function (e) {

            bootbox.confirm(lang.r_u_sure, function (result) {
                if (result) {
                    if (localStorage.getItem('bcitems')) {
                        localStorage.removeItem('bcitems');
                    }
                    if (localStorage.getItem('bcstyle')) {
                        localStorage.removeItem('bcstyle');
                    }
                    if (localStorage.getItem('bcsite_name')) {
                        localStorage.removeItem('bcsite_name');
                    }
                    if (localStorage.getItem('bcproduct_name')) {
                        localStorage.removeItem('bcproduct_name');
                    }
                    if (localStorage.getItem('bcprice')) {
                        localStorage.removeItem('bcprice');
                    }
                    if (localStorage.getItem('bccurrencies')) {
                        localStorage.removeItem('bccurrencies');
                    }
                    if (localStorage.getItem('bcunit')) {
                        localStorage.removeItem('bcunit');
                    }
                    if (localStorage.getItem('bccategory')) {
                        localStorage.removeItem('bccategory');
                    }
                    // if (localStorage.getItem('cf_width')) {
                    //     localStorage.removeItem('cf_width');
                    // }
                    // if (localStorage.getItem('cf_height')) {
                    //     localStorage.removeItem('cf_height');
                    // }
                    // if (localStorage.getItem('cf_orientation')) {
                    //     localStorage.removeItem('cf_orientation');
                    // }

                    $('#modal-loading').show();
                    window.location.replace("<?= admin_url('products/print_barcodes'); ?>");
                }
            });
        });

        var old_row_qty;
        $(document).on("focus", '.quantity', function () {
            old_row_qty = $(this).val();
        }).on("change", '.quantity', function () {
            var row = $(this).closest('tr');
            if (!is_numeric($(this).val())) {
                $(this).val(old_row_qty);
                bootbox.alert(lang.unexpected_value);
                return;
            }
            var new_qty = parseFloat($(this).val()),
            item_id = row.attr('data-item-id');
            bcitems[item_id].qty = new_qty;
            localStorage.setItem('bcitems', JSON.stringify(bcitems));
        });

    });

    function add_product_item(item) {
        ac = true;
        if (item == null) {
            return false;
        }
        item_id = item.id;
        if (bcitems[item_id]) {
            bcitems[item_id].qty = parseFloat(bcitems[item_id].qty) + 1;
        } else {
            bcitems[item_id] = item;
            bcitems[item_id]['selected_variants'] = {};
            $.each(item.variants, function () {
                bcitems[item_id]['selected_variants'][this.id] = 1;
            });
        }

        localStorage.setItem('bcitems', JSON.stringify(bcitems));
        loadItems();
        return true;

    }

    function loadItems () {

        if (localStorage.getItem('bcitems')) {
            $("#bcTable tbody").empty();
            bcitems = JSON.parse(localStorage.getItem('bcitems'));

            $.each(bcitems, function () {

                var item = this;
                var row_no = item.id;
                var vd = '';
                var newTr = $('<tr id="row_' + row_no + '" class="row_' + item.id + '" data-item-id="' + item.id + '"></tr>');
                tr_html = '<td><input name="product[]" type="hidden" value="' + item.id + '"><span id="name_' + row_no + '">' + item.name + ' (' + item.code + ')</span></td>';
                tr_html += '<td><input class="form-control quantity text-center" name="quantity[]" type="text" value="' + formatDecimal(item.qty) + '" data-id="' + row_no + '" data-item="' + item.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                if(item.variants) {
                    $.each(item.variants, function () {
                        vd += '<div class="form-check form-check-inline mb-0"><input class="form-check-input checkbox" type="checkbox" name="vt_'+ item.id +'_'+ this.id +'" id="'+this.id+'" data-item-id="'+item.id+'" value="'+this.id+'" '+( item.selected_variants[this.id] == 1 ? 'checked' : '')+'><label class="form-check-label small" for="'+this.id+'">'+this.name+'</label></div>';
                    });
                }
                tr_html += '<td>'+vd+'</td>';
                tr_html += '<td class="text-center"><i class="fa fa-times text-danger del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                newTr.html(tr_html);
                newTr.appendTo("#bcTable");
            });
            return true;
        }
    }

</script>
