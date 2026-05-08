<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script>
    $(document).ready(function () {
        oTable = $('#dmpData').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('products/getadjustments/' . ($warehouse ? $warehouse->id : '')); ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"bSortable": false, "mRender": checkbox}, {"mRender": fld}, null, null, null, {"mRender": decode_html}, {"bSortable": false,"mRender": attachment}, {"bSortable": false}],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[0];
                nRow.className = "adjustment_link";
                return nRow;
            },
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('warehouse');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('created_by');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang(' note');?>]", filter_type: "text", data: []},
        ], "footer");

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

        <?php if ($this->session->userdata('remove_qals')) {
            ?>
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
            <?php $this->sma->unset_data('remove_qals');
        }
        ?>
    });
</script>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
            echo admin_form_open('products/adjustment_actions', 'id="action-form"');
}
?>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center justify-content-between py-2 px-3 bg-white border-bottom">
        <div class="d-flex align-items-center gap-2">
            <span class="bg-primary bg-opacity-10 rounded-2 p-2 lh-1">
                <i class="fa fa-filter text-primary"></i>
            </span>
            <h5 class="mb-0 fw-semibold"><?= lang('quantity_adjustments') . ' <span class="text-muted fw-normal fs-6">(' . ($warehouse ? $warehouse->name : lang('all_warehouses')) . ')</span>'; ?></h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Actions -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-inline-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa fa-tasks"></i> <?= lang('actions') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= admin_url('products/add_adjustment') ?>"><i class="fa fa-plus-circle me-2 text-success"></i><?= lang('add_adjustment') ?></a></li>
                    <li><a class="dropdown-item" href="<?= admin_url('products/add_adjustment_by_csv') ?>"><i class="fa fa-plus-circle me-2 text-info"></i><?= lang('add_adjustment_by_csv') ?></a></li>
                    <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o me-2 text-success"></i><?= lang('export_to_excel') ?></a></li>
                    <?php if ($Owner || ($GP && $GP['bulk_actions'])) { ?>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger bpo" href="#"
                            title="<b><?= $this->lang->line('delete_products') ?></b>"
                            data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
                            data-html="true" data-placement="left">
                            <i class="fa fa-trash-o me-2"></i><?= lang('delete_products') ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- Entrepôts -->
            <?php if (!empty($warehouses)) { ?>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-inline-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa fa-building-o"></i> <?= lang('warehouses') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= admin_url('products/quantity_adjustments') ?>"><i class="fa fa-building-o me-2"></i><?= lang('all_warehouses') ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <?php foreach ($warehouses as $warehouse) { ?>
                    <li><a class="dropdown-item" href="<?= admin_url('products/quantity_adjustments/' . $warehouse->id) ?>"><i class="fa fa-building me-2"></i><?= $warehouse->name ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="card-body p-2 p-lg-3">
        <div class="table-responsive">
            <table id="dmpData" class="table table-bordered table-sm table-hover table-striped">
                <thead>
                <tr>
                    <th style="min-width:30px; width:30px; text-align:center;">
                        <input class="checkbox checkft" type="checkbox" name="check"/>
                    </th>
                    <th><?= lang('date'); ?></th>
                    <th><?= lang('reference_no'); ?></th>
                    <th><?= lang('warehouse'); ?></th>
                    <th><?= lang('created_by'); ?></th>
                    <th><?= lang('note'); ?></th>
                    <th style="min-width:30px; width:30px; text-align:center;"><i class="fa fa-chain"></i></th>
                    <th style="min-width:75px; text-align:center;"><?= lang('actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                </tr>
                </tbody>
                <tfoot class="dtFilter">
                <tr class="active">
                    <th style="min-width:30px; width:30px; text-align:center;">
                        <input class="checkbox checkft" type="checkbox" name="check"/>
                    </th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th style="min-width:30px; width:30px; text-align:center;"><i class="fa fa-chain"></i></th>
                    <th style="width:75px; text-align:center;"><?= lang('actions'); ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) { ?>
    <div style="display:none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
<?php } ?>