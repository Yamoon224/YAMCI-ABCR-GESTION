<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        var dss = <?= json_encode(['packing' => lang('packing'), 'delivering' => lang('delivering'), 'delivered' => lang('delivered')]); ?>;
        function ds(x) {
            if (x == 'delivered') {
                return '<div class="text-center"><span class="badge bg-success">'+(dss[x] ? dss[x] : x)+'</span></div>';
            } else if (x == 'delivering') {
                return '<div class="text-center"><span class="badge bg-primary">'+(dss[x] ? dss[x] : x)+'</span></div>';
            } else if (x == 'packing') {
                return '<div class="text-center"><span class="badge bg-warning text-dark">'+(dss[x] ? dss[x] : x)+'</span></div>';
            }
            return x;
            return (x != null) ? (dss[x] ? dss[x] : x) : x;
        }
        oTable = $('#DOData').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('sales/getDeliveries') ?>',
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
                nRow.className = "delivery_link";
                return nRow;
            },
            "aoColumns": [{"bSortable": false,"mRender": checkbox}, {"mRender": fld}, null, null, null, null, {"mRender": ds}, {"bSortable": false,"mRender": attachment2}, {"bSortable": false}]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('do_reference_no');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('sale_reference_no');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('address');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>
<?php if ($Owner) {
    ?><?= admin_form_open('sales/delivery_actions', 'id="action-form"') ?><?php
} ?>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center justify-content-between py-2 px-3 bg-white border-bottom">
        <div class="d-flex align-items-center gap-2">
            <span class="bg-primary bg-opacity-10 rounded-2 p-2 lh-1">
                <i class="fa fa-truck text-primary"></i>
            </span>
            <h5 class="mb-0 fw-semibold"><?= lang('deliveries') ?></h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-inline-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa fa-tasks"></i> <?= lang('actions') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o me-2 text-success"></i><?= lang('export_to_excel') ?></a></li>
                    <?php if ($Owner) { ?>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger bpo" href="#"
                            title="<b><?= $this->lang->line('delete_deliveries') ?></b>"
                            data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
                            data-html="true" data-placement="left">
                            <i class="fa fa-trash-o me-2"></i><?= lang('delete_deliveries') ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body p-2 p-lg-3">
        <div class="table-responsive">
            <table id="DOData" class="table table-bordered table-sm table-hover table-striped">
                <thead>
                <tr>
                    <th style="min-width:30px; width:30px; text-align:center;">
                        <input class="checkbox checkft" type="checkbox" name="check"/>
                    </th>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('do_reference_no') ?></th>
                    <th><?= lang('sale_reference_no') ?></th>
                    <th><?= lang('customer') ?></th>
                    <th><?= lang('address') ?></th>
                    <th><?= lang('status') ?></th>
                    <th style="min-width:30px; width:30px; text-align:center;"><i class="fa fa-chain"></i></th>
                    <th style="width:100px; text-align:center;"><?= lang('actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="9" class="dataTables_empty"><?= lang('loading_data') ?></td>
                </tr>
                </tbody>
                <tfoot class="dtFilter">
                <tr class="active">
                    <th style="min-width:30px; width:30px; text-align:center;">
                        <input class="checkbox checkft" type="checkbox" name="check"/>
                    </th>
                    <th></th><th></th><th></th><th></th><th></th><th></th>
                    <th style="min-width:30px; width:30px; text-align:center;"><i class="fa fa-chain"></i></th>
                    <th style="width:100px; text-align:center;"><?= lang('actions') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php if ($Owner) { ?>
<div style="display:none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('perform_action', 'perform_action', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').click();
        });
    });
</script>
<?php } ?>
