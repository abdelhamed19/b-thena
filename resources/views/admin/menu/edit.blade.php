<x-admin-layout title="إضافة عنصر جديد">
    @section('content')
        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">إضافة عنصر جديد</h3>
            </div>
            <form action="{{ route('menu.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم العنصر</label>
                        <input type="text" name="item_name" class="form-control" value="{{ $item->item_name }}" id="exampleInputEmail1" placeholder="أدخل اسم العنصر">
                        <x-validation-error field="item_name" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">الوصف</label>
                        <input type="text" class="form-control" value="{{ $item->item_description }}" name="item_description" id="exampleInputPassword1" placeholder="أدخل وصف العنصر">
                        <x-validation-error field="item_description" />
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-4">
                            <label for="exampleInputEmail1">الحالة</label>
                            <!-- Select input for Item -->
                            <select name="is_active" class="form-control">
                                <option value="">اختر الحالة</option>
                                <option value="1">نشط</option>
                                <option value="0">غير نشط</option>
                            </select>
                            <x-validation-error field="is_active" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">السعر</label>
                        <input type="number" name="item_price" class="form-control" value="{{ $item->item_price }}" id="exampleInputPassword1" placeholder="أدخل السعر">
                        <x-validation-error field="item_price" />
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                </div>
            </form>
        </div>
    @endsection
</x-admin-layout>
