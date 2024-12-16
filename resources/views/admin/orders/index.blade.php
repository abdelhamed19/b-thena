<x-admin-layout title='Orders'>
    @section('content')
        <div class="card">
            <x-flash-message />
            <div class="card-header">
                <a href="{{ route('orders.create') }}" class="btn btn-primary">إضافة اوردر</a>
                <button class="btn btn-secondary" id="exportExcel" type="button">تحميل الأوردرات في صيغة إكسيل</button>
            </div>
            <br>
            <div class="row align-items-center mb-3">
                <div class="col-md-3 ml-3">
                    <input type="text" id="searchCustomer" class="form-control" placeholder="البحث بإستخدام إسم العميل">
                </div>
                <div class="col-md-3">
                    <input type="text" id="searchOrderNumber" class="form-control" placeholder="البحث بإستخدام رقم العميل">
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label for="dateFrom" class="mt-1 mr-2">From:</label>
                        <input type="date" id="dateFrom" class="form-control" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label for="dateTo" class="mt-1 mr-2">To:</label>
                        <input type="date" id="dateTo" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>رقم الأوردر</th>
                            <th>تاريخ الإنشاء</th>
                            <th>إسم العميل</th>
                            <th>السعر الكامل</th>
                            <th>النوع</th>
                            <th>تم بواسطة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable">
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                                <td>{{ $order->customer->name}}</td>
                                <td>{{ $order->total_price }}</td>
                                <td>{{ $order->type }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">التفاصيل</a>
                                    {{-- <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">Edit</a> --}}
                                    <button type="button" class="btn btn-danger delete-order-btn" data-id="{{ $order->id }}">حذف</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد أوردرات الان</td>
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

<script>
    function exportTableToExcelXLSX(filename) {
        const table = document.getElementById("example1");
        const rows = [];

        // Extract table data
        table.querySelectorAll("tr").forEach(row => {
            const rowData = Array.from(row.querySelectorAll("td, th")).map(cell => cell.innerText);
            rows.push(rowData);
        });

        // Create a new workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows);

        // Append the worksheet to the workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

        // Export the workbook to a file
        XLSX.writeFile(workbook, filename);
    }

    document.getElementById("exportExcel").addEventListener("click", () => {
        exportTableToExcelXLSX("table.xlsx");
    });
</script>

<script>
    $(document).ready(function () {
        function fetchOrders() {
            const customerName = $('#searchCustomer').val();
            const orderNumber = $('#searchOrderNumber').val();
            const dateFrom = $('#dateFrom').val();
            const dateTo = $('#dateTo').val();

            $.ajax({
                url: '{{ route("orders.search") }}', // Adjust to your route
                type: 'GET',
                data: {
                    customer_name: customerName,
                    order_number: orderNumber,
                    date_from: dateFrom,
                    date_to: dateTo,
                },
                success: function (response) {
                    const tableBody = $('#orderTable');
                    tableBody.empty(); // Clear the table body

                    if (response.length > 0) {
                        // Append rows dynamically
                        response.forEach(order => {
                            tableBody.append(`
                                <tr>
                                    <td>${order.order_number}</td>
                                    <td>${order.created_at}</td>
                                    <td>${order.customer_name}</td>
                                    <td>${order.total_price}</td>
                                    <td>${order.type}</td>
                                    <td>${order.audit_by}</td>
                                    <td>
                                        <a href="/admin/orders/show/${order.id}" class="btn btn-info">التفاصيل</a>
                                    <button type="button" class="btn btn-danger delete-order-btn" data-id="${order.id}">حذف</button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        // No orders found
                        tableBody.append(`
                            <tr>
                                <td colspan="7" class="text-center">No orders found</td>
                            </tr>
                        `);
                    }
                },
                error: function () {
                    alert('An error occurred while processing the request.');
                }
            });
        }

        // Trigger fetchOrders on input change
        $('#searchCustomer, #searchOrderNumber, #dateFrom, #dateTo').on('input change', fetchOrders);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delegate the click event for dynamically added delete buttons
        $(document).on('click', '.delete-order-btn', function () {
            const orderId = $(this).data('id');
            const url = `{{ route('orders.destroy', ':id') }}`.replace(':id', orderId);

            Swal.fire({
                title: 'هل انت متأكد من حذف الأوردر',
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
                                'تم حذف العنصر بنجاح',
                                'success'
                            ).then(() => {
                                // Remove the deleted row from the table
                                $(`button[data-id="${orderId}"]`).closest('tr').remove();
                            });
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
</script>
