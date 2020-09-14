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
            text-align: right;
        }
        .logo {
            text-align: center;
            padding: 20px 0;
            background-color: #ededed;
        }
    </style>
</head>
<body>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td align="center" valign="top">
                <table class="invoice-header" width="600" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td colspan="2" class="logo" align="center"><img src="http://www.wushu.co.za/dev/logo.png" alt="AltHealth"></td>
                        </tr>
                        <tr>
                            <td class="invoice-number"><strong>Invoice Number:</strong> {{$data['invoice']['invoice_id']}}</td>
                            <td class="invoice-date"><strong>Date:</strong> {{date('d-m-Y')}}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="invoice-header" width="600" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td width="50%" valign="top"><h3>FROM:</h3></td>
                            <td align="left">
                                <h4>{{config('app.name', 'AltHealth')}}</h4>
                                <strong>Address:</strong> 22 Captain street, Cape Town, 8001<br />
                                <strong>Email:</strong> accounts@althealth.co.za<br />
                                <strong>Phone:</strong> 021 123 4567
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><h3>TO:</h3></td>
                            <td align="left">
                                <h4>{{$data['invoice']['client']->C_name}} {{$data['invoice']['client']->C_surname}}</h4>
                                <strong>Address:</strong> {{$data['invoice']['client']->Address}}, {{$data['invoice']['client']->Code}}<br />
                                <strong>Email:</strong> {{$data['invoice']['client']->C_Email}}<br />
                                <strong>Phone:</strong> {{$data['invoice']['client']->C_Tel_W}}
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                    </tbody>
                </table>

                <table class="invoice-items" width="600" cellpadding="0" cellspacing="0">
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
                        @foreach($data['invoice']['items'] as $item)
                            <?php
                            $subtotal += ($item->cost_excl * $item->qty);
                            ?>
                            <tr>
                                <td>({{$item->supplement_id}})</td>
                                <td>{{$item->qty}}</td>
                                <td>R {{number_format($item->cost_excl, 2, '.', ' ')}}</td>
                                <td>R {{number_format($item->cost_excl * $item->qty, 2, '.', ' ')}}</td>
                            </tr>
                        @endforeach
                        <tr><td colspan="4"><hr /></td></tr>
                        <tr>
                            <td colspan="3" class="subtotal text-right">Subtotal:</td>
                            <td class="subtotal">R {{number_format($subtotal, 2, '.', ' ')}}</td>
                        </tr>
                        <tr>
                            <?php $tax = ($subtotal * ($tax_rate/100 + 1)) - $subtotal; ?>
                            <td colspan="3" class="subtotal text-right">VAT (15%):</td>
                            <td class="subtotal">R {{number_format($tax, 2, '.', ' ')}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="total text-right">Total Due (Incl.):</td>
                            <td class="total">R {{number_format($subtotal * ($tax_rate/100 + 1), 2, '.', ' ')}}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>
