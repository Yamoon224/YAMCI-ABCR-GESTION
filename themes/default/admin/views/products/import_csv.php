<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center gap-2 py-2 px-3 bg-white border-bottom">
        <span class="bg-primary bg-opacity-10 rounded-2 p-2 lh-1">
            <i class="fa fa-upload text-primary"></i>
        </span>
        <h5 class="mb-0 fw-semibold"><?= lang('import_products_by_csv'); ?></h5>
    </div>

    <div class="card-body p-3 p-lg-4">
        <?php
        $attrib = ['role' => 'form'];
        echo admin_form_open_multipart('products/import_csv', $attrib);
        ?>

        <div class="row g-4">

            <!-- Instructions -->
            <div class="col-12">
                <div class="border rounded-3 p-3 bg-light">
                    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                        <div class="flex-grow-1">
                            <p class="mb-2">
                                <span class="badge bg-warning text-dark me-1"><i class="fa fa-exclamation-triangle me-1"></i><?= lang('csv1'); ?></span>
                            </p>
                            <p class="small mb-2">
                                <?= lang('csv2'); ?>
                                <span class="text-primary fw-semibold">
                                    (<?= lang('name') . ', ' . lang('code') . ', ' . lang('barcode_symbology') . ', ' . lang('brand') . ', ' . lang('category_code') . ', ' . lang('unit_code') . ', ' . lang('sale') . ' ' . lang('unit_code') . ', ' . lang('purchase') . ' ' . lang('unit_code') . ', ' . lang('cost') . ', ' . lang('price') . ', ' . lang('alert_quantity') . ', ' . lang('tax') . ', ' . lang('tax_method') . ', ' . lang('image') . ', ' . lang('subcategory_code') . ', ' . lang('product_variants_sep_by') . ', ' . lang('pcf1') . ', ' . lang('pcf2') . ', ' . lang('pcf3') . ', ' . lang('pcf4') . ', ' . lang('pcf5') . ', ' . lang('pcf6') . ', ' . lang('hsn_code') . ', ' . lang('second_name') . ', ' . lang('supplier_name') . ', ' . lang('supplier_part_no') . ', ' . lang('supplier_price') . ', ' . lang('supplier_name') . ' 2, ' . lang('supplier_part_no') . ', ' . lang('supplier_price') . ', ' . lang('supplier_name') . ' 3, ' . lang('supplier_part_no') . ', ' . lang('supplier_price') . ', ' . lang('supplier_name') . ' 4, ' . lang('supplier_part_no') . ', ' . lang('supplier_price') . ', ' . lang('supplier_name') . ' 5' . ', ' . lang('supplier_part_no') . ', ' . lang('supplier_price'); ?>)
                                </span>
                                <?= lang('csv3'); ?>
                            </p>
                            <p class="small text-muted mb-2"><i class="fa fa-image me-1 text-secondary"></i><?= lang('images_location_tip'); ?></p>
                            <p class="small text-info mb-0"><i class="fa fa-info-circle me-1"></i><?= lang('csv_update_tip'); ?></p>
                        </div>
                        <a href="<?= base_url(); ?>assets/csv/sample_products.csv" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-2 flex-shrink-0">
                            <i class="fa fa-download"></i> <?= lang('download_sample_file') ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Upload -->
            <div class="col-md-8 col-lg-6">
                <div class="card border shadow-none rounded-3">
                    <div class="card-header py-2 px-3 d-flex align-items-center gap-2 bg-white border-bottom border-primary border-opacity-25">
                        <i class="fa fa-file-text-o text-primary fs-6"></i>
                        <span class="fw-bold small text-uppercase text-primary"><?= lang('upload_file') ?></span>
                    </div>
                    <div class="card-body p-3">
                        <label class="form-label fw-semibold small mb-1" for="csv_file">
                            <?= lang('upload_file'); ?> <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               name="userfile"
                               class="form-control form-control-sm"
                               id="csv_file"
                               accept=".csv,text/csv"
                               required="required" />
                        <div class="form-text small text-muted mt-1">
                            <i class="fa fa-info-circle me-1"></i>Fichier .csv uniquement
                        </div>

                        <div class="mt-3 d-flex justify-content-start">
                            <button type="submit" name="import" value="1" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4">
                                <i class="fa fa-upload"></i> <?= $this->lang->line('import') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?= form_close(); ?>
    </div>
</div>
