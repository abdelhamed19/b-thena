<x-admin-layout title='التقارير'>
    @section('content')
        <div class="card">
            <x-flash-message />

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>القيمه</th>
                            <th>النوع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>{{ $summary['orders'] }}</td>
                            <td>إحمالي العائد من الأوردرات</td>
                        </tr>
                        <tr>
                            <td>{{ $summary['ordersCount'] }}</td>
                            <td>إجمالي عدد الأوردرات</td>
                        <tr>
                            <td>{{ $summary['menu'] }}</td>
                            <td>إجمالي عدد العناصر في المنيو</td>
                        </tr>
                        <tr>
                            <td>{{ $summary['customersCount'] }}</td>
                            <td>إجمالي عدد العملاء في الطلبات</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-admin-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
