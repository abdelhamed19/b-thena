<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة الطلب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            color: #000000;
            direction: rtl;
            text-align: right;
        }

        .card {
            border: 1px solid #000;
        }

        .card-header {
            background-color: #eaeaea;
            color: #000;
        }

        .card-header h3 {
            margin-bottom: 0;
            font-size: 1.5rem;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #000;
        }

        .table thead {
            background-color: #eaeaea;
            color: #000;
        }

        .card-footer {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        /* Print Styles */
        @media print {
            body {
                color-adjust: exact;
                font-size: 12px;
            }

            .card {
                border: none;
                box-shadow: none;
            }

            .btn {
                display: none; /* Hide buttons during printing */
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3>فاتورة الطلب</h3>
                <p>رقم الطلب: <strong>{{ $order->order_number }}</strong></p>
                <p>تاريخ الطلب: <strong>{{ $order->created_at->format('d-m-Y H:i') }}</strong></p>
                <p>نوع الطلب: <strong>{{ $order->type == 'delivery' ? 'توصيل' : 'استلام' }}</strong></p>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>إجمالي السعر: <strong>{{ number_format($order->total_price, 2) }} جنيه</strong></h5>
                </div>

                <!-- Delivery Details -->
                @if($order->type == 'delivery')
                <div class="mb-4">
                    <h6>معلومات العميل:</h6>
                    <p>الاسم: {{ $order->customer->name }}</p>
                    <p>عنوان التوصيل: {{ $order->customer->addresses->address }}</p>
                    <p>رقم الهاتف: {{ $order->customer->phone }}</p>
                </div>
                @endif

                <!-- Items Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>إسم المنتج</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->menu->item_name }}</td>
                                <td>{{ number_format($item->price, 2) }} جنيه</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total, 2) }} جنيه</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Notes Section -->
                @if($order->notes)
                <div class="mt-4">
                    <h6>ملاحظات:</h6>
                    <p>{{ $order->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="card-footer text-center">
                <h4>بـ طـحـيـنـه</h4>
                <p>شكراً لتعاملكم معنا!</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print(); // Automatically trigger print dialog
        };
    </script>
</body>
</html>
