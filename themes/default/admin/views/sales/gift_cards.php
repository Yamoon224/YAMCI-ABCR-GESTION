<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        $('#GCData').dataTable({
            "aaSorting": [[3, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('sales/getGiftCards') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, null, {"mRender": currencyFormat}, {"mRender": currencyFormat}, null, null, {"mRender": fsd}, {"bSortable": false}]
        });
    });
</script>
<?= admin_form_open('sales/gift_card_actions', 'id="action-form"') ?>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex align-items-center justify-content-between py-2 px-3 bg-white border-bottom">
        <div class="d-flex align-items-center gap-2">
            <span class="bg-primary bg-opacity-10 rounded-2 p-2 lh-1">
                <i class="fa fa-gift text-primary"></i>
            </span>
            <h5 class="mb-0 fw-semibold"><?= lang('gift_cards') ?></h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-inline-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa fa-tasks"></i> <?= lang('actions') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= admin_url('sales/add_gift_card') ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-plus me-2 text-success"></i><?= lang('add_gift_card') ?></a></li>
                    <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o me-2 text-success"></i><?= lang('export_to_excel') ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" id="delete" data-action="delete"><i class="fa fa-trash-o me-2"></i><?= lang('delete_gift_cards') ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body p-2 p-lg-3">
        <div class="table-responsive">
            <table id="GCData" class="table table-bordered table-sm table-hover table-striped">
                <thead>
                <tr>
                    <th style="min-width:30px; width:30px; text-align:center;">
                        <input class="checkbox checkth" type="checkbox" name="check"/>
                    </th>
                    <th><?= lang('card_no') ?></th>
                    <th><?= lang('value') ?></th>
                    <th><?= lang('balance') ?></th>
                    <th><?= lang('created_by') ?></th>
                    <th><?= lang('customer') ?></th>
                    <th><?= lang('expiry') ?></th>
                    <th style="width:65px;"><?= lang('actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="display:none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<script language="javascript">
    $(document).ready(function () {

        $('#delete').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#excel').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#pdf').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

    });
</script>
