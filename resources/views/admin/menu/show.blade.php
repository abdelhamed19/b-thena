<x-admin-layout title='القائمة'>
    @section('content')
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم العنصر</th>
                            <th>وصف العنصر</th>
                            <th>الحالة</th>
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->item_description }}</td>
                                <td>{{ $item->is_active ? 'نشط' : 'غير نشط' }}</td>
                                <td>{{ $item->item_price }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-admin-layout>
