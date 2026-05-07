<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
    .card-header {
        padding: 6px 12px !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-header h2 {
        margin: 0;
        font-size: 1rem;
        line-height: 1.4;
    }
    .card-icon .btn-tasks {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .card-icon .btn-tasks > li {
        margin: 0;
    }
    /* Boutons dropdowns modernes */
    .card-icon .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        font-size: 0.82rem;
        font-weight: 500;
        border-radius: 6px;
        border: 1px solid rgba(0,0,0,.12);
        background: #fff;
        color: #444;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s, box-shadow .15s;
        white-space: nowrap;
        box-shadow: 0 1px 2px rgba(0,0,0,.06);
    }
    .card-icon .btn-modern:hover,
    .card-icon .btn-modern.show {
        background: #f0f4ff;
        border-color: #4a6cf7;
        color: #4a6cf7;
        box-shadow: 0 2px 6px rgba(74,108,247,.15);
        text-decoration: none;
    }
    .card-icon .btn-modern i {
        font-size: 0.85rem;
    }
    .card-icon .btn-modern .caret-icon {
        font-size: 0.65rem;
        opacity: .6;
    }
    /* Dropdown menu moderne */
    .card-icon .dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
        padding: 6px 4px;
        min-width: 200px;
        margin-top: 4px;
    }
    .card-icon .dropdown-menu li a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        font-size: 0.83rem;
        color: #333;
        border-radius: 6px;
        text-decoration: none;
        transition: background .12s;
    }
    .card-icon .dropdown-menu li a:hover {
        background: #f0f4ff;
        color: #4a6cf7;
    }
    .card-icon .dropdown-menu li a i {
        width: 16px;
        text-align: center;
        color: #888;
    }
    .card-icon .dropdown-menu li a:hover i {
        color: #4a6cf7;
    }
    .card-icon .dropdown-menu .divider {
        border-top: 1px solid #eee;
        margin: 4px 8px;
    }
    .card-icon .dropdown-menu li a.text-danger i {
        color: #dc3545;
    }
    .card-icon .dropdown-menu li a.text-danger:hover {
        background: #fff0f0;
        color: #dc3545;
    }

    #PRData td:nth-child(7) {
        text-align: right;
    }
    <?php if ($Owner || $Admin || $this->session->userdata('show_cost')) {
        ?>
    #PRData td:nth-child(9) {
        text-align: right;
    }
        <?php
    } if ($Owner || $Admin || $this->session->userdata('show_price')) {
        ?>
    #PRData td:nth-child(8) {
        text-align: right;
    }
        <?php
    } ?>
</style>
<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#PRData').dataTable({
            "aaSorting": [[2, "asc"], [3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('products/getProducts' . ($warehouse_id ? '/' . $warehouse_id : '') . ($supplier ? '?supplier=' . $supplier->id : '')) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "product_link";
                //if(aData[7] > aData[9]){ nRow.className = "product_link warning"; } else { nRow.className = "product_link"; }
                return nRow;
            },
            "aoColumns": [
                {"bSortable": false, "mRender": checkbox}, {"bSortable": false,"mRender": img_hl}, null, null, null, null, <?php if ($Owner || $Admin) {
                    echo '{"mRender": currencyFormat}, {"mRender": currencyFormat},';
                                                                                                                           } else {
                                                                                                                               if ($this->session->userdata('show_cost')) {
                                                                                                                                   echo '{"mRender": currencyFormat},';
                                                                                                                               }
                                                                                                                               if ($this->session->userdata('show_price')) {
                                                                                                                                   echo '{"mRender": currencyFormat},';
                                                                                                                               }
                                                                                                                           } ?> {"mRender": formatQuantity}, null, <?php if (!$warehouse_id || !$Settings->racks) {
    echo '{"bVisible": false},';
                                                                                                                           } else {
                                                                                                                               echo '{"bSortable": true},';
                                                                                                                           } ?> {"mRender": formatQuantity}, {"bSortable": false}
            ]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 2, filter_default_label: "[<?=lang('code');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('name');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('brand');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('category');?>]", filter_type: "text", data: []},
            <?php $col = 5;
            if ($Owner || $Admin) {
                echo '{column_number : 6, filter_default_label: "[' . lang('cost') . ']", filter_type: "text", data: [] },';
                echo '{column_number : 7, filter_default_label: "[' . lang('price') . ']", filter_type: "text", data: [] },';
                $col += 2;
            } else {
                if ($this->session->userdata('show_cost')) {
                    $col++;
                    echo '{column_number : ' . $col . ', filter_default_label: "[' . lang('cost') . ']", filter_type: "text", data: [] },';
                }
                if ($this->session->userdata('show_price')) {
                    $col++;
                    echo '{column_number : ' . $col . ', filter_default_label: "[' . lang('price') . ']", filter_type: "text, data: []" },';
                }
            }
            ?>
            {column_number: <?php $col++;
            echo $col; ?>, filter_default_label: "[<?=lang('quantity');?>]", filter_type: "text", data: []},
            {column_number: <?php $col++;
            echo $col; ?>, filter_default_label: "[<?=lang('unit');?>]", filter_type: "text", data: []},
            <?php $col++; if ($warehouse_id && $Settings->racks) {
                echo '{column_number : ' . $col . ', filter_default_label: "[' . lang('rack') . ']", filter_type: "text", data: [] },';
            } ?>
            {column_number: <?php $col++;
            echo $col; ?>, filter_default_label: "[<?=lang('alert_quantity');?>]", filter_type: "text", data: []},
        ], "footer");

    });
