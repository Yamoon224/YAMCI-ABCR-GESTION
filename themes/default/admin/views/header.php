<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="<?= $Settings->user_language ?>" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr' ?>" data-skin="default" data-bs-theme="light" data-assets-path="<?= $assets ?>materialize/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <base href="<?= site_url() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?= $page_title ?> - <?= $Settings->site_name ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- Core Materialize CSS -->
    <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= $assets ?>materialize/css/demo.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- iCheck (checkboxes/radios requis par core.js) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/blue.css" />
    <!-- DateRangePicker (requis par core.js #daterange) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" />

    <!-- Pickr (color picker pour le panneau de personnalisation) -->
    <link rel="stylesheet" href="<?= $assets ?>materialize/vendor/libs/pickr/pickr-themes.css" />

    <!-- Custom CSS -->
    <link href="<?= base_url('assets/custom/custom.css') ?>" rel="stylesheet"/>

    <!-- jQuery chargé dans <head> pour que les scripts inline des vues fonctionnent -->
    <script src="<?= $assets ?>materialize/vendor/libs/jquery/jquery.js"></script>
    <!-- jQuery Migrate 3.x : restaure $(window).load() et autres APIs dépréciées en jQuery 3.x -->
    <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>

    <!-- Helpers + Template Customizer (requis par helpers.js getStoredTheme + mode sombre) -->
    <script src="<?= $assets ?>materialize/vendor/js/helpers.js"></script>
    <script src="<?= $assets ?>materialize/vendor/js/template-customizer.js"></script>
    <script src="<?= $assets ?>materialize/js/config.js"></script>
</head>

<body>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">

    <!-- Sidebar / Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu">
      <div class="app-brand demo">
        <a href="<?= admin_url() ?>" class="app-brand-link">
          <span class="app-brand-text demo menu-text fw-semibold ms-2"><?= $Settings->site_name ?></span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
          <i class="icon-base ri ri-close-line d-xl-none"></i>
          <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="d-none d-xl-block">
            <path d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z" fill-opacity="0.9"></path>
            <path d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z" fill-opacity="0.4"></path>
          </svg>
        </a>
      </div>
      <div class="menu-inner-shadow"></div>
      <ul class="menu-inner py-1">

        <!-- Dashboard -->
        <li class="menu-item mm_welcome">
          <a href="<?= admin_url() ?>" class="menu-link">
            <i class="menu-icon fa fa-dashboard"></i>
            <div><?= lang('dashboard') ?></div>
          </a>
        </li>

        <?php if ($Owner || $Admin) { ?>

        <!-- Produits -->
        <li class="menu-item mm_products">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-barcode"></i>
            <div><?= lang('products') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="products_index"><a href="<?= admin_url('products') ?>" class="menu-link"><div><?= lang('list_products') ?></div></a></li>
            <li class="menu-item" id="products_add"><a href="<?= admin_url('products/add') ?>" class="menu-link"><div><?= lang('add_product') ?></div></a></li>
            <li class="menu-item" id="products_import_csv"><a href="<?= admin_url('products/import_csv') ?>" class="menu-link"><div><?= lang('import_products') ?></div></a></li>
            <li class="menu-item" id="products_print_barcodes"><a href="<?= admin_url('products/print_barcodes') ?>" class="menu-link"><div><?= lang('print_barcode_label') ?></div></a></li>
            <li class="menu-item" id="products_quantity_adjustments"><a href="<?= admin_url('products/quantity_adjustments') ?>" class="menu-link"><div><?= lang('quantity_adjustments') ?></div></a></li>
            <li class="menu-item" id="products_add_adjustment"><a href="<?= admin_url('products/add_adjustment') ?>" class="menu-link"><div><?= lang('add_adjustment') ?></div></a></li>
            <li class="menu-item" id="products_stock_counts"><a href="<?= admin_url('products/stock_counts') ?>" class="menu-link"><div><?= lang('stock_counts') ?></div></a></li>
            <li class="menu-item" id="products_count_stock"><a href="<?= admin_url('products/count_stock') ?>" class="menu-link"><div><?= lang('count_stock') ?></div></a></li>
          </ul>
        </li>

        <!-- Ventes -->
        <li class="menu-item mm_sales <?= strtolower($this->router->fetch_method()) == 'sales' ? 'mm_pos' : '' ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-money"></i>
            <div><?= lang('sales') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="sales_index"><a href="<?= admin_url('sales') ?>" class="menu-link"><div><?= lang('list_sales') ?></div></a></li>
            <?php if (POS) { ?><li class="menu-item" id="pos_sales"><a href="<?= admin_url('pos/sales') ?>" class="menu-link"><div><?= lang('pos_sales') ?></div></a></li><?php } ?>
            <li class="menu-item" id="sales_add"><a href="<?= admin_url('sales/add') ?>" class="menu-link"><div><?= lang('add_sale') ?></div></a></li>
            <li class="menu-item" id="sales_sale_by_csv"><a href="<?= admin_url('sales/sale_by_csv') ?>" class="menu-link"><div><?= lang('add_sale_by_csv') ?></div></a></li>
            <li class="menu-item" id="sales_deliveries"><a href="<?= admin_url('sales/deliveries') ?>" class="menu-link"><div><?= lang('deliveries') ?></div></a></li>
          </ul>
        </li>

        <!-- Devis -->
        <li class="menu-item mm_quotes">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-heart-o"></i>
            <div><?= lang('quotes') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="quotes_index"><a href="<?= admin_url('quotes') ?>" class="menu-link"><div><?= lang('list_quotes') ?></div></a></li>
            <li class="menu-item" id="quotes_add"><a href="<?= admin_url('quotes/add') ?>" class="menu-link"><div><?= lang('add_quote') ?></div></a></li>
          </ul>
        </li>

        <!-- Achats -->
        <li class="menu-item mm_purchases">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-star"></i>
            <div><?= lang('purchases') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="purchases_index"><a href="<?= admin_url('purchases') ?>" class="menu-link"><div><?= lang('list_purchases') ?></div></a></li>
            <li class="menu-item" id="purchases_add"><a href="<?= admin_url('purchases/add') ?>" class="menu-link"><div><?= lang('add_purchase') ?></div></a></li>
            <li class="menu-item" id="purchases_purchase_by_csv"><a href="<?= admin_url('purchases/purchase_by_csv') ?>" class="menu-link"><div><?= lang('add_purchase_by_csv') ?></div></a></li>
            <li class="menu-item" id="purchases_expenses"><a href="<?= admin_url('purchases/expenses') ?>" class="menu-link"><div><?= lang('list_expenses') ?></div></a></li>
            <li class="menu-item" id="purchases_add_expense"><a href="<?= admin_url('purchases/add_expense') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('add_expense') ?></div></a></li>
          </ul>
        </li>

        <!-- Transferts -->
        <li class="menu-item mm_transfers">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-star-o"></i>
            <div><?= lang('transfers') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="transfers_index"><a href="<?= admin_url('transfers') ?>" class="menu-link"><div><?= lang('list_transfers') ?></div></a></li>
            <li class="menu-item" id="transfers_add"><a href="<?= admin_url('transfers/add') ?>" class="menu-link"><div><?= lang('add_transfer') ?></div></a></li>
            <li class="menu-item" id="transfers_purchase_by_csv"><a href="<?= admin_url('transfers/transfer_by_csv') ?>" class="menu-link"><div><?= lang('add_transfer_by_csv') ?></div></a></li>
          </ul>
        </li>

        <!-- Retours -->
        <li class="menu-item mm_returns">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-random"></i>
            <div><?= lang('Retournés') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="returns_index"><a href="<?= admin_url('returns') ?>" class="menu-link"><div><?= lang('Liste des retours') ?></div></a></li>
            <li class="menu-item" id="returns_add"><a href="<?= admin_url('returns/add') ?>" class="menu-link"><div><?= lang('Ajouter') ?></div></a></li>
          </ul>
        </li>

        <!-- Personnes -->
        <li class="menu-item mm_auth mm_customers mm_suppliers mm_billers">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-users"></i>
            <div><?= lang('people') ?></div>
          </a>
          <ul class="menu-sub">
            <?php if ($Owner) { ?>
            <li class="menu-item" id="auth_users"><a href="<?= admin_url('users') ?>" class="menu-link"><div><?= lang('list_users') ?></div></a></li>
            <li class="menu-item" id="auth_create_user"><a href="<?= admin_url('users/create_user') ?>" class="menu-link"><div><?= lang('new_user') ?></div></a></li>
            <li class="menu-item" id="billers_index"><a href="<?= admin_url('billers') ?>" class="menu-link"><div><?= lang('list_billers') ?></div></a></li>
            <li class="menu-item"><a href="<?= admin_url('billers/add') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('add_biller') ?></div></a></li>
            <?php } ?>
            <li class="menu-item" id="customers_index"><a href="<?= admin_url('customers') ?>" class="menu-link"><div><?= lang('list_customers') ?></div></a></li>
            <li class="menu-item"><a href="<?= admin_url('customers/add') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('add_customer') ?></div></a></li>
            <li class="menu-item" id="suppliers_index"><a href="<?= admin_url('suppliers') ?>" class="menu-link"><div><?= lang('list_suppliers') ?></div></a></li>
            <li class="menu-item"><a href="<?= admin_url('suppliers/add') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('add_supplier') ?></div></a></li>
          </ul>
        </li>

        <!-- Notifications -->
        <li class="menu-item mm_notifications">
          <a href="<?= admin_url('notifications') ?>" class="menu-link">
            <i class="menu-icon fa fa-info-circle"></i>
            <div><?= lang('notifications') ?></div>
          </a>
        </li>

        <!-- Calendrier -->
        <li class="menu-item mm_calendar">
          <a href="<?= admin_url('calendar') ?>" class="menu-link">
            <i class="menu-icon fa fa-calendar"></i>
            <div><?= lang('calendar') ?></div>
          </a>
        </li>

        <!-- Rapports -->
        <li class="menu-item mm_reports">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-bar-chart-o"></i>
            <div><?= lang('reports') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="reports_best_sellers"><a href="<?= admin_url('reports/best_sellers') ?>" class="menu-link"><div><?= lang('best_sellers') ?></div></a></li>
            <li class="menu-item" id="reports_quantity_alerts"><a href="<?= admin_url('reports/quantity_alerts') ?>" class="menu-link"><div><?= lang('product_quantity_alerts') ?></div></a></li>
            <?php if ($Settings->product_expiry) { ?>
            <li class="menu-item" id="reports_expiry_alerts"><a href="<?= admin_url('reports/expiry_alerts') ?>" class="menu-link"><div><?= lang('product_expiry_alerts') ?></div></a></li>
            <?php } ?>
            <li class="menu-item" id="reports_products"><a href="<?= admin_url('reports/products') ?>" class="menu-link"><div><?= lang('products_report') ?></div></a></li>
            <li class="menu-item" id="reports_adjustments"><a href="<?= admin_url('reports/adjustments') ?>" class="menu-link"><div><?= lang('adjustments_report') ?></div></a></li>
            <li class="menu-item" id="reports_categories"><a href="<?= admin_url('reports/categories') ?>" class="menu-link"><div><?= lang('Rapport sur les catégories') ?></div></a></li>
            <li class="menu-item" id="reports_daily_sales"><a href="<?= admin_url('reports/daily_sales') ?>" class="menu-link"><div><?= lang('daily_sales') ?></div></a></li>
            <li class="menu-item" id="reports_monthly_sales"><a href="<?= admin_url('reports/monthly_sales') ?>" class="menu-link"><div><?= lang('monthly_sales') ?></div></a></li>
            <li class="menu-item" id="reports_sales"><a href="<?= admin_url('reports/sales') ?>" class="menu-link"><div><?= lang('sales_report') ?></div></a></li>
            <li class="menu-item" id="reports_returns"><a href="<?= admin_url('reports/returns') ?>" class="menu-link"><div><?= lang('Les retours') ?></div></a></li>
            <li class="menu-item" id="reports_payments"><a href="<?= admin_url('reports/payments') ?>" class="menu-link"><div><?= lang('payments_report') ?></div></a></li>
            <li class="menu-item" id="reports_tax"><a href="<?= admin_url('reports/tax') ?>" class="menu-link"><div><?= lang('Rapport de taxe') ?></div></a></li>
            <li class="menu-item" id="reports_profit_loss"><a href="<?= admin_url('reports/profit_loss') ?>" class="menu-link"><div><?= lang('profit_and_loss') ?></div></a></li>
            <li class="menu-item" id="reports_daily_purchases"><a href="<?= admin_url('reports/daily_purchases') ?>" class="menu-link"><div><?= lang('daily_purchases') ?></div></a></li>
            <li class="menu-item" id="reports_monthly_purchases"><a href="<?= admin_url('reports/monthly_purchases') ?>" class="menu-link"><div><?= lang('monthly_purchases') ?></div></a></li>
            <li class="menu-item" id="reports_purchases"><a href="<?= admin_url('reports/purchases') ?>" class="menu-link"><div><?= lang('purchases_report') ?></div></a></li>
            <li class="menu-item" id="reports_expenses"><a href="<?= admin_url('reports/expenses') ?>" class="menu-link"><div><?= lang('expenses_report') ?></div></a></li>
            <li class="menu-item" id="reports_customer_report"><a href="<?= admin_url('reports/customers') ?>" class="menu-link"><div><?= lang('customers_report') ?></div></a></li>
            <li class="menu-item" id="reports_supplier_report"><a href="<?= admin_url('reports/suppliers') ?>" class="menu-link"><div><?= lang('suppliers_report') ?></div></a></li>
            <li class="menu-item" id="reports_staff_report"><a href="<?= admin_url('reports/users') ?>" class="menu-link"><div><?= lang('staff_report') ?></div></a></li>
          </ul>
        </li>

        <!-- Paramètres (Owner) -->
        <?php if ($Owner) { ?>
        <li class="menu-item mm_system_settings <?= strtolower($this->router->fetch_method()) == 'sales' ? '' : 'mm_pos' ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-cog"></i>
            <div><?= lang('settings') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="system_settings_index"><a href="<?= admin_url('system_settings') ?>" class="menu-link"><div><?= lang('system_settings') ?></div></a></li>
            <?php if (POS) { ?>
            <li class="menu-item" id="pos_settings"><a href="<?= admin_url('pos/settings') ?>" class="menu-link"><div><?= lang('pos_settings') ?></div></a></li>
            <li class="menu-item" id="promos_index"><a href="<?= admin_url('promos') ?>" class="menu-link"><div><?= lang('promos') ?></div></a></li>
            <li class="menu-item" id="pos_printers"><a href="<?= admin_url('pos/printers') ?>" class="menu-link"><div><?= lang('list_printers') ?></div></a></li>
            <li class="menu-item" id="pos_add_printer"><a href="<?= admin_url('pos/add_printer') ?>" class="menu-link"><div><?= lang('add_printer') ?></div></a></li>
            <?php } ?>
            <li class="menu-item" id="system_settings_change_logo"><a href="<?= admin_url('system_settings/change_logo') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('change_logo') ?></div></a></li>
            <li class="menu-item" id="system_settings_currencies"><a href="<?= admin_url('system_settings/currencies') ?>" class="menu-link"><div><?= lang('currencies') ?></div></a></li>
            <li class="menu-item" id="system_settings_customer_groups"><a href="<?= admin_url('system_settings/customer_groups') ?>" class="menu-link"><div><?= lang('customer_groups') ?></div></a></li>
            <li class="menu-item" id="system_settings_price_groups"><a href="<?= admin_url('system_settings/price_groups') ?>" class="menu-link"><div><?= lang('price_groups') ?></div></a></li>
            <li class="menu-item" id="system_settings_categories"><a href="<?= admin_url('system_settings/categories') ?>" class="menu-link"><div><?= lang('categories') ?></div></a></li>
            <li class="menu-item" id="system_settings_expense_categories"><a href="<?= admin_url('system_settings/expense_categories') ?>" class="menu-link"><div><?= lang('expense_categories') ?></div></a></li>
            <li class="menu-item" id="system_settings_units"><a href="<?= admin_url('system_settings/units') ?>" class="menu-link"><div><?= lang('units') ?></div></a></li>
            <li class="menu-item" id="system_settings_brands"><a href="<?= admin_url('system_settings/brands') ?>" class="menu-link"><div><?= lang('brands') ?></div></a></li>
            <li class="menu-item" id="system_settings_variants"><a href="<?= admin_url('system_settings/variants') ?>" class="menu-link"><div><?= lang('variants') ?></div></a></li>
            <li class="menu-item" id="system_settings_tax_rates"><a href="<?= admin_url('system_settings/tax_rates') ?>" class="menu-link"><div><?= lang('tax_rates') ?></div></a></li>
            <li class="menu-item" id="system_settings_warehouses"><a href="<?= admin_url('system_settings/warehouses') ?>" class="menu-link"><div><?= lang('warehouses') ?></div></a></li>
            <li class="menu-item" id="system_settings_email_templates"><a href="<?= admin_url('system_settings/email_templates') ?>" class="menu-link"><div><?= lang('email_templates') ?></div></a></li>
            <li class="menu-item" id="system_settings_user_groups"><a href="<?= admin_url('system_settings/user_groups') ?>" class="menu-link"><div><?= lang('group_permissions') ?></div></a></li>
            <li class="menu-item" id="site_logs_index"><a href="<?= admin_url('site_logs') ?>" class="menu-link"><div><?= lang('site_logs') ?></div></a></li>
            <li class="menu-item" id="system_settings_backups"><a href="<?= admin_url('system_settings/backups') ?>" class="menu-link"><div><?= lang('backups') ?></div></a></li>
          </ul>
        </li>

        <!-- Front-end / Shop -->
        <?php if (file_exists(APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR . 'Shop.php')) { ?>
        <li class="menu-item mm_shop_settings mm_api_settings">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-shopping-cart"></i>
            <div><?= lang('front_end') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="shop_settings_index"><a href="<?= admin_url('shop_settings') ?>" class="menu-link"><div><?= lang('shop_settings') ?></div></a></li>
            <li class="menu-item" id="shop_settings_slider"><a href="<?= admin_url('shop_settings/slider') ?>" class="menu-link"><div><?= lang('slider_settings') ?></div></a></li>
            <?php if ($Settings->apis) { ?>
            <li class="menu-item" id="api_settings_index"><a href="<?= admin_url('api_settings') ?>" class="menu-link"><div><?= lang('api_keys') ?></div></a></li>
            <?php } ?>
            <li class="menu-item" id="shop_settings_pages"><a href="<?= admin_url('shop_settings/pages') ?>" class="menu-link"><div><?= lang('list_pages') ?></div></a></li>
            <li class="menu-item"><a href="<?= admin_url('shop_settings/add_page') ?>" class="menu-link"><div><?= lang('add_page') ?></div></a></li>
            <li class="menu-item" id="shop_settings_sms_settings"><a href="<?= admin_url('shop_settings/sms_settings') ?>" class="menu-link"><div><?= lang('sms_settings') ?></div></a></li>
            <li class="menu-item" id="shop_settings_send_sms"><a href="<?= admin_url('shop_settings/send_sms') ?>" class="menu-link"><div><?= lang('send_sms') ?></div></a></li>
            <li class="menu-item" id="shop_settings_sms_log"><a href="<?= admin_url('shop_settings/sms_log') ?>" class="menu-link"><div><?= lang('sms_log') ?></div></a></li>
          </ul>
        </li>
        <?php } ?>
        <?php } // end Owner ?>
        <?php } // end Owner || Admin ?>

        <!-- Menu utilisateur normal ($GP permissions) -->
        <?php if (!$Owner && !$Admin) {
          if ($GP['products-index'] || $GP['products-add'] || $GP['products-barcode'] || $GP['products-adjustments'] || $GP['products-stock_count']) { ?>
        <li class="menu-item mm_products">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-barcode"></i><div><?= lang('products') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="products_index"><a href="<?= admin_url('products') ?>" class="menu-link"><div><?= lang('list_products') ?></div></a></li>
            <?php if ($GP['products-add']) { ?><li class="menu-item" id="products_add"><a href="<?= admin_url('products/add') ?>" class="menu-link"><div><?= lang('add_product') ?></div></a></li><?php } ?>
            <?php if ($GP['products-barcode']) { ?><li class="menu-item" id="products_sheet"><a href="<?= admin_url('products/print_barcodes') ?>" class="menu-link"><div><?= lang('print_barcode_label') ?></div></a></li><?php } ?>
            <?php if ($GP['products-adjustments']) { ?>
            <li class="menu-item" id="products_quantity_adjustments"><a href="<?= admin_url('products/quantity_adjustments') ?>" class="menu-link"><div><?= lang('quantity_adjustments') ?></div></a></li>
            <li class="menu-item" id="products_add_adjustment"><a href="<?= admin_url('products/add_adjustment') ?>" class="menu-link"><div><?= lang('add_adjustment') ?></div></a></li>
            <?php } ?>
            <?php if ($GP['products-stock_count']) { ?>
            <li class="menu-item" id="products_stock_counts"><a href="<?= admin_url('products/stock_counts') ?>" class="menu-link"><div><?= lang('stock_counts') ?></div></a></li>
            <li class="menu-item" id="products_count_stock"><a href="<?= admin_url('products/count_stock') ?>" class="menu-link"><div><?= lang('count_stock') ?></div></a></li>
            <?php } ?>
          </ul>
        </li>
          <?php } ?>
          <?php if ($GP['sales-index'] || $GP['sales-add'] || $GP['sales-deliveries']) { ?>
        <li class="menu-item mm_sales <?= strtolower($this->router->fetch_method()) == 'sales' ? 'mm_pos' : '' ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-heart"></i><div><?= lang('sales') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="sales_index"><a href="<?= admin_url('sales') ?>" class="menu-link"><div><?= lang('list_sales') ?></div></a></li>
            <?php if (POS && $GP['pos-index']) { ?><li class="menu-item" id="pos_sales"><a href="<?= admin_url('pos/sales') ?>" class="menu-link"><div><?= lang('pos_sales') ?></div></a></li><?php } ?>
            <?php if ($GP['sales-add']) { ?><li class="menu-item" id="sales_add"><a href="<?= admin_url('sales/add') ?>" class="menu-link"><div><?= lang('add_sale') ?></div></a></li><?php } ?>
            <?php if ($GP['sales-deliveries']) { ?><li class="menu-item" id="sales_deliveries"><a href="<?= admin_url('sales/deliveries') ?>" class="menu-link"><div><?= lang('deliveries') ?></div></a></li><?php } ?>
          </ul>
        </li>
          <?php } ?>
          <?php if ($GP['quotes-index'] || $GP['quotes-add']) { ?>
        <li class="menu-item mm_quotes">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-heart-o"></i><div><?= lang('quotes') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="quotes_index"><a href="<?= admin_url('quotes') ?>" class="menu-link"><div><?= lang('list_quotes') ?></div></a></li>
            <?php if ($GP['quotes-add']) { ?><li class="menu-item" id="quotes_add"><a href="<?= admin_url('quotes/add') ?>" class="menu-link"><div><?= lang('add_quote') ?></div></a></li><?php } ?>
          </ul>
        </li>
          <?php } ?>
          <?php if ($GP['purchases-index'] || $GP['purchases-add'] || $GP['purchases-expenses']) { ?>
        <li class="menu-item mm_purchases">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-star"></i><div><?= lang('purchases') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="purchases_index"><a href="<?= admin_url('purchases') ?>" class="menu-link"><div><?= lang('list_purchases') ?></div></a></li>
            <?php if ($GP['purchases-add']) { ?><li class="menu-item" id="purchases_add"><a href="<?= admin_url('purchases/add') ?>" class="menu-link"><div><?= lang('add_purchase') ?></div></a></li><?php } ?>
            <?php if ($GP['purchases-expenses']) { ?>
            <li class="menu-item" id="purchases_expenses"><a href="<?= admin_url('purchases/expenses') ?>" class="menu-link"><div><?= lang('list_expenses') ?></div></a></li>
            <li class="menu-item" id="purchases_add_expense"><a href="<?= admin_url('purchases/add_expense') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('add_expense') ?></div></a></li>
            <?php } ?>
          </ul>
        </li>
          <?php } ?>
          <?php if ($GP['transfers-index'] || $GP['transfers-add']) { ?>
        <li class="menu-item mm_transfers">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-star-o"></i><div><?= lang('transfers') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="transfers_index"><a href="<?= admin_url('transfers') ?>" class="menu-link"><div><?= lang('list_transfers') ?></div></a></li>
            <?php if ($GP['transfers-add']) { ?><li class="menu-item" id="transfers_add"><a href="<?= admin_url('transfers/add') ?>" class="menu-link"><div><?= lang('add_transfer') ?></div></a></li><?php } ?>
          </ul>
        </li>
          <?php } ?>
          <?php if ($GP['returns-index'] || $GP['returns-add']) { ?>
        <li class="menu-item mm_returns">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-random"></i><div><?= lang('returns') ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item" id="returns_index"><a href="<?= admin_url('returns') ?>" class="menu-link"><div><?= lang('list_returns') ?></div></a></li>
            <?php if ($GP['returns-add']) { ?><li class="menu-item" id="returns_add"><a href="<?= admin_url('returns/add') ?>" class="menu-link"><div><?= lang('add_return') ?></div></a></li><?php } ?>
          </ul>
        </li>
          <?php } ?>
          <?php if ($GP['customers-index'] || $GP['customers-add'] || $GP['suppliers-index'] || $GP['suppliers-add']) { ?>
        <li class="menu-item mm_auth mm_customers mm_suppliers mm_billers">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-users"></i><div><?= lang('people') ?></div>
          </a>
          <ul class="menu-sub">
            <?php if ($GP['customers-index']) { ?><li class="menu-item" id="customers_index"><a href="<?= admin_url('customers') ?>" class="menu-link"><div><?= lang('list_customers') ?></div></a></li><?php } ?>
            <?php if ($GP['customers-add']) { ?><li class="menu-item"><a href="<?= admin_url('customers/add') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('add_customer') ?></div></a></li><?php } ?>
            <?php if ($GP['suppliers-index']) { ?><li class="menu-item" id="suppliers_index"><a href="<?= admin_url('suppliers') ?>" class="menu-link"><div><?= lang('list_suppliers') ?></div></a></li><?php } ?>
            <?php if ($GP['suppliers-add']) { ?><li class="menu-item"><a href="<?= admin_url('suppliers/add') ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal"><div><?= lang('add_supplier') ?></div></a></li><?php } ?>
          </ul>
        </li>
          <?php } ?>
          <?php if ($GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts'] || $GP['reports-products'] || $GP['reports-monthly_sales'] || $GP['reports-sales'] || $GP['reports-payments'] || $GP['reports-purchases'] || $GP['reports-customers'] || $GP['reports-suppliers'] || $GP['reports-staff'] || $GP['reports-expenses']) { ?>
        <li class="menu-item mm_reports">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-bar-chart-o"></i><div><?= lang('reports') ?></div>
          </a>
          <ul class="menu-sub">
            <?php if ($GP['reports-quantity_alerts']) { ?><li class="menu-item" id="reports_quantity_alerts"><a href="<?= admin_url('reports/quantity_alerts') ?>" class="menu-link"><div><?= lang('product_quantity_alerts') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-expiry_alerts'] && $Settings->product_expiry) { ?><li class="menu-item" id="reports_expiry_alerts"><a href="<?= admin_url('reports/expiry_alerts') ?>" class="menu-link"><div><?= lang('product_expiry_alerts') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-products']) { ?>
            <li class="menu-item" id="reports_products"><a href="<?= admin_url('reports/products') ?>" class="menu-link"><div><?= lang('products_report') ?></div></a></li>
            <li class="menu-item" id="reports_adjustments"><a href="<?= admin_url('reports/adjustments') ?>" class="menu-link"><div><?= lang('adjustments_report') ?></div></a></li>
            <?php } ?>
            <?php if ($GP['reports-monthly_sales']) { ?><li class="menu-item" id="reports_monthly_sales"><a href="<?= admin_url('reports/monthly_sales') ?>" class="menu-link"><div><?= lang('monthly_sales') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-sales']) { ?><li class="menu-item" id="reports_sales"><a href="<?= admin_url('reports/sales') ?>" class="menu-link"><div><?= lang('sales_report') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-payments']) { ?><li class="menu-item" id="reports_payments"><a href="<?= admin_url('reports/payments') ?>" class="menu-link"><div><?= lang('payments_report') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-purchases']) { ?><li class="menu-item" id="reports_purchases"><a href="<?= admin_url('reports/purchases') ?>" class="menu-link"><div><?= lang('purchases_report') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-expenses']) { ?><li class="menu-item" id="reports_expenses"><a href="<?= admin_url('reports/expenses') ?>" class="menu-link"><div><?= lang('expenses_report') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-customers']) { ?><li class="menu-item" id="reports_customer_report"><a href="<?= admin_url('reports/customers') ?>" class="menu-link"><div><?= lang('customers_report') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-suppliers']) { ?><li class="menu-item" id="reports_supplier_report"><a href="<?= admin_url('reports/suppliers') ?>" class="menu-link"><div><?= lang('suppliers_report') ?></div></a></li><?php } ?>
            <?php if ($GP['reports-staff']) { ?><li class="menu-item" id="reports_staff_report"><a href="<?= admin_url('reports/users') ?>" class="menu-link"><div><?= lang('staff_report') ?></div></a></li><?php } ?>
          </ul>
        </li>
          <?php } ?>
        <?php } // end !Owner && !Admin ?>

      </ul>
    </aside>
    <!-- / Sidebar Menu -->

    <!-- Layout page -->
    <div class="layout-page">

      <!-- Navbar -->
      <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ri ri-menu-fill icon-24px"></i>
          </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

          <!-- Breadcrumb inline -->
          <!--
          <nav aria-label="breadcrumb" class="me-auto">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <?php 
                    // foreach ($bc as $b) {
                    //     if ($b['link'] === '#') {
                    //     echo '<li class="breadcrumb-item active">' . $b['page'] . '</li>';
                    //     } else {
                    //     echo '<li class="breadcrumb-item"><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                    //     }
                    // } 
                ?>
            </ol>
          </nav>
          -->

          <ul class="navbar-nav flex-row align-items-center ms-md-auto">

            <!-- POS -->
            <?php if (POS) { ?>
            <li class="nav-item me-sm-2 me-xl-0">
              <a href="<?= admin_url('pos') ?>" class="nav-link btn btn-icon btn-text-secondary rounded-pill waves-effect" title="<?= lang('pos') ?>">
                <i class="icon-base ri ri-layout-grid-line icon-22px"></i>
              </a>
            </li>
            <?php } ?>

            <!-- Alertes -->
            <?php if (($Owner || $Admin || $GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts']) && ($qty_alert_num > 0 || $exp_alert_num > 0 || $shop_sale_alerts)) { ?>
            <li class="nav-item dropdown me-sm-2 me-xl-0">
              <a class="nav-link btn btn-icon btn-text-secondary rounded-pill waves-effect position-relative" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-base ri ri-error-warning-line icon-22px"></i>
                <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-warning mt-2 border"></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php if ($qty_alert_num > 0) { ?>
                <li><a class="dropdown-item d-flex justify-content-between" href="<?= admin_url('reports/quantity_alerts') ?>"><span><?= lang('quantity_alerts') ?></span><span class="badge bg-danger"><?= $qty_alert_num ?></span></a></li>
                <?php } ?>
                <?php if ($Settings->product_expiry && $exp_alert_num > 0) { ?>
                <li><a class="dropdown-item d-flex justify-content-between" href="<?= admin_url('reports/expiry_alerts') ?>"><span><?= lang('expiry_alerts') ?></span><span class="badge bg-danger"><?= $exp_alert_num ?></span></a></li>
                <?php } ?>
                <?php if ($shop_sale_alerts) { ?>
                <li><a class="dropdown-item d-flex justify-content-between" href="<?= admin_url('sales?shop=yes&delivery=no') ?>"><span><?= lang('sales_x_delivered') ?></span><span class="badge bg-danger"><?= $shop_sale_alerts ?></span></a></li>
                <?php } ?>
                <?php if ($shop_payment_alerts) { ?>
                <li><a class="dropdown-item d-flex justify-content-between" href="<?= admin_url('sales?shop=yes&attachment=yes') ?>"><span><?= lang('manual_payments') ?></span><span class="badge bg-danger"><?= $shop_payment_alerts ?></span></a></li>
                <?php } ?>
              </ul>
            </li>
            <?php } ?>

            <!-- Language -->
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-base ri ri-translate-2 icon-md"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php
                $scanned_lang_dir = array_map(function ($path) { return basename($path); }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                $rtl_langs = ['arabic', 'hebrew', 'urdu', 'persian', 'pashto'];
                foreach ($scanned_lang_dir as $entry) {
                  $is_rtl = in_array($entry, $rtl_langs) ? 'rtl' : 'ltr';
                  $is_active = ($entry === $Settings->user_language) ? ' active' : '';
                ?>
                <li>
                  <a class="dropdown-item waves-effect<?= $is_active ?>" href="<?= admin_url('welcome/language/' . $entry) ?>" data-language="<?= $entry ?>" data-text-direction="<?= $is_rtl ?>">
                    <span><?= ucwords($entry) ?></span>
                  </a>
                </li>
                <?php } ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item waves-effect" href="<?= admin_url('welcome/toggle_rtl') ?>"><i class="ri ri-align-<?= $Settings->user_rtl ? 'right' : 'left' ?> me-2"></i><?= lang('toggle_alignment') ?></a></li>
              </ul>
            </li>
            <!-- /Language -->

            <!-- Style Switcher -->
            <li class="nav-item dropdown me-sm-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill waves-effect" id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown" aria-label="Toggle theme (light)" aria-expanded="false">
                <i class="ri-sun-line icon-base ri icon-22px theme-icon-active"></i>
                <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                <li>
                  <button type="button" class="dropdown-item align-items-center waves-effect active" data-bs-theme-value="light" aria-pressed="true">
                    <span><i class="icon-base ri ri-sun-line icon-22px me-3" data-icon="sun-line"></i>Light</span>
                  </button>
                </li>
                <li>
                  <button type="button" class="dropdown-item align-items-center waves-effect" data-bs-theme-value="dark" aria-pressed="false">
                    <span><i class="icon-base ri ri-moon-clear-line icon-22px me-3" data-icon="moon-clear-line"></i>Dark</span>
                  </button>
                </li>
                <li>
                  <button type="button" class="dropdown-item align-items-center waves-effect" data-bs-theme-value="system" aria-pressed="false">
                    <span><i class="icon-base ri ri-computer-line icon-22px me-3" data-icon="computer-line"></i>System</span>
                  </button>
                </li>
              </ul>
            </li>
            <!-- / Style Switcher-->

            <!-- Quick links -->
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-sm-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill waves-effect" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <i class="icon-base ri ri-star-smile-line icon-22px"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end p-0">
                <div class="dropdown-menu-header border-bottom">
                  <div class="dropdown-header d-flex align-items-center py-3">
                    <h6 class="mb-0 me-auto"><?= lang('shortcuts') ?></h6>
                  </div>
                </div>
                <div class="dropdown-shortcuts-list scrollable-container ps">
                  <div class="row row-bordered overflow-visible g-0">
                    <div class="dropdown-shortcuts-item col">
                      <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base ri ri-calendar-line icon-26px text-heading"></i>
                      </span>
                      <a href="<?= admin_url('calendar') ?>" class="stretched-link"><?= lang('calendar') ?></a>
                      <small><?= lang('upcoming_events') ?></small>
                    </div>
                    <div class="dropdown-shortcuts-item col">
                      <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base ri ri-shopping-cart-2-line icon-26px text-heading"></i>
                      </span>
                      <a href="<?= admin_url('sales') ?>" class="stretched-link"><?= lang('sales') ?></a>
                      <small><?= lang('manage_sales') ?></small>
                    </div>
                  </div>
                  <div class="row row-bordered overflow-visible g-0">
                    <div class="dropdown-shortcuts-item col">
                      <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base ri ri-file-list-3-line icon-26px text-heading"></i>
                      </span>
                      <a href="<?= admin_url('purchases') ?>" class="stretched-link"><?= lang('purchases') ?></a>
                      <small><?= lang('manage_purchases') ?></small>
                    </div>
                    <div class="dropdown-shortcuts-item col">
                      <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base ri ri-store-2-line icon-26px text-heading"></i>
                      </span>
                      <a href="<?= admin_url('products') ?>" class="stretched-link"><?= lang('products') ?></a>
                      <small><?= lang('manage_products') ?></small>
                    </div>
                  </div>
                  <div class="row row-bordered overflow-visible g-0">
                    <div class="dropdown-shortcuts-item col">
                      <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base ri ri-pie-chart-2-line icon-26px text-heading"></i>
                      </span>
                      <a href="<?= admin_url('') ?>" class="stretched-link"><?= lang('dashboard') ?></a>
                      <small><?= lang('home') ?></small>
                    </div>
                    <?php if ($Owner) { ?>
                    <div class="dropdown-shortcuts-item col">
                      <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base ri ri-settings-4-line icon-26px text-heading"></i>
                      </span>
                      <a href="<?= admin_url('system_settings') ?>" class="stretched-link"><?= lang('settings') ?></a>
                      <small><?= lang('system_settings') ?></small>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </li>
            <!-- /Quick links -->

            <!-- Notifications -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
              <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill waves-effect" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <i class="icon-base ri ri-notification-2-line icon-22px"></i>
                <?php if ($info || $events) { ?>
                <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                <?php } ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end py-0">
                <li class="dropdown-menu-header border-bottom py-50">
                  <div class="dropdown-header d-flex align-items-center py-2">
                    <h6 class="mb-0 me-auto"><?= lang('notifications') ?></h6>
                    <?php $notif_count = ($info ? count($info) : 0) + ($events ? count($events) : 0); if ($notif_count > 0) { ?>
                    <div class="d-flex align-items-center h6 mb-0">
                      <span class="badge rounded-pill bg-label-primary fs-xsmall me-2"><?= $notif_count ?> <?= lang('new') ?></span>
                    </div>
                    <?php } ?>
                  </div>
                </li>
                <li class="dropdown-notifications-list scrollable-container ps">
                  <ul class="list-group list-group-flush">
                    <?php if ($info) { foreach ($info as $n) { ?>
                    <li class="list-group-item list-group-item-action dropdown-notifications-item waves-effect waves-light">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar">
                            <span class="avatar-initial rounded-circle bg-label-primary"><i class="icon-base ri ri-information-line icon-18px"></i></span>
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="small mb-1"><?= $n->comment ?></h6>
                        </div>
                        <div class="flex-shrink-0 dropdown-notifications-actions">
                          <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base ri ri-close-line"></span></a>
                        </div>
                      </div>
                    </li>
                    <?php }} ?>
                    <?php if ($events) { foreach ($events as $event) { ?>
                    <li class="list-group-item list-group-item-action dropdown-notifications-item waves-effect waves-light">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar">
                            <span class="avatar-initial rounded-circle bg-label-warning"><i class="icon-base ri ri-calendar-event-line icon-18px"></i></span>
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="small mb-1"><?= $event->title ?></h6>
                          <small class="text-body-secondary"><?= date($dateFormats['php_ldate'], strtotime($event->start)) ?></small>
                        </div>
                      </div>
                    </li>
                    <?php }} ?>
                    <?php if (!$info && !$events) { ?>
                    <li class="list-group-item text-center py-4 text-muted">
                      <i class="ri ri-notification-off-line icon-26px d-block mb-2"></i>
                      <?= lang('no_records') ?>
                    </li>
                    <?php } ?>
                  </ul>
                </li>
                <li class="border-top">
                  <div class="d-grid p-4">
                    <a class="btn btn-primary btn-sm d-flex waves-effect waves-light" href="<?= admin_url('calendar') ?>">
                      <small class="align-middle"><?= lang('calendar') ?></small>
                    </a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- /Notifications -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                  <img src="<?= $this->session->userdata('avatar') ? base_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : base_url('assets/images/' . $this->session->userdata('gender') . '.png') ?>" alt="Avatar" class="rounded-circle">
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                <li>
                  <a class="dropdown-item waves-effect" href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')) ?>">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0 me-2">
                        <div class="avatar avatar-online">
                          <img src="<?= $this->session->userdata('avatar') ? base_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : base_url('assets/images/' . $this->session->userdata('gender') . '.png') ?>" alt="Avatar" class="w-px-40 h-auto rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0 small"><?= $this->session->userdata('username') ?></h6>
                        <small class="text-body-secondary"><?= $Owner ? lang('owner') : ($Admin ? lang('administrator') : lang('staff')) ?></small>
                      </div>
                    </div>
                  </a>
                </li>
                <li><div class="dropdown-divider"></div></li>
                <li>
                  <a class="dropdown-item waves-effect" href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')) ?>">
                    <i class="icon-base ri ri-user-3-line icon-22px me-3"></i><span class="align-middle"><?= lang('profile') ?></span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item waves-effect" href="<?= admin_url('users/profile/' . $this->session->userdata('user_id') . '/#cpassword') ?>">
                    <i class="icon-base ri ri-lock-line icon-22px me-3"></i><span class="align-middle"><?= lang('change_password') ?></span>
                  </a>
                </li>
                <?php if ($Owner) { ?>
                <li>
                  <a class="dropdown-item waves-effect" href="<?= admin_url('system_settings') ?>">
                    <i class="icon-base ri ri-settings-4-line icon-22px me-3"></i><span class="align-middle"><?= lang('settings') ?></span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item waves-effect" href="<?= admin_url('reports/profit') ?>" data-bs-toggle="modal" data-bs-target="#myModal">
                    <i class="icon-base ri ri-money-dollar-circle-line icon-22px me-3"></i><span class="align-middle"><?= lang('today_profit') ?></span>
                  </a>
                </li>
                <?php } ?>
                <li><div class="dropdown-divider"></div></li>
                <li>
                  <div class="d-grid px-4 pt-2 pb-1">
                    <a class="btn btn-sm btn-danger d-flex waves-effect waves-light" href="<?= admin_url('logout') ?>">
                      <small class="align-middle"><?= lang('logout') ?></small>
                      <i class="icon-base ri ri-logout-box-r-line ms-2 icon-16px"></i>
                    </a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- /User -->

          </ul>
        </div>
      </nav>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

          <!-- Alerts -->
          <?php if ($message) { ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php } ?>
          <?php if ($error) { ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php } ?>
          <?php if ($warning) { ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $warning ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php } ?>
          <?php if ($info) {
            foreach ($info as $n) {
              if (!$this->session->userdata('hidden' . $n->id)) { ?>
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <a href="#" id="<?= $n->id ?>" class="btn-close hideComment external" data-bs-dismiss="alert"></a>
            <?= $n->comment ?>
          </div>
          <?php }} } ?>
          <div class="alerts-con"></div>