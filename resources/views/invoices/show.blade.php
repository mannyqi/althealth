@extends('layouts.app')

@section('content')

    <a href="/invoices" class="btn btn-secondary"><< Back</a>

    <div class="invoice-preview">
        <?php
        $cnt = 1;
        $total = 0;
        $tax = 0;
        $tax_rate = 0.15;
        ?>
        @foreach($invoice as $inv)
            <?php
            $total += ($inv->Item_Price * $inv->Item_Quantity);
            ?>

            @if($cnt == 1)
            <div class="row">
                <div class="col-6">
                    <img src="{{asset('images/logo.png')}}" style="max-width: 100px" class="img-fluid logo" alt="{{config('app.name', 'AltHealth')}}" />
                </div>
                <div class="col-6 text-right">
                    <h1>INVOICE</h1>
                    <p>
                        <strong>Invoice #:</strong> {{$inv->Inv_Num}}<br />
                        <strong>Date:</strong> {{$inv->Inv_Date}}<br />
                        <strong>Due Date:</strong>
                        @if($inv->Inv_Paid == 'N')
                            Within 30 Days
                        @else
                            {{$inv->Inv_Paid_Date}}
                        @endif
                    </p>
                    @if($inv->Inv_Paid == 'Y')
                        <h5 class="text-success"><i>[ PAID ]</i></h5>
                    @else
                        <h5 class="text-danger"><i>[ UNPAID ]</i></h5>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h2>FROM</h2>
                    <h4>{{config('app.name', 'AltHealth')}}</h4>
                    <p>
                        <strong>Address:</strong> 22 Captain street, Cape Town, 8001<br />
                        <strong>Email:</strong> accounts@althealth.co.za<br />
                        <strong>Phone:</strong> 021 123 4567
                    </p>
                </div>
                <div class="col-6">
                    <h2>TO</h2>
                    <h4>{{$inv->C_name}} {{$inv->C_surname}}</h4>
                    <p>
                        <strong>Address:</strong> {{$inv->Address}}, {{$inv->Code}}<br />
                        <strong>Email:</strong> {{$inv->C_Email}}<br />
                        <strong>Phone:</strong> {{$inv->C_Tel_W}}
                    </p>
                </div>
            </div>
            <hr />
            <!-- ITEMS -->
            <table class="table table-light">
                <thead>
                    <tr>
                        <th>Supplement ID</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price (Excl.)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
            @endif

                    <tr>
                        <td>{{$inv->Supplement_id}}</td>
                        <td>{{$inv->Supplement_Description}}</td>
                        <td>{{$inv->Item_Quantity}}</td>
                        <td>R {{number_format($inv->Item_Price, 2, '.', ' ')}}</td>
                        <td>R {{number_format($inv->Item_Price * $inv->Item_Quantity, 2, '.', ' ')}}</td>
                    </tr>

            @if($cnt == count($invoice))
                </tbody>
            @endif

            <?php $cnt++; ?>
        @endforeach
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><h5>Subtotal:</h5></td>
                        <td><strong>R {{number_format($total, 2, '.', ' ')}}</strong></td>
                    </tr>
                    <tr>
                        <?php $tax = ($total * (1 + $tax_rate)) - $total; ?>
                        <td colspan="4" class="text-right"><h5>VAT (15%):</h5></td>
                        <td><strong>R {{number_format($tax, 2, '.', ' ')}}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right text-info"><h4>Total Due (Incl.):</h4></td>
                        <td><strong class="text-info">R {{number_format($total * (1 + $tax_rate), 2, '.', ' ')}}</strong></td>
                    </tr>
                </tfoot>
            </table>
    </div>

@endsection
