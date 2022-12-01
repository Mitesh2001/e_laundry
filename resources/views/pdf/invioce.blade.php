<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .bg-gray {
            background: gray;
            color: #fff;
        }

        body {
            width: 100%;
            height: 100%;
            padding: 25px !important;
            margin: 0;
            position: relative;
            font-family: "HelveticaNeue-CondensedBold", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            font-size: 12px;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #999;
            padding: 0.5rem;
            text-align: left;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }

        footer {
            position: absolute;
            top: 20%;
            left: 10px;
            transform: rotate(90deg);
            transform-origin: 3% 0% 0;
            width: 100%;
            height: 40px;
        }

        h4 {
            margin: 5px 0
        }

        .header {
            overflow: hidden;
            padding: 10px;
        }

        .header img {
            width: 16em;
            float: left;
        }

        .header div h1 {
            font-size: 2em;
            margin: 11px 0;
            text-align: right;
        }

        .float-left {
            float: left;
        }

        .address_line {
            background: #ddd;
            border-bottom: 2px solid gray;
            height: 80px;
        }

        .w-60 {
            width: 60%
        }

        .w-15 {
            width: 15%
        }

        .w-25 {
            width: 25%
        }

        .footer {
            position: absolute;
            bottom: 0;
        }

        .address {}

        .contact {
            position: absolute;
            right: 0;
            top: 0
        }

    </style>
    <title>#{{ $order->prefix . $order->order_code }} - invioce</title>
</head>

<body>

    <div class=" header">
        <img src="{{ asset('web/logos/Logo.svg') }}" alt="">
        <div>
            <h1>RECEIPT</h1>
        </div>
    </div>

    <div class="address_line">
        <div class="w-60 float-left">
            <h4>Street Address: Moti MahalFlat #C2 House #2023</h4>
            <h4>City, ST ZIP Code: 1229</h4>
            <h4>Phone | Fax: +880 1706 0407 42</h4>
        </div>
        <div class="w-15 float-left">
            <h4>DATE:</h4>
            <h4>RECEIPT #</h4>
            <h4>FOR:</h4>
        </div>
        <div class="w-25 float-left">
            <h4>{{ Carbon\Carbon::parse($order->delivery_at)->format('F d, Y') }}</h4>
            <h4>{{ $order->prefix . $order->order_code }}</h4>
            <h4>Details</h4>
        </div>
    </div>

    <div style="padding: 10px 0">
        <h4>BILL TO: {{ $order->customer->user->name }}</h4>
        <h4>Address Name: {{ $order->address->address_name }}</h4>
        <h4>Area: {{ $order->address->area }}</h4>
        <h4>House Number: {{ $order->address->house_no }}</h4>
        <h4>Flat Number: {{ $order->address->flat_no }}</h4>
        <h4>Road Number: {{ $order->address->road_no }}</h4>
        <h4>Block: {{ $order->address->block }}</h4>
        <h4>Phone: {{ $order->customer->user->mobile }}</h4>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr class="bg-gray">
                <th>PRODUCT NAME</th>
                <th>QUANTITY</th>
                <th>RATE</th>
                <th>ATAMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $serviceTotal = 0;
            @endphp
            @foreach ($order->products as $product)
                @php
                    $total += $product->pivot->quantity * $product->price;
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td style="text-align: right">{{ $product->pivot->quantity }}</td>
                    <td style="text-align: right">{{ $product->price }}</td>
                    <td style="background: #ddd; text-align: right">
                        {{ $product->pivot->quantity * $product->price }}
                    </td>
                </tr>
            @endforeach
            @if ($order->additionals->count())
                <tr class="bg-gray">
                    <th>Title</th>
                    <th colspan="2">Description</th>
                    <th>ATAMOUNT</th>
                </tr>
                @foreach ($order->additionals as $additional)
                    @php
                        $serviceTotal += $additional->price;
                    @endphp
                    <tr>
                        <td>{{ $additional->title }}</td>
                        <td colspan="2">{{ $additional->description }}</td>
                        <td style="text-align: right">{{ $additional->price }}</td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td colspan="3" style="text-align: right;border: 0;">
                    <strong>SUBTOTAL</strong>
                </td>
                <td class="bg-gray" style="text-align: right">
                    <strong>{{ $total + $serviceTotal }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;border: 0;">
                    <strong>DISCOUNT</strong>
                </td>
                <td style="text-align: right">
                    {{ $order->coupon ? $order->coupon->discount : '0.00' }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;border: 0;">
                    <strong>DELIVERY COST</strong>
                </td>
                <td class="bg-gray" style="text-align: right">{{ $total + $serviceTotal >= 100 ? '0.00' : 29 }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;border: 0;">
                    <strong>TOTAL</strong>
                </td>
                <td style="text-align: right">
                    <strong>
                        @if ($order->coupon && $total + $serviceTotal >= 100)
                            {{ $total + $serviceTotal - $order->coupon->discount }}
                        @elseif($total + $serviceTotal >= 100)
                            {{ $total + $serviceTotal }}
                        @else
                            {{ $total + $serviceTotal + 29 }}
                        @endif
                    </strong>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="address">
            Address: <strong>63/3 Lake Circus (4th & 5th Floor), Dolphin Goli Kalabagan</strong> <br>
            Area: <strong>Kalabagan</strong> <br>
            Country: <strong>Bangladesh</strong> <br>
            Division: <strong>Dhaka</strong> <br>
        </div>
        <div class="contact">
            Mobile: <strong>+880 1711 1111 1111</strong> <br>
            Email: <strong>razinsoftbd@gmail.com</strong>
        </div>
        <h3 style="text-align: center;color:rgb(128, 128, 128)">THANK YOU</h3>
    </div>
</body>

</html>
