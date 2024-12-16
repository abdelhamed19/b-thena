<x-admin-layout title="إضافة مخزون جديد">
    @section('content')
        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">إضافة مخزون جديد</h3>
            </div>
            <form action="{{ route('stock.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم العنصر</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="exampleInputEmail1" placeholder="أدخل اسم العنصر">
                        <x-validation-error field="name" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">الوصف</label>
                        <input type="text" class="form-control" value="{{ old('description') }}" name="description" id="exampleInputPassword1" placeholder="أدخل وصف العنصر">
                        <x-validation-error field="description" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">التاريخ</label>
                        <input type="date" class="form-control" value="{{ old('created_at') }}" name="created_at" id="exampleInputPassword1">
                        <x-validation-error field="created_at" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">ملحوظات</label>
                       <textarea class="form-control" name="notes" id="exampleInputPassword1" placeholder="أدخل ملاحظات">{{ old('notes') }}</textarea>
                        <x-validation-error field="notes" />
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                </div>
            </form>
        </div>
    @endsection
</x-admin-layout>
