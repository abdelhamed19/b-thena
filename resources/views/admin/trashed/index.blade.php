<x-admin-layout title='الموظفين'>
    @section('content')
        <div class="card">
            <x-flash-message />
            <div class="card-header">
                <a href="{{ route('orders.trashed') }}" class="btn btn-primary">الطلبات المحذوفه</a>
                <a href="{{ route('customers.trashed') }}" class="btn btn-info">العملاء المحذوفه</a>
            </div>

            <div class="card-body">
                <a href="{{ route('create.user') }}" class="btn btn-info">إضافه موظف جديد</a>
                <table id="example1" class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>إسم الموظف</th>
                            <th>الوظيفه</th>
                            <th>رقم الهاتف</th>
                            <th>العنوان</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable">
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->address }}</td>
                                <td>
                                    <a href="{{ route('show.user', $user->id) }}" class="btn btn-info">التفاصيل</a>
                                    <a href="{{ route('edit.user', $user->id) }}" class="btn btn-warning">تعديل</a>
                                    <button type="button" class="btn btn-danger delete-user-btn"
                                        data-id="{{ $user->id }}">حذف</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">لا توجد موظفين الان</td>
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
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-user-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                const url = `{{ route('delete.user', ':id') }}`.replace(':id', orderId);

                Swal.fire({
                    title: 'هل أنت متأكد من حذف الموظف؟',
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
                                    ).then(() => location
                                .reload()); // Reload the page
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
