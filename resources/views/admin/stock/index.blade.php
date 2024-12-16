<x-admin-layout title='المخزون'>
    @section('content')
    <div class="card">
        <x-flash-message />
        <div class="card-header mb-2">
            <a href="{{ route('stock.create') }}" class="btn btn-primary">إضافة مخزون جديد</a>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المخزون</th>
                        <th>وصف المخزون</th>
                        <th>تاريخ الإضافه</th>
                        <th>اخر تحديث</th>
                        <th>تمت بواسطة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                <a href="{{ route('stock.show', $item->id) }}" class="btn btn-info">عرض</a>
                                <a href="{{ route('stock.edit', $item->id) }}" class="btn btn-warning">تعديل</a>
                                <button class="btn btn-danger delete-btn" data-id="{{ $item->id }}">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد عناصر</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection
</x-admin-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.getAttribute('data-id');
                const url = `{{ route('stock.destroy', ':id') }}`.replace(':id', itemId);
                Swal.fire({
                    title: 'هل انت متأكد من حذف العنصر',
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
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    'تم الحذف',
                                    'تم حذف العنصر بنجاح',
                                    'success'
                                ).then(() => location.reload()); // Reload the page
                            } else {
                                Swal.fire(
                                    'حذف خطأ',
                                    'خطأ غير متوقع',
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
