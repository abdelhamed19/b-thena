<x-admin-layout title='العملاء'>
    @section('content')
        <div class="card">
            <x-flash-message />
            <div class="card-header mb-2">
                <a href="{{ route('customers.create') }}" class="btn btn-primary">إضافة عميل جديد</a>
                {{-- <button class="btn btn-secondary" id="exportExcel" type="button">Download Excel File</button> --}}
            </div>
            <div class="row align-items-center mb-1">
                <!-- Search Input (Moved to the right) -->
                <div class="col-md-4 ml-3">
                    <label for="searchPhone">اكتب الرقم</label>
                    <input type="text" id="searchPhone" class="form-control" placeholder="البحث برقم هاتف العميل">
                </div>

                <div class="col-md-4 ml-3">
                    <label for="searchName">اكتب الاسم</label>
                    <input type="text" id="searchName" class="form-control" placeholder="البحث بإسم العميل">
                </div>
                <!-- Date From Filter -->
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>إسم العميل</th>
                            <th>رقم الهاتف</th>
                            <th>الحاله</th>
                            <th>عدد الأوردرات</th>
                            <th>تمت بواسطه</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody id="customerTable">
                        <!-- Initial load of customers -->
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->is_active ? 'نشط' : 'غير نشط' }}</td>
                                <td>{{ $customer->orders_count }}</td>
                                <td>{{ $customer->user->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info">عرض</a>
                                    {{-- <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Edit</a> --}}
                                        <button class="btn btn-danger delete-customer-btn" data-id="{{ $customer->id }}" type="submit">حذف</button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد عملاء حتى الان</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $customers->links('vendor.pagination.bootstrap-5') }}

            <!-- /.card-body -->
        </div>
    @endsection
</x-admin-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Trigger search on input for phone and name
        $('#searchPhone, #searchName').on('input', function() {
            const phone = $('#searchPhone').val(); // Get phone input value
            const name = $('#searchName').val(); // Get name input value

            // Perform AJAX request
            $.ajax({
                url: '{{ route('customers.search') }}',
                type: 'GET',
                data: {
                    phone: phone,
                    name: name,
                },
                success: function(response) {
                    const tableBody = $('#customerTable');
                    tableBody.empty(); // Clear the table body

                    if (response.length > 0) {
                        // Append rows dynamically
                        response.forEach((customer, index) => {
                            tableBody.append(`
                    <tr>
                        <td>${customer.id}</td>
                        <td>${customer.name}</td>
                        <td>${customer.phone}</td>
                        <td>${customer.is_active ? 'نشط' : 'غير نشط'}</td>
                        <td>${customer.orders_count}</td>
                        <td>${customer.user}</td> <!-- User name -->
                        <td>
                            <a href="/admin/customers/show/${customer.id}" class="btn btn-info">التفاصيل</a>
                                <button class="btn btn-danger delete-customer-btn" data-id="${customer.id}" type="submit">حذف</button>
                            </form>
                        </td>
                    </tr>
                `);
                        });
                    } else {
                        // No customers found
                        tableBody.append(`
                <tr>
                    <td colspan="7">No customers found</td>
                </tr>
            `);
                    }
                },
                error: function() {
                    alert('An error occurred while processing the request.');
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Delegate the click event to the document for dynamically added delete buttons
        $(document).on('click', '.delete-customer-btn', function () {
            const customerId = $(this).data('id');
            const url = `{{ route('customers.destroy', ':id') }}`.replace(':id', customerId);

            Swal.fire({
                title: 'هل انت متأكد من حذف العميل',
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
                                'تم حذف العميل بنجاح',
                                'success'
                            ).then(() => {
                                // Remove the deleted row from the table
                                $(`button[data-id="${customerId}"]`).closest('tr').remove();
                            });
                        } else {
                            Swal.fire(
                                'خطأ!',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'خطأ!',
                            'حدث خطأ غير متوقع.',
                            'error'
                        );
                    });
                }
            });
        });
    });
</script>

