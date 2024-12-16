<x-admin-layout title=" مخزون">
    @section('content')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"> مخزون</h3>
            </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم العنصر</label>
                        <input type="text" readonly class="form-control" value="{{ $stock->name }}" id="exampleInputEmail1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">الوصف</label>
                        <input type="text" class="form-control" value="{{ $stock->description }}" readonly id="exampleInputPassword1">
                        <x-validation-error field="description" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">التاريخ</label>
                        <input type="date" readonly class="form-control" value="{{$stock->created_at }}" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">ملحوظات</label>
                       <textarea class="form-control" readonly id="exampleInputPassword1">{{ $stock->notes }}</textarea>
                    </div>
                </div>
        </div>
    @endsection
</x-admin-layout>
