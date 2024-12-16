<x-admin-layout title='تفاصيل الطلب'>
    @section('content')
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>تاريخ الإنشاء</th>
                            <th>نوع الطلب</th>
                            <th>الملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                            <td>{{ $order->type }}</td>
                            <td colspan="3">{{ $order->notes }}</td>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-center">عناصر الطلب</th>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>اسم العنصر</th>
                                            <th>الكمية</th>
                                            <th>السعر</th>
                                            <th>الإجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($order->items as $orderItem)
                                        <tr>
                                            <td>{{ $orderItem->menu->item_name }}</td>
                                            <td>{{ $orderItem->quantity }}</td>
                                            <td>{{ $orderItem->price }}</td>
                                            <td>{{ $orderItem->total }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">لم يتم العثور على عناصر</td>
                                        </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="4" class="text-center"><b>إجمالي السعر: {{ $order->total_price }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @if($order->type == 'delivery')
                        <tr>
                            <th colspan="6" class="text-center">معلومات العميل</th>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>الاسم</th>
                                            <th>رقم الهاتف</th>
                                            <th>العنوان</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->customer->phone }}</td>
                                            <td>{{ $address->address ?? 'لا يوجد عنوان' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-admin-layout>
