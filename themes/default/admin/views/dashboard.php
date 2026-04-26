<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
function row_status($x) {
    if ($x == null) return '';
    $map = [
        'pending'      => 'warning',
        'ordered'      => 'warning',
        'completed'    => 'success',
        'paid'         => 'success',
        'sent'         => 'success',
        'received'     => 'success',
        'partial'      => 'info',
        'transferring' => 'info',
        'due'          => 'danger',
        'returned'     => 'secondary',
    ];
    $color = $map[$x] ?? 'secondary';
    return '<span class="badge bg-label-' . $color . ' rounded-pill">' . lang($x) . '</span>';
}
?>

<?php if (($Owner || $Admin) && !empty($chatData)) {
    foreach ($chatData as $month_sale) {
        $months[]     = date('M-Y', strtotime($month_sale->month));
        $msales[]     = $month_sale->sales;
        $mtax1[]      = $month_sale->tax1;
        $mtax2[]      = $month_sale->tax2;
        $mpurchases[] = $month_sale->purchases;
        $mtax3[]      = $month_sale->ptax;
    }
} ?>

<!-- KPI Cards -->
<?php if ($Owner || $Admin) { ?>
<div class="row g-4 mb-6">

  <!-- Total Ventes -->
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div class="avatar">
            <div class="avatar-initial bg-label-success rounded-3">
              <i class="icon-base ri ri-money-dollar-circle-line icon-26px"></i>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <h4 class="mb-1"><?= $this->sma->formatMoney($total_sales ?? 0) ?></h4>
          <p class="mb-0 text-muted"><?= lang('total_sales') ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Achats -->
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div class="avatar">
            <div class="avatar-initial bg-label-primary rounded-3">
              <i class="icon-base ri ri-shopping-cart-2-line icon-26px"></i>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <h4 class="mb-1"><?= $this->sma->formatMoney($total_purchases ?? 0) ?></h4>
          <p class="mb-0 text-muted"><?= lang('total_purchases') ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Clients -->
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div class="avatar">
            <div class="avatar-initial bg-label-warning rounded-3">
              <i class="icon-base ri ri-user-line icon-26px"></i>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <h4 class="mb-1"><?= $total_customers ?? 0 ?></h4>
          <p class="mb-0 text-muted"><?= lang('customers') ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Produits -->
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div class="avatar">
            <div class="avatar-initial bg-label-danger rounded-3">
              <i class="icon-base ri ri-archive-line icon-26px"></i>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <h4 class="mb-1"><?= $total_products ?? 0 ?></h4>
          <p class="mb-0 text-muted"><?= lang('products') ?></p>
        </div>
      </div>
    </div>
  </div>

</div>
<?php } ?>

