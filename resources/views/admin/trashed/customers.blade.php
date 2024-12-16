<x-admin-layout title='العملاء'>
    @section('content')
        <div class="card">
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
                                <td colspan="6">لا توجد عملاء حتى الان</td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-customer-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-id');
                const url = `{{ route('customers.forceDelete', ':id') }}`.replace(':id', orderId);

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
                                    'تم حذف العنصر بنجاح',
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
