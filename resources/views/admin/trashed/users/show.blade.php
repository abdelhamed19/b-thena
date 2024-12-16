<x-admin-layout title="تعديل موظف ">
    @section('content')
    <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <label for="customer_name">اسم الموظف</label>
                    <input type="text" class="form-control" readonly id="customer_name" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="customer_name">البريد الإلكتروني</label>
                    <input type="email" class="form-control" readonly id="customer_name"value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="phone_number">رقم الهاتف</label>
                    <input type="number" class="form-control" id="phone_number" readonly value="{{ $user->phone }}">
                </div>
                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" class="form-control" readonly id="address" value="{{ $user->address }}">
                </div>
                <div class="form-group">
                    <label for="type">الوظيفه</label>
                    <select class="form-control">
                        <option value="">{{ $user->role }}</option>
                    </select>
                </div>
            </div>
    </div>
    @endsection
</x-admin-layout>
