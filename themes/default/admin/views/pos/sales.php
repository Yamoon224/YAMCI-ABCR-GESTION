<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        function balance(x, number) {
            if (!x) {
                return '0.00';
            }
            var b = x.split('__');
            var total = parseFloat(b[0]);
            var rounding = parseFloat(b[1]);
            var paid = parseFloat(b[2]);
            if (number == 'number') {
                return formatDecimals(total+rounding-paid);
            }
            return currencyFormat(total+rounding-paid);
        }
        oTable = $('#POSData').dataTable({
            "aaSorting": [[1, "desc"], [2, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('pos/getSales' . ($warehouse_id ? '/' . $warehouse_id : '')) ?>',
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
                nRow.className = "receipt_link";
                return nRow;
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, {"mRender": fld}, null, null, null, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": balance}, {"mRender": row_status}, {"mRender": pay_status}, {"bSortable": false}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var gtotal = 0, paid = 0, bal = 0;
                for (var i = 0; i < aaData.length; i++) {
                    gtotal += parseFloat(aaData[aiDisplay[i]][5]);
                    paid += parseFloat(aaData[aiDisplay[i]][6]);
                    bal += parseFloat(balance(aaData[aiDisplay[i]][7], 'number'));
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[5].innerHTML = currencyFormat(parseFloat(gtotal));
                nCells[6].innerHTML = currencyFormat(parseFloat(paid));
                nCells[7].innerHTML = currencyFormat(parseFloat(bal));
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('biller');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text"},
            {column_number: 8, filter_default_label: "[<?=lang('sale_status');?>]", filter_type: "text", data: []},
            {column_number: 9, filter_default_label: "[<?=lang('payment_status');?>]", filter_type: "text", data: []},
        ], "footer");

        $(document).on('click', '.duplicate_pos', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            if (localStorage.getItem('positems')) {
                bootbox.confirm("<?= $this->lang->line('leave_alert') ?>", function (gotit) {
                    if (gotit == false) {
                        return true;
                    } else {
                        window.location.href = link;
                    }
                });
            } else {
                window.location.href = link;
            }
        });
        $(document).on('click', '.email_receipt', function (e) {
            e.preventDefault();
            var sid = $(this).attr('data-id');
            var ea = $(this).attr('data-email-address');
            var email = prompt("<?= lang('email_address'); ?>", ea);
            if (email != null) {
                $.ajax({
                    type: "post",
                    url: "<?= admin_url('pos/email_receipt') ?>/" + sid,
                    data: { <?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: sid },
                    dataType: "json",
                        success: function (data) {
                        bootbox.alert(data.msg);
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_request_failed'); ?>');
                        return false;
                    }
                });
            }
        });
    });

</script>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    echo admin_form_open('sales/sale_actions', 'id="action-form"');
} ?>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center justify-content-between py-2 px-3 bg-white border-bottom">
        <div class="d-flex align-items-center gap-2">
            <span class="bg-primary bg-opacity-10 rounded-2 p-2 lh-1">
                <i class="fa fa-barcode text-primary"></i>
            </span>
            <h5 class="mb-0 fw-semibold">
                <?= lang('pos_sales') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')' ?>
            </h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-inline-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa fa-tasks"></i> <?= lang('actions') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= admin_url('pos') ?>"><i class="fa fa-plus-circle me-2 text-success"></i><?= lang('add_sale') ?></a></li>
                    <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o me-2 text-success"></i><?= lang('export_to_excel') ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger bpo" href="#" title="<b><?= $this->lang->line('delete_sales') ?></b>" data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary bpo-close'><?= lang('no') ?></button>" data-html="true" data-placement="left"><i class="fa fa-trash-o me-2"></i><?= lang('delete_sales') ?></a></li>
                </ul>
            </div>
            <?php if (!empty($warehouses)) { ?>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-inline-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa fa-building-o"></i> <?= lang('warehouses') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= admin_url('pos/sales') ?>"><i class="fa fa-building-o me-2"></i><?= lang('all_warehouses') ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <?php foreach ($warehouses as $warehouse) {
                        echo '<li><a class="dropdown-item" href="' . admin_url('pos/sales/' . $warehouse->id) . '"><i class="fa fa-building me-2"></i>' . $warehouse->name . '</a></li>';
                    } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="card-body p-3">
        <p class="mb-3 text-muted small"><?= lang('list_results'); ?></p>
        <div class="table-responsive">
            <table id="POSData" class="table table-bordered table-sm table-hover table-striped w-100">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th><?= lang('date'); ?></th>
                            <th><?= lang('reference_no'); ?></th>
                            <th><?= lang('biller'); ?></th>
                            <th><?= lang('customer'); ?></th>
                            <th><?= lang('grand_total'); ?></th>
                            <th><?= lang('paid'); ?></th>
                            <th><?= lang('balance'); ?></th>
                            <th><?= lang('sale_status'); ?></th>
                            <th><?= lang('payment_status'); ?></th>
                            <th style="width:80px; text-align:center;"><?= lang('actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="10" class="dataTables_empty"><?= lang('loading_data'); ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?= lang('grand_total'); ?></th>
                            <th><?= lang('paid'); ?></th>
                            <th><?= lang('balance'); ?></th>
                            <th></th>
                            <th></th>
                            <th style="width:80px; text-align:center;"><?= lang('actions'); ?></th>
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
