<x-admin-layout title='العملاء'>
    @section('content')
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم العميل</th>
                            <th>رقم الهاتف</th>
                            <th>الحالة</th>
                            <th>العنوان</th>
                            <th>عدد الأوردرات</th>

                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->is_active ? 'نشط' : 'غير نشط' }}</td>
                                <td>{{ $customer->addresses->address }}</td>
                                <td>{{ $customer->orders_count }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-admin-layout>
