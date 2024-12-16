<x-admin-layout title="تعديل موظف ">
    @section('content')
    <div class="card card-primary">
        <x-flash-message />
        <div class="card-header">
            <h3 class="card-title">تعديل موظف </h3>
        </div>
        <form action="{{ route('update.user', $user->id) }}" id="orderForm" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="customer_name">اسم الموظف</label>
                    <input type="text" class="form-control" name="name" id="customer_name"
                        placeholder="اسم الموظف" value="{{ $user->name }}">
                        <x-validation-error field="name" />
                </div>
                <div class="form-group">
                    <label for="customer_name">البريد الإلكتروني</label>
                    <input type="email" class="form-control" name="email" id="customer_name"
                        placeholder="البريد الإلكتروني" value="{{ $user->email }}">
                        <x-validation-error field="email" />
                </div>
                <div class="form-group">
                    <label for="customer_name">كلمة السر</label>
                    <input type="password" class="form-control" name="password" id="customer_name"
                        placeholder="كلمة السر">
                        <x-validation-error field="password" />
                </div>
                <div class="form-group">
                    <label for="phone_number">رقم الهاتف</label>
                    <input type="number" class="form-control" name="phone" id="phone_number" required
                        placeholder="رقم الهاتف" value="{{ $user->phone }}">
                        <x-validation-error field="phone" />
                </div>
                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" class="form-control" name="address" id="address"
                        placeholder="العنوان" value="{{ $user->address }}">
                    <x-validation-error field="address" />
                </div>
                <div class="form-group">
                    <label for="type">الوظيفه</label>
                    <select class="form-control" name="role" required>
                        <option value="{{ $user->role }}">{{ $user->role }}</option>
                        <option value="owner">مالك</option>
                        <option value="manager">مدير</option>
                        <option value="cashier">كاشير</option>
                    </select>
                    <x-validation-error field="role" />
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">إضافه</button>
            </div>
        </form>
    </div>

    @endsection
</x-admin-layout>
