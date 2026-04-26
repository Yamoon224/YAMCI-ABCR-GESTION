<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($Owner || $Admin) {
    foreach ($monthly_sales as $month_sale) {
        $months[]    = date('M-Y', strtotime($month_sale->month));
        $sales[]     = $month_sale->sales;
        $tax1[]      = $month_sale->tax1;
        $tax2[]      = $month_sale->tax2;
        $purchases[] = $month_sale->purchases;
        $tax3[]      = $month_sale->ptax;
    } ?>
    <script src="<?= $assets; ?>js/hc/highcharts.js"></script>
    <script type="text/javascript">
        $(function () {
            var colors = ['#7367f0','#28c76f','#ff9f43','#00cfe8','#ea5455','#82868b'];
            var rptChart = new Highcharts.Chart({
                chart: {
                    renderTo: 'chart',
                    style: { fontFamily: 'Inter, sans-serif' },
                    backgroundColor: 'transparent',
                    spacingTop: 10, spacingBottom: 10
                },
                colors: colors,
                credits: { enabled: false },
                title: { text: '' },
                legend: {
                    enabled: true, align: 'center', verticalAlign: 'bottom',
                    itemStyle: { fontSize: '12px', fontWeight: '500', color: '#697a8d' },
                    itemHoverStyle: { color: '#7367f0' }
                },
                xAxis: {
                    categories: <?= json_encode($months); ?>,
                    labels: { style: { color: '#697a8d', fontSize: '12px' } },
                    lineColor: 'rgba(0,0,0,.06)', tickColor: 'rgba(0,0,0,.06)'
                },
                yAxis: {
                    min: 0, title: { text: '' },
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
                    shared: true, followPointer: true,
                    backgroundColor: '#fff',
                    borderColor: 'rgba(0,0,0,.08)', borderRadius: 8,
                    shadow: false,
                    style: { color: '#697a8d', fontSize: '13px' },
                    formatter: function () {
                        var s = '<b>' + this.x + '</b><br/>';
                        $.each(this.points, function () {
                            s += '<span style="color:' + this.color + '">●</span> ' +
                                 this.series.name + ': <b>' + currencyFormat(this.y) + '</b><br/>';
                        });
                        return s;
                    }
                },
                series: [
                    { type: 'column', name: '<?= lang('sp_tax'); ?>',    data: [<?= implode(',', $tax1); ?>] },
                    { type: 'column', name: '<?= lang('order_tax'); ?>', data: [<?= implode(',', $tax2); ?>] },
                    { type: 'column', name: '<?= lang('sales'); ?>',     data: [<?= implode(',', $sales); ?>] },
                    { type: 'spline', name: '<?= lang('purchases'); ?>', data: [<?= implode(',', $purchases); ?>], marker: { lineWidth: 2, fillColor: 'white' } },
                    { type: 'spline', name: '<?= lang('pp_tax'); ?>',    data: [<?= implode(',', $tax3); ?>],    marker: { lineWidth: 2, fillColor: 'white' } },
                    { type: 'pie', name: '<?= lang('stock_value'); ?>',
                      data: [['',0],['',0],['<?= lang('stock_value_by_price'); ?>', <?= $stock->stock_by_price; ?>],['<?= lang('stock_value_by_cost'); ?>', <?= $stock->stock_by_cost; ?>]],
                      center: [80, 42], size: 80, showInLegend: false, dataLabels: { enabled: false }
                    }
                ]
            });
            $(document).on('click', '.layout-menu-toggle', function () {
                setTimeout(function () { rptChart.reflow(); }, 350);
            });
        });
    </script>
<?php
} ?>
    <div class="card">
        <div class="box-header">
            <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('quick_links') ?></h2>
        </div>
        <div class="box-content">
            <div class="row">

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bblue white quick-button" href="<?= admin_url('reports/warehouse_stock') ?>">
                        <i class="fa fa-building"></i>

                        <p><?= lang('warehouse_stock') ?></p>
                    </a>
                </div>
                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bblue white quick-button" href="<?= admin_url('reports/best_sellers') ?>">
                        <i class="fa fa-line-chart"></i>

                        <p><?= lang('best_sellers') ?></p>
                    </a>
                </div>
                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bred white quick-button" href="<?= admin_url('reports/quantity_alerts') ?>">
                        <i class="fa fa-bar-chart-o"></i>

                        <p><?= lang('product_quantity_alerts') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bred white quick-button" href="<?= admin_url('reports/expiry_alerts') ?>">
                        <i class="fa fa-bar-chart-o"></i>

                        <p><?= lang('product_expiry_alerts') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bblue white quick-button" href="<?= admin_url('reports/products') ?>">
                        <i class="fa fa-barcode"></i>

                        <p><?= lang('products_report') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bdarkGreen white quick-button" href="<?= admin_url('reports/daily_sales') ?>">
                        <i class="fa fa-calendar-o"></i>

                        <p><?= lang('daily_sales') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bdarkGreen white quick-button" href="<?= admin_url('reports/monthly_sales') ?>">
                        <i class="fa fa-calendar-o"></i>

                        <p><?= lang('monthly_sales') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="bdarkGreen white quick-button" href="<?= admin_url('reports/sales') ?>">
                        <i class="fa fa-heart"></i>

                        <p><?= lang('sales_report') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="blightOrange white quick-button" href="<?= admin_url('reports/payments') ?>">
                        <i class="fa fa-money"></i>

                        <p><?= lang('payments_report') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="blightOrange white quick-button" href="<?= admin_url('reports/profit_loss') ?>">
                        <i class="fa fa-money"></i>

                        <p><?= lang('profit_and_loss') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="blightBlue white quick-button" href="<?= admin_url('reports/purchases') ?>">
                        <i class="fa fa-star"></i>

                        <p><?= lang('purchases_report') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="borange white quick-button" href="<?= admin_url('reports/customers') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('customers_report') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="borange white quick-button" href="<?= admin_url('reports/suppliers') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('suppliers_report') ?></p>
                    </a>
                </div>

                <div class="col-md-2 col-xs-4 padding1010">
                    <a class="borange white quick-button" href="<?= admin_url('reports/staff_report') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('staff_report') ?></p>
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

<?php if ($Owner || $Admin) {
                        ?>
    <div class="card" style="margin-top: 15px;">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i><?= lang('overview_chart'); ?></h2>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-lg-12">
                    <p class="introtext"><?php echo lang('overview_chart_heading'); ?></p>

                    <div id="chart" style="width:100%; height:450px;"></div>
                    <p class="text-center"><?= lang('chart_lable_toggle'); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php
                    } ?>
