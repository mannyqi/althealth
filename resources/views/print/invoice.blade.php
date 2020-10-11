<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        table.invoice-items thead tr th {
            font-weight: bold;
            background-color:#f4f4f6;
            padding: 5px 0 5px 0;
            font-size:13px;
            line-height:20px;
            color:#4d4d4f;
            text-align: left;
        }
        table.invoice-items tbody tr td {
            text-align: left;
        }
        .invoice-number, .invoice-date {
            font-size: 16px;
            padding: 15px 0;
        }
        .subtotal {
            font-size: 16px;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
        }
        .text-right {
            text-align: right !important;
            padding-right: 20px;
        }
        .logo {
            text-align: center;
            padding: 20px 0;
            background-color: #ededed;
        }
        .pb10 {
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
if (count($invoice) > 0) {
    $invoice_data = $invoice[0];
    ?>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td align="center" valign="top">
                    <table class="invoice-header" width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td colspan="3" class="logo" align="center"><img src="http://www.wushu.co.za/dev/logo.png" alt="AltHealth" style="max-width: 150px;"></td>
                            </tr>
                            <tr>
                                <td class="invoice-number" valign="top"><strong>Invoice Number:</strong> {{$invoice_data->Inv_Num}}</td>
                                <td class="invoice-date">
                                    <strong>Date:</strong> {{$invoice_data->Inv_Date}}
                                    @if($invoice_data->Inv_Paid == 'Y')
                                        <br>
                                        <strong>Date Received:</strong> {{$invoice_data->Inv_Paid_Date}}
                                    @else
                                        <strong>[ Unpaid ]</strong>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="invoice-header" width="100%" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td width="50%" valign="top"><h3>FROM:</h3></td>
                                <td align="left">
                                    <h4>{{config('app.name', 'AltHealth')}}</h4>
                                    <?php $address = config('custom.physical_address'); ?>
                                    {{$address['address']}}, {{$address['city']}}, {{$address['country']}}, {{$address['zip']}}
                                    <br />
                                    <strong>Email:</strong> {{config('custom.admin_email')}}<br />
                                    <strong>Phone:</strong> {{config('custom.admin_tel')}}
                                </td>
                            </tr>
                            <tr>
                                <td valign="top"><h3>TO:</h3></td>
                                <td align="left">
                                    <h4>{{$invoice_data->C_name}} {{$invoice_data->C_surname}}</h4>
                                    <strong>Address:</strong> {{$invoice_data->Address}}, {{$invoice_data->Code}}<br />
                                    <strong>Email:</strong> {{$invoice_data->C_Email}}<br />
                                    <strong>Phone:</strong> {{$invoice_data->C_Tel_W}}
                                </td>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                        </tbody>
                    </table>

                    <table class="invoice-items" width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Unit Price Excl.</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subtotal = 0;
                            $tax_rate = 15;
                            ?>
                            @foreach($invoice as $item)
                                <?php
                                $subtotal += ($item->Item_Price * $item->Item_Quantity);
                                ?>
                                <tr>
                                    <td>{{$item->Supplement_Description}} ({{$item->Supplement_id}})</td>
                                    <td>{{$item->Item_Quantity}}</td>
                                    <td>R {{number_format($item->Item_Price, 2, '.', ' ')}}</td>
                                    <td>R {{number_format($item->Item_Price * $item->Item_Quantity, 2, '.', ' ')}}</td>
                                </tr>
                            @endforeach
                            <tr><td colspan="4"><hr /></td></tr>
                            <tr>
                                <td colspan="3" class="subtotal text-right pb10">Subtotal:</td>
                                <td class="subtotal pb10">R {{number_format($subtotal, 2, '.', ' ')}}</td>
                            </tr>
                            <tr>
                                <?php $tax = ($subtotal * ($tax_rate/100 + 1)) - $subtotal; ?>
                                <td colspan="3" class="subtotal text-right pb10">VAT (15%):</td>
                                <td class="subtotal pb10">R {{number_format($tax, 2, '.', ' ')}}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="total text-right">Total Due (Incl.):</td>
                                <td class="total">R {{number_format($subtotal * ($tax_rate/100 + 1), 2, '.', ' ')}}</td>
                            </tr>
                        </tbody>
                        @if($invoice_data->Comments)
                        <tfoot>
                            <tr><td colspan="4" style="height: 50px;">&nbsp;</td></tr>
                            <tr>
                                <td colspan="4" style="padding: 20px; min-height: 100px; background: #ededed">
                                    <h3 style="margin-bottom: 5px;">Comments:</h3>
                                    {{$invoice_data->Comments}}
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        window.print();
    </script>
<?php } else { ?>
    <h2 style="text-align: center">Invoice not found</h2>
<?php } ?>

</body>
</html>
