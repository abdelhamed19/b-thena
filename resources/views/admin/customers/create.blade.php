<x-admin-layout title="إضافة عميل جديد">
    @section('content')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إضافة عميل جديد</h3>
            </div>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">إسم العميل</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="ادخل الاسم">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">الرقم</label>
                        <input type="text" name="phone" class="form-control" id="exampleInputPassword1" placeholder="ادخل الرقم">
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-4">
                            <label for="exampleInputEmail1">الحاله</label>
                            <!-- Select input for Item -->
                            <select class="form-control">
                                <option value="">اختر الحاله</option>
                                <option value="1">نشط</option>
                                <option value="2">غير نشط</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-8">
                            <label for="exampleInputEmail1">العنوان </label>
                            <input type="text" name="address" class="form-control" placeholder="ادخل العنوان">
                        </div>
                    </div>

                    <div id="rowsContainer">
                        <!-- New rows will be added here -->
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">اضف</button>
                </div>
            </form>
        </div>
    @endsection
</x-admin-layout>
<script>
    // Function to add a new row
    function addRow() {
        // Create a new row with the same structure as the original one
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'align-items-center');

        newRow.innerHTML = `
                        <div class="col-8">
                            <label for="exampleInputEmail1">Address </label>
                            <input type="text" class="form-control" placeholder="Address">
                        </div>


            <!-- Add Button (aligned with inputs) -->
            <div class="col-1">
                <button type="button" class="btn btn-info w-80 mt-4" onclick="addRow()">Add</button>
            </div>

            <!-- Delete Button (for rows after the first) -->
            <div class="col-1">
                <button type="button" class="btn btn-danger w-80 mt-4" onclick="deleteRow(this)">Delete</button>
            </div>
        `;

        // Append the new row to the rows container
        document.getElementById('rowsContainer').appendChild(newRow);
    }

    // Function to delete a row
    function deleteRow(button) {
        const row = button.closest('.row');
        if (row && row.parentNode) {
            row.parentNode.removeChild(row);
        }
    }

    // Add event listener to the initial "Add" button
    document.getElementById('addRowBtn').addEventListener('click', addRow);
</script>