</script>
<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
                echo admin_form_open('products/product_actions' . ($warehouse_id ? '/' . $warehouse_id : ''), 'id="action-form"');
} ?>
<div class="card">
    <div class="card-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-barcode"></i><?= lang('products') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')' . ($supplier ? ' (' . lang('supplier') . ': ' . ($supplier->company && $supplier->company != '-' ? $supplier->company : $supplier->name) . ')' : ''); ?>
        </h2>

        <div class="card-icon">
            <ul class="btn-tasks">
                <!-- Bouton Ajouter rapide -->
                <li>
                    <a href="<?= admin_url('products/add') ?>" class="btn-modern">
                        <i class="fa fa-plus-circle"></i> <?= lang('add_product') ?>
                    </a>
                </li>

                <!-- Dropdown Actions -->
                <li class="dropdown">
                    <a data-bs-toggle="dropdown" class="btn-modern dropdown-toggle" href="#">
                        <i class="fa fa-cog"></i> <?= lang('actions') ?> <i class="fa fa-chevron-down caret-icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" role="menu">
                        <?php if (!$warehouse_id) { ?>
                        <li>
                            <a href="<?= admin_url('products/update_price') ?>" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fa fa-file-excel-o"></i> <?= lang('update_price') ?>
                            </a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="#" id="labelProducts" data-action="labels">
                                <i class="fa fa-print"></i> <?= lang('print_barcode_label') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="sync_quantity" data-action="sync_quantity">
                                <i class="fa fa-refresh"></i> <?= lang('sync_quantity') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="set_avg_cost" data-action="set_avg_cost">
                                <i class="fa fa-balance-scale"></i> <?= lang('set_avg_cost') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="excel" data-action="export_excel">
                                <i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="bpo text-danger"
                                title="<b><?= $this->lang->line('delete_products') ?></b>"
                                data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                                data-html="true" data-placement="left">
                                <i class="fa fa-trash-o"></i> <?= lang('delete_products') ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Dropdown Entrepôts -->
                <?php if (!empty($warehouses)) { ?>
                <li class="dropdown">
                    <a data-bs-toggle="dropdown" class="btn-modern dropdown-toggle" href="#">
                        <i class="fa fa-building-o"></i> <?= lang('warehouses') ?> <i class="fa fa-chevron-down caret-icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" role="menu">
                        <li><a href="<?= admin_url('products') ?>"><i class="fa fa-th-large"></i> <?= lang('all_warehouses') ?></a></li>
                        <li class="divider"></li>
                        <?php foreach ($warehouses as $warehouse) {
                            echo '<li><a href="' . admin_url('products/' . $warehouse->id) . '"><i class="fa fa-building"></i> ' . $warehouse->name . '</a></li>';
                        } ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('list_results'); ?></p>

                <div class="table-responsive">
                    <table id="PRData" class="table table-bordered table-sm table-hover table-striped">
                        <thead>
                        <tr class="primary">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th style="min-width:40px; width: 40px; text-align: center;"><?php echo $this->lang->line('image'); ?></th>
                            <th><?= lang('code') ?></th>
                            <th><?= lang('name') ?></th>
                            <th><?= lang('brand') ?></th>
                            <th><?= lang('category') ?></th>
                            <?php
                            if ($Owner || $Admin) {
                                echo '<th>' . lang('cost') . '</th>';
                                echo '<th>' . lang('price') . '</th>';
                            } else {
                                if ($this->session->userdata('show_cost')) {
                                    echo '<th>' . lang('cost') . '</th>';
                                }
                                if ($this->session->userdata('show_price')) {
                                    echo '<th>' . lang('price') . '</th>';
                                }
                            }
                            ?>
                            <th><?= lang('quantity') ?></th>
                            <th><?= lang('unit') ?></th>
                            <th><?= lang('rack') ?></th>
                            <th><?= lang('alert_quantity') ?></th>
                            <th style="min-width:65px; text-align:center;"><?= lang('actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                        </tr>
                        </tbody>

                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th style="min-width:40px; width: 40px; text-align: center;"><?php echo $this->lang->line('image'); ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <?php
                            if ($Owner || $Admin) {
                                echo '<th></th>';
                                echo '<th></th>';
                            } else {
                                if ($this->session->userdata('show_cost')) {
                                    echo '<th></th>';
                                }
                                if ($this->session->userdata('show_price')) {
                                    echo '<th></th>';
                                }
                            }
                            ?>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="width:65px; text-align:center;"><?= lang('actions') ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
    <?php
} ?>
