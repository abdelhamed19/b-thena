<x-admin-layout title='Orders'>
    @section('content')
        <div class="card">
            <x-flash-message />

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>رقم الأوردر</th>
                            <th>تاريخ الإنشاء</th>
                            <th>تاريخ لحذف</th>
                            <th>إسم العميل</th>
                            <th>السعر الكامل</th>
                            <th>النوع</th>
                            <th>تم الحذف بواسطة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable">
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                                <td>{{ $order->deleted_at->format('Y-m-d h:i A') }}</td>
                                <td>{{ $order->customer->name}}</td>
                                <td>{{ $order->total_price }}</td>
                                <td>{{ $order->type }}</td>
                                <td>{{ $order->deletedBy->name }}</td>
                                <td>
                                    <a href="{{ route('orders.showTrashed', $order->id) }}" class="btn btn-info">التفاصيل</a>
                                    <button type="button" class="btn btn-danger delete-order-btn" data-id="{{ $order->id }}">حذف نهائي</button>
                                    <button type="button" class="btn btn-primary restore-order-btn" data-id="{{ $order->id }}">إستعاده</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">لا توجد أوردرات الان</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    @endsection
</x-admin-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.restore-order-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-id');
                const url = `{{ route('orders.restore', ':id') }}`.replace(':id', orderId);

                Swal.fire({
                    title: 'هل أنت متأكد من إستعادة العنصر؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم',
                    cancelButtonText: 'لا'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire(
                                    'تم الإستعاده',
                                    'تم الإستعاده بنجاح',
                                    'success'
                                ).then(() => location.reload()); // Reload the page
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'An unexpected error occurred.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-order-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-id');
                const url = `{{ route('orders.forceDelete', ':id') }}`.replace(':id', orderId);

                Swal.fire({
                    title: 'هل أنت متأكد من حذف العنصر نهائيا؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم',
                    cancelButtonText: 'لا'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire(
                                    'تم الحذف',
                                    'تم الحذف بنجاح',
                                    'success'
                                ).then(() => location.reload()); // Reload the page
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'An unexpected error occurred.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>
