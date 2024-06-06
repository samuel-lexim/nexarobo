<?php
/**
 * The template for displaying PDF Invoice
 * Override by copying it to yourtheme/memberpress/account/invoice/modern.php.
 */

// $color = isset($invoice->color) && !empty($invoice->color) ? $invoice->color : '#252525';
$color = '#252525';
?>
<!DOCTYPE html>
<head xmlns="http://www.w3.org/1999/html">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style lang="text/css">
        @page {
            margin: 0
        }

        body {
            position: relative;
            margin: 0 auto;
            padding: 37px 22px 0;
            color: #252525;
            background: #fff;
            font-family: "Proxima Nova", sans-serif !important;
            font-size: 14px;
            line-height: 16px;
            font-weight: 400;
            letter-spacing: 0.01em;
            width: 100%;
        }

        .clearfix {
            clear: both;
        }

        a {
            color: #37a7f4;
            text-decoration: underline
        }

        h2, h3, h4, h5 {
            margin: 0 0 5px;
        }

        p {
            line-height: 16px;
            margin: 0 0 10px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding-top: 0;
            padding-left: 22px;
            padding-right: 22px;
        }

        header {
            margin-bottom: 40px;
        }

        header ._container {
            width: 100%;
            padding-top: 37px;
            padding-left: 22px;
            padding-right: 22px;
            margin-bottom: 0;
        }

        #LeftHeading {
            float: left;
            max-width: 49%;
        }

        #LeftHeading p {
            font-weight: bold;
        }

        #logo {
            float: right;
            width: 150px;
            max-width: 49%;
            margin-top: -90px;
        }

        header p._date {
            font-weight: bold;
        }

        header ._title {
            font-size: 24px;
            font-weight: 700;
            line-height: 26px;
            letter-spacing: 0.01em;
            text-align: left;
            color: #000;
            margin: 0 0 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        table#AddressTable ._heading {
            font-size: 14px !important;
            font-weight: bold !important;
            line-height: 18px;
            letter-spacing: 0.01em;
            text-align: left;
            color: #000000 !important;
            margin-bottom: 10px;
        }

        table#content {
            margin-top: 50px;
        }

        table#content th {
            padding-bottom: 15px;
            border-bottom: 1px solid #252525;
        }

        table#content td {
            vertical-align: top;
            padding: 20px 6px;
            border-bottom: 1px solid #dddddd;
        }

        table#content th.col1, table#content td.col1 {
            text-align: left;
        }

        table#content th.col2, table#content td.col2 {
            text-align: center;
        }

        table#content th.col3, table#content td.col3 {
            text-align: right;
        }

        table#Total {
            display: table;
            max-width: 276px;
            width: 280px;
            border-collapse: collapse;
            border-spacing: 0;
            margin-left: auto;
            margin-right: 0;
        }

        table#Total td.__line {
            border-bottom: 1px solid #dddddd;
        }

        table#Total td {
            padding: 15px 0;
            font-size: 14px;
            line-height: 16px;
            font-weight: bold;
        }

        table#Total td.col2 {
            text-align: right;
        }

        footer {
            position: absolute;
            width: 94%;
            top: auto;
            bottom: 0;
            left: 22px;
            right: 0;
            padding: 12px 0 30px;
            border-top: 1px solid #dddddd;
        }

        footer p {
            font-size: 12px;
            font-weight: 400;
            line-height: 16px;
            letter-spacing: 0.01em;
            text-align: left;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>

<?php
$invoiceNumber = 0;
$amount = '';
$paidAtDate = '';
if (isset($invoice) && !(absint($invoice->credit_number) > 0)) {
    $desiredLength = 6;
    $invoiceNumber = str_pad($invoice->invoice_number, $desiredLength, "0", STR_PAD_LEFT);
    $paidAtDate = date_i18n(get_option('date_format'), $invoice->paid_at);
}
?>

<header class="clearfix">
    <div class="_container">
        <div id="LeftHeading">
            <?php if (isset($txn->order_id) && $txn->order_id > 0) : ?>
                <?php printf('<p><span class="_numberLabel">%s</span> %s</p>', 'Order NO', strtoupper($txn->order_id)); ?>
            <?php endif; ?>
            <?php if (absint($invoice->credit_number) > 0) : ?>
                <?php printf('<p><span class="_numberLabel">%s</span> %s</p>', 'CREDIT NOTE NO', strtoupper($invoice->credit_number)); ?>
                <?php printf('<p><span class="_numberLabel">%s</span> %s</p>', 'ORIG. Invoice NO', $invoiceNumber); ?>
            <?php else: ?>
                <h2 class="_title">Invoice</h2>
                <?php printf('<p><span class="_numberLabel">%s</span> %s</p>', 'Invoice number', $invoiceNumber); ?>
            <?php endif; ?>
            <p class="_date"><?= $paidAtDate ?></p>
        </div>

        <div id="logo">
            <?php if (is_numeric($invoice->logo)) { ?>
                <img src="<?php echo get_attached_file($invoice->logo); ?>" alt="Nexarobo">
            <?php } ?>
        </div>
    </div>
    <div class="clearfix"></div>
</header>

<main>
    <div class="container">
        <table id="AddressTable">
            <tbody>
            <tr>
                <td>
                    <div class="_heading"><strong>Nexarobo</strong></div>
                    <?php echo wpautop($invoice->company); ?>
                </td>
                <td>
                    <div class="_heading"><strong>Bill to</strong></div>
                    <?php echo wpautop($invoice->bill_to); ?>
                </td>
            </tr>
            </tbody>
        </table>

        <table id="content">
            <thead>
            <tr>
                <th class="col1"><strong>Description</strong></th>
                <th class="col2"><strong>Payment</strong></th>
                <th class="col3"><strong>Amount</strong></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($invoice->items as $item) {
                $item['quantity'] = 1;
                $sub = null;
                $product = null;
                $period_type = '';
                if (isset($txn)) {
                    $sub = $txn->subscription();
                    $product = new MeprProduct($txn->product_id);
                    $period_type = $product->period_type;
                }
                $period_type = $period_type === 'months' ? 'Month' : $period_type;
                ?>
                <tr>
                    <td class="col1">
                        <p><strong><?php echo $item['description']; ?></strong></p>
                        <p><?php echo MeprAppHelper::format_date($sub->created_at); ?></p>
                        <div class="mepr__rebill">
                            <?php if ($txn != false && $txn instanceof MeprTransaction && !$txn->is_sub_account && ($nba = $sub->next_billing_at)) : ?>
                                <?php printf(_x('Next Billing: %s', 'ui', 'memberpress'), MeprAppHelper::format_date($nba)); ?>
                            <?php elseif (!$sub->next_billing_at && ($nba = $sub->expires_at) && stripos($sub->expires_at, '0000-00') === false) : ?>
                                <?php
                                if (strtotime($nba) < time()) {
                                    printf(_x('Expired: %s', 'ui', 'memberpress'), MeprAppHelper::format_date($nba));
                                } else {
                                    printf(_x('Expires: %s', 'ui', 'memberpress'), MeprAppHelper::format_date($nba));
                                }
                                ?>
                            <?php elseif (false === $txn && ($nba = $sub->created_at)) : ?>
                                <?php printf(_x('Expired: %s', 'ui', 'memberpress'), MeprAppHelper::format_date($nba)); ?>
                            <?php endif; ?>
                        </div>
                    </td>

                    <?php /* if ($invoice->show_quantity) : ?>
                        <td class="unit"><?php echo MePdfInvoicesCtrl::format_real_number($item['quantity']); ?></td>;
                    <?php endif; */ ?>

                    <td class="col2">****-****-****-<?= $sub ? $sub->cc_last4 : "xxxx" ?></td>

                    <?php $amount = MeprAppHelper::format_currency($item['amount'], true, false); ?>
                    <td class="col3 mp-currency-cell"><?= $amount . " / " . $period_type ?></td>
                </tr>
                <?php
            }
            ?>

            <?php
            /*
            if (isset($invoice->coupon) && !empty($invoice->coupon) && $invoice->coupon['id'] != 0) : ?>
                <tr>
                    <td><?php echo $invoice->coupon['desc']; ?></td>
                    <?php if ($invoice->show_quantity) : ?>
                        <td>&nbsp;</td>
                    <?php endif; ?>
                    <td class="mp-currency-cell">
                        <?php if ($invoice->coupon['amount'] !== '0') : ?>
                            -<?php echo MeprAppHelper::format_currency($invoice->coupon['amount'], true, false); ?>
                        <?php else : ?>                            &nbsp;
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif;
            */ ?>

            <?php /* if (is_array($invoice->tax_items) && count($invoice->tax_items)): ?>
                <tr>
                    <td><?php esc_html_e('SUBTOTAL', 'memberpress-pdf-invoice'); ?></td>
                    <?php if ($invoice->show_quantity) : ?>
                        <td>&nbsp;</td>
                    <?php endif; ?>
                    <td class="total"><?php echo MeprAppHelper::format_currency($invoice->subtotal, true, false); ?></td>
                </tr>
                <?php foreach ($invoice->tax_items as $tax_item): ?>
                    <?php if ($tax_item['amount'] > 0 || $tax_item['percent'] > 0) : ?>
                        <tr>
                            <?php if ($invoice->show_quantity): ?>
                                <td>&nbsp;</td>
                            <?php endif; ?>
                            <td class="mepr-tax-invoice"><?php echo MeprUtils::format_tax_percent_for_display($tax_item['percent']) . '% ' . $tax_item['type']; ?> <?php if (count($invoice->tax_items) > 1 && isset($tax_item['post_title']) && !empty($tax_item['post_title'])): ?>
                                    <br/><small><?php echo esc_html($tax_item['post_title']); ?></small><?php endif; ?>
                            </td>
                            <td class="mp-currency-cell"><?php echo MeprAppHelper::format_currency($tax_item['amount'], true, false); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; */ ?>

            </tbody>
        </table>

        <table id="Total">
            <tbody>
            <tr class="tr1">
                <td class="col1 __line"><strong>Total</strong></td>
                <td class="col2 __line"><?= $amount ?></td>
            </tr>
            <tr>
                <td class="col1"><strong>Amount Paid</strong></td>
                <td class="col2"><?= MeprAppHelper::format_currency($invoice->total, true, false) . " USD" ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <?php /*
    <tr>
        <td class="grand"><?php esc_html_e('GRAND TOTAL', 'memberpress-pdf-invoice'); ?></td>
        <?php if ($invoice->show_quantity) : ?>
            <td class="grand">&nbsp;</td>
        <?php endif; ?>
        <td class="grand total"><?php echo MeprAppHelper::format_currency($invoice->total, true, false); ?></td>
    </tr>
    */ ?>

</main>

<footer>
    <?php //echo wpautop($invoice->footnotes); ?>
    <p><?= $invoiceNumber . ' ' . $amount . ' USD due ' . $paidAtDate ?></p>
</footer>
</body>

</html>