<!-- Liens rapides -->
<div class="row g-4 mb-6">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <h5 class="card-title m-0 me-2"><i class="icon-base ri ri-apps-2-line me-2"></i><?= lang('quick_links') ?></h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <?php
          $links = [];
          if ($Owner || $Admin || ($GP['products-index'] ?? false)) $links[] = ['url' => 'products',      'icon' => 'ri-barcode-line',         'label' => 'products',      'color' => 'primary'];
          if ($Owner || $Admin || ($GP['sales-index'] ?? false))    $links[] = ['url' => 'sales',         'icon' => 'ri-shopping-bag-3-line',  'label' => 'sales',         'color' => 'success'];
          if ($Owner || $Admin || ($GP['quotes-index'] ?? false))   $links[] = ['url' => 'quotes',        'icon' => 'ri-file-list-3-line',     'label' => 'quotes',        'color' => 'warning'];
          if ($Owner || $Admin || ($GP['purchases-index'] ?? false)) $links[] = ['url' => 'purchases',   'icon' => 'ri-store-2-line',          'label' => 'purchases',     'color' => 'danger'];
          if ($Owner || $Admin || ($GP['transfers-index'] ?? false)) $links[] = ['url' => 'transfers',   'icon' => 'ri-arrow-left-right-line', 'label' => 'transfers',     'color' => 'info'];
          if ($Owner || $Admin || ($GP['customers-index'] ?? false)) $links[] = ['url' => 'customers',   'icon' => 'ri-user-3-line',           'label' => 'customers',     'color' => 'primary'];
          if ($Owner || $Admin || ($GP['suppliers-index'] ?? false)) $links[] = ['url' => 'suppliers',   'icon' => 'ri-truck-line',            'label' => 'suppliers',     'color' => 'secondary'];
          if ($Owner || $Admin)                                       $links[] = ['url' => 'notifications','icon' => 'ri-notification-2-line',  'label' => 'notifications', 'color' => 'info'];
          if ($Owner)                                                 $links[] = ['url' => 'users',        'icon' => 'ri-group-line',            'label' => 'users',         'color' => 'success'];
          if ($Owner)                                                 $links[] = ['url' => 'system_settings','icon' => 'ri-settings-4-line',    'label' => 'settings',      'color' => 'warning'];

          foreach ($links as $link) { ?>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1-5">
            <a href="<?= admin_url($link['url']) ?>" class="d-flex flex-column align-items-center text-center text-decoration-none p-3 rounded-3 border quick-link-item">
              <span class="avatar mb-2">
                <span class="avatar-initial bg-label-<?= $link['color'] ?> rounded-3">
                  <i class="icon-base ri <?= $link['icon'] ?> icon-24px"></i>
                </span>
              </span>
              <small class="text-body fw-medium"><?= lang($link['label']) ?></small>
            </a>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Graphique + Tableau de bord récent -->
<div class="row g-4 mb-6">

  <?php if (($Owner || $Admin) && !empty($chatData)) { ?>
  <!-- Graphique des ventes/achats -->
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0"><i class="icon-base ri ri-bar-chart-2-line me-2"></i><?= lang('overview_chart') ?></h5>
      </div>
      <div class="card-body">
        <p class="text-muted mb-3"><?= lang('overview_chart_heading') ?></p>
        <div id="ov-chart" style="width:100%;height:400px;"></div>
        <p class="text-center text-muted small mt-2"><?= lang('chart_lable_toggle') ?></p>
      </div>
    </div>
  </div>
  <?php } ?>

</div>

<!-- Dernières activités en onglets -->
<div class="row g-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title m-0"><i class="icon-base ri ri-time-line me-2"></i><?= lang('latest_five') ?></h5>
      </div>
      <div class="card-body p-0">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-bordered px-4 pt-2" id="dbTab" role="tablist">
          <?php $first = true; ?>
          <?php if ($Owner || $Admin || ($GP['sales-index'] ?? false)) { ?>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= $first ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-sales" type="button"><?= lang('sales') ?></button>
          </li>
          <?php $first = false; } ?>
          <?php if ($Owner || $Admin || ($GP['quotes-index'] ?? false)) { ?>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= $first ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-quotes" type="button"><?= lang('quotes') ?></button>
          </li>
          <?php $first = false; } ?>
          <?php if ($Owner || $Admin || ($GP['purchases-index'] ?? false)) { ?>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= $first ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-purchases" type="button"><?= lang('purchases') ?></button>
          </li>
          <?php $first = false; } ?>
          <?php if ($Owner || $Admin || ($GP['transfers-index'] ?? false)) { ?>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= $first ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-transfers" type="button"><?= lang('transfers') ?></button>
          </li>
          <?php $first = false; } ?>
          <?php if ($Owner || $Admin || ($GP['customers-index'] ?? false)) { ?>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= $first ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-customers" type="button"><?= lang('customers') ?></button>
          </li>
          <?php $first = false; } ?>
          <?php if ($Owner || $Admin || ($GP['suppliers-index'] ?? false)) { ?>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= $first ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-suppliers" type="button"><?= lang('suppliers') ?></button>
          </li>
          <?php } ?>
        </ul>

        <div class="tab-content px-0">

          <!-- Sales tab -->
          <?php if ($Owner || $Admin || ($GP['sales-index'] ?? false)) { ?>
          <div class="tab-pane fade show active" id="tab-sales" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('reference_no') ?></th>
                    <th><?= lang('customer') ?></th>
                    <th><?= lang('status') ?></th>
                    <th class="text-end"><?= lang('total') ?></th>
                    <th><?= lang('payment_status') ?></th>
                    <th class="text-end"><?= lang('paid') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($sales)) { $r = 1; foreach ($sales as $order) { ?>
                  <tr class="<?= $order->pos ? 'receipt_link' : 'invoice_link' ?> cursor-pointer" id="<?= $order->id ?>">
                    <td><?= $r++ ?></td>
                    <td><?= $this->sma->hrld($order->date) ?></td>
                    <td><span class="fw-medium"><?= $order->reference_no ?></span></td>
                    <td><?= $order->customer ?></td>
                    <td><?= row_status($order->sale_status) ?></td>
                    <td class="text-end"><?= $this->sma->formatMoney($order->grand_total) ?></td>
                    <td><?= row_status($order->payment_status) ?></td>
                    <td class="text-end"><?= $this->sma->formatMoney($order->paid) ?></td>
                  </tr>
                  <?php } } else { ?>
                  <tr><td colspan="8" class="text-center py-4 text-muted"><?= lang('no_data_available') ?></td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>

          <!-- Quotes tab -->
          <?php if ($Owner || $Admin || ($GP['quotes-index'] ?? false)) { ?>
          <div class="tab-pane fade" id="tab-quotes" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('reference_no') ?></th>
                    <th><?= lang('customer') ?></th>
                    <th><?= lang('status') ?></th>
                    <th class="text-end"><?= lang('amount') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($quotes)) { $r = 1; foreach ($quotes as $quote) { ?>
                  <tr class="quote_link cursor-pointer" id="<?= $quote->id ?>">
                    <td><?= $r++ ?></td>
                    <td><?= $this->sma->hrld($quote->date) ?></td>
                    <td><span class="fw-medium"><?= $quote->reference_no ?></span></td>
                    <td><?= $quote->customer ?></td>
                    <td><?= row_status($quote->status) ?></td>
                    <td class="text-end"><?= $this->sma->formatMoney($quote->grand_total) ?></td>
                  </tr>
                  <?php } } else { ?>
                  <tr><td colspan="6" class="text-center py-4 text-muted"><?= lang('no_data_available') ?></td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>

          <!-- Purchases tab -->
          <?php if ($Owner || $Admin || ($GP['purchases-index'] ?? false)) { ?>
          <div class="tab-pane fade" id="tab-purchases" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('reference_no') ?></th>
                    <th><?= lang('supplier') ?></th>
                    <th><?= lang('status') ?></th>
                    <th class="text-end"><?= lang('amount') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($purchases)) { $r = 1; foreach ($purchases as $purchase) { ?>
                  <tr class="purchase_link cursor-pointer" id="<?= $purchase->id ?>">
                    <td><?= $r++ ?></td>
                    <td><?= $this->sma->hrld($purchase->date) ?></td>
                    <td><span class="fw-medium"><?= $purchase->reference_no ?></span></td>
                    <td><?= $purchase->supplier ?></td>
                    <td><?= row_status($purchase->status) ?></td>
                    <td class="text-end"><?= $this->sma->formatMoney($purchase->grand_total) ?></td>
                  </tr>
                  <?php } } else { ?>
                  <tr><td colspan="6" class="text-center py-4 text-muted"><?= lang('no_data_available') ?></td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>

          <!-- Transfers tab -->
          <?php if ($Owner || $Admin || ($GP['transfers-index'] ?? false)) { ?>
          <div class="tab-pane fade" id="tab-transfers" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('reference_no') ?></th>
                    <th><?= lang('from') ?></th>
                    <th><?= lang('to') ?></th>
                    <th><?= lang('status') ?></th>
                    <th class="text-end"><?= lang('amount') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($transfers)) { $r = 1; foreach ($transfers as $transfer) { ?>
                  <tr class="transfer_link cursor-pointer" id="<?= $transfer->id ?>">
                    <td><?= $r++ ?></td>
                    <td><?= $this->sma->hrld($transfer->date) ?></td>
                    <td><span class="fw-medium"><?= $transfer->transfer_no ?></span></td>
                    <td><?= $transfer->from_warehouse_name ?></td>
                    <td><?= $transfer->to_warehouse_name ?></td>
                    <td><?= row_status($transfer->status) ?></td>
                    <td class="text-end"><?= $this->sma->formatMoney($transfer->grand_total) ?></td>
                  </tr>
                  <?php } } else { ?>
                  <tr><td colspan="7" class="text-center py-4 text-muted"><?= lang('no_data_available') ?></td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>

          <!-- Customers tab -->
          <?php if ($Owner || $Admin || ($GP['customers-index'] ?? false)) { ?>
          <div class="tab-pane fade" id="tab-customers" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th><?= lang('company') ?></th>
                    <th><?= lang('name') ?></th>
                    <th><?= lang('email') ?></th>
                    <th><?= lang('phone') ?></th>
                    <th><?= lang('address') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($customers)) { $r = 1; foreach ($customers as $customer) { ?>
                  <tr class="customer_link cursor-pointer" id="<?= $customer->id ?>">
                    <td><?= $r++ ?></td>
                    <td><?= $customer->company ?></td>
                    <td><?= $customer->name ?></td>
                    <td><?= $customer->email ?></td>
                    <td><?= $customer->phone ?></td>
                    <td><?= $customer->address ?></td>
                  </tr>
                  <?php } } else { ?>
                  <tr><td colspan="6" class="text-center py-4 text-muted"><?= lang('no_data_available') ?></td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>

          <!-- Suppliers tab -->
          <?php if ($Owner || $Admin || ($GP['suppliers-index'] ?? false)) { ?>
          <div class="tab-pane fade" id="tab-suppliers" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th><?= lang('company') ?></th>
                    <th><?= lang('name') ?></th>
                    <th><?= lang('email') ?></th>
                    <th><?= lang('phone') ?></th>
                    <th><?= lang('address') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($suppliers)) { $r = 1; foreach ($suppliers as $supplier) { ?>
                  <tr class="supplier_link cursor-pointer" id="<?= $supplier->id ?>">
                    <td><?= $r++ ?></td>
                    <td><?= $supplier->company ?></td>
                    <td><?= $supplier->name ?></td>
                    <td><?= $supplier->email ?></td>
                    <td><?= $supplier->phone ?></td>
                    <td><?= $supplier->address ?></td>
                  </tr>
                  <?php } } else { ?>
                  <tr><td colspan="6" class="text-center py-4 text-muted"><?= lang('no_data_available') ?></td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>

        </div><!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div><!-- /.card -->
  </div>
</div><!-- /.row -->

<?php if (($Owner || $Admin) && !empty($chatData)) { ?>
<script src="<?= $assets ?>js/hc/highcharts.js"></script>
<script>
$(function () {
    // Palette Materialize
    var colors = ['#7367f0','#28c76f','#ff9f43','#00cfe8','#ea5455','#82868b'];

    var ovChart = new Highcharts.Chart({
        chart: {
            renderTo: 'ov-chart',
            style: { fontFamily: 'Inter, sans-serif' },
            backgroundColor: 'transparent',
            plotBorderWidth: 0,
            spacingTop: 10,
            spacingBottom: 10
        },
        colors: colors,
        credits: { enabled: false },
        title: { text: '' },
        legend: {
            enabled: true,
            align: 'center',
            verticalAlign: 'bottom',
            itemStyle: { fontSize: '12px', fontWeight: '500', color: '#697a8d' },
            itemHoverStyle: { color: '#7367f0' }
        },
        xAxis: {
            categories: <?= json_encode($months) ?>,
            labels: { style: { color: '#697a8d', fontSize: '12px' } },
            lineColor: 'rgba(0,0,0,.06)',
            tickColor: 'rgba(0,0,0,.06)'
        },
        yAxis: {
            min: 0,
            title: { text: '' },
            labels: {
                style: { color: '#697a8d', fontSize: '12px' },
                formatter: function () { return currencyFormat(this.value); }
            },
            gridLineColor: 'rgba(0,0,0,.06)'
        },
        plotOptions: {
            column: { borderRadius: 4, borderWidth: 0, groupPadding: 0.1 },
            spline: { lineWidth: 2 },
            series: { animation: { duration: 600 } }
        },
        tooltip: {
            shared: true,
            followPointer: true,
            backgroundColor: '#fff',
            borderColor: 'rgba(0,0,0,.08)',
            borderRadius: 8,
            shadow: false,
            style: { color: '#697a8d', fontSize: '13px' },
            formatter: function () {
                var s = '<b>' + this.x + '</b><br/>';
                $.each(this.points, function () {
                    s += '<span style="color:' + this.color + '">●</span> ' +
                         this.series.name + ': <b>' + currencyFormat(this.y) + '</b><br/>';
                });
                return s;
            },
            useHTML: true
        },
        series: [
            { type: 'column', name: '<?= lang("sp_tax") ?>',    data: [<?= implode(',', $mtax1) ?>] },
            { type: 'column', name: '<?= lang("order_tax") ?>', data: [<?= implode(',', $mtax2) ?>] },
            { type: 'column', name: '<?= lang("sales") ?>',     data: [<?= implode(',', $msales) ?>] },
            { type: 'spline', name: '<?= lang("purchases") ?>', data: [<?= implode(',', $mpurchases) ?>], marker: { lineWidth: 2, fillColor: 'white' } },
            { type: 'spline', name: '<?= lang("pp_tax") ?>',    data: [<?= implode(',', $mtax3) ?>],    marker: { lineWidth: 2, fillColor: 'white' } },
            { type: 'pie',
              name: '<?= lang("stock_value") ?>',
              data: [
                ['', 0], ['', 0],
                ['<?= lang("stock_value_by_price") ?>', <?= $stock->stock_by_price ?>],
                ['<?= lang("stock_value_by_cost") ?>',  <?= $stock->stock_by_cost ?>]
              ],
              center: [80, 42], size: 80, showInLegend: false, dataLabels: { enabled: false }
            }
        ]
    });

    // Reflow quand le sidebar se replie
    $(document).on('click', '.layout-menu-toggle', function () {
        setTimeout(function () { ovChart.reflow(); }, 350);
    });
});
</script>
<?php } ?>

<style>
.quick-link-item { transition: all .2s; }
.quick-link-item:hover { background: var(--bs-primary-bg-subtle); border-color: var(--bs-primary) !important; }
.cursor-pointer { cursor: pointer; }
.col-xl-1-5 { flex: 0 0 auto; width: 20%; }
@media (max-width: 1199px) { .col-xl-1-5 { width: 33.33%; } }
@media (max-width: 767px) { .col-xl-1-5 { width: 50%; } }
</style>