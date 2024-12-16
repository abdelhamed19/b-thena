<x-admin-layout title="Create Order">
    @section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">إنشاء طلب</h3>
        </div>
        <form action="{{ route('orders.store') }}" id="orderForm" method="POST">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="type">نوع الطلب</label>
                    <select class="form-control" name="type" required>
                        <option value="">اختر النوع</option>
                        <option value="take_away">استلام من المتجر</option>
                        <option value="delivery">توصيل</option>
                    </select>
                    <x-validation-error field="type" />
                </div>

                <div class="form-group">
                    <label for="customer_search">العميل</label>
                    <select id="customer_search" class="form-control">
                        <option value="">ابحث واختر العميل</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="customer_name">اسم العميل</label>
                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                        placeholder="اسم العميل">
                </div>
                <div class="form-group">
                    <label for="phone_number">رقم الهاتف</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number"
                        placeholder="رقم الهاتف">
                </div>
                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="العنوان">
                </div>

                <div id="rowsContainer">
                    <div class="row align-items-center item-row">
                        <div class="col-4">
                            <label for="exampleInputEmail1">الصنف</label>
                            <select class="form-control item-select" name="items[0][item_id]" required>
                                <option value="">اختر الصنف</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                        {{ $item->item_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label>السعر</label>
                            <input type="number" name="items[0][price]" class="form-control item-price" readonly>
                        </div>
                        <div class="col-2">
                            <label>الكمية</label>
                            <input type="number" class="form-control item-quantity" name="items[0][quantity]"
                                value="1" min="1" required>
                        </div>
                        <div class="col-2">
                            <label>الإجمالي</label>
                            <input type="number" name="items[0][total]" class="form-control item-total" readonly>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-info w-80 mt-4" onclick="addRow()">إضافة</button>
                        </div>
                    </div>
                    <x-validation-error field="items" />
                </div>

                <div class="row mt-3">
                    <div class="col-8"></div>
                    <div class="col-2">
                        <label>الإجمالي الكلي</label>
                        <input type="number" id="grandTotal" class="form-control" readonly>
                    </div>
                </div>

                <br>
                <div class="form-group">
                    <label for="notes">ملاحظات</label>
                    <input type="text" class="form-control" name="notes" id="notes" placeholder="ملاحظات">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">إرسال</button>
            </div>
        </form>
    </div>

    @endsection
</x-admin-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle item selection
        $(document).on('change', '.item-select', function() {
            const row = $(this).closest('.item-row');
            const itemId = $(this).val();

            if (itemId) {
                $.ajax({
                    url: '/get-item-price/' + itemId,
                    method: 'GET',
                    success: function(data) {
                        row.find('.item-price').val(data.item_price);
                        updateRowTotal(row);
                        updateGrandTotal();
                    },
                    error: function() {
                        alert('Error fetching price!');
                    }
                });
            } else {
                row.find('.item-price').val('');
                row.find('.item-total').val('');
                updateGrandTotal();
            }
        });

        // Handle quantity change
        $(document).on('input', '.item-quantity', function() {
            const row = $(this).closest('.item-row');
            updateRowTotal(row);
            updateGrandTotal();
        });

        $('#customer_search').select2({
            placeholder: 'Search by phone or name',
            ajax: {
                url: '{{ route('search.customers') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term // Search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(customer) {
                            return {
                                id: customer.id,
                                text: `${customer.name} (${customer.phone}) - ${customer.address || 'No address'}`,
                                name: customer.name,
                                phone: customer.phone,
                                address: customer.address
                            };
                        })
                    };
                },
                cache: true
            }
        });

        // Handle selection
        $('#customer_search').on('select2:select', function(e) {
            const data = e.params.data;
            $('#customer_name').val(data.name);
            $('#phone_number').val(data.phone);
            $('#address').val(data.address || ''); // Update address field
        });
    });

    function updateRowTotal(row) {
        const price = parseFloat(row.find('.item-price').val()) || 0;
        const quantity = parseInt(row.find('.item-quantity').val()) || 0;
        const total = price * quantity;
        row.find('.item-total').val(total.toFixed(2));
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        $('.item-total').each(function() {
            grandTotal += parseFloat($(this).val()) || 0;
        });
        $('#grandTotal').val(grandTotal.toFixed(2));
    }

    function addRow() {
        const rowCount = $('.item-row').length;
        const newRow = $(`
            <div class="row align-items-center item-row">
                <div class="col-4">
                    <label>الصنف</label>
                    <select class="form-control item-select" name="items[${rowCount}][item_id]" required>
                        <option value="">إختر الصنف</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                {{ $item->item_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label>السعر</label>
                    <input type="number" name="items[${rowCount}][price]" class="form-control item-price" readonly>
                </div>
                <div class="col-2">
                    <label>الكميه</label>
                    <input type="number" class="form-control item-quantity" name="items[${rowCount}][quantity]"
                        value="1" min="1" required>
                </div>
                <div class="col-2">
                    <label>الإجمالي</label>
                    <input type="number" name="items[${rowCount}][total]" class="form-control item-total" readonly>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger w-80 mt-4" onclick="deleteRow(this)">حذف</button>
                </div>
            </div>
        `);

        $('#rowsContainer').append(newRow);
    }

    function deleteRow(button) {
        $(button).closest('.item-row').remove();
        updateGrandTotal();

        // Reindex the remaining rows
        $('.item-row').each(function(index) {
            $(this).find('select, input').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
                }
            });
        });
    }
</script>

<script>
    $(document).ready(function() {
        // Listen to changes in the 'type' dropdown
        $('select[name="type"]').change(function() {
            const type = $(this).val();

            // Disable or enable fields based on the selection
            if (type === 'take_away') {
                disableDeliveryFields();
            } else if (type === 'delivery') {
                enableDeliveryFields();
            }
        });

        function disableDeliveryFields() {
            $('#customer_name').prop('disabled', true).val('');
            $('#phone_number').prop('disabled', true).val('');
            $('#address').prop('disabled', true).val('');
            $('#customer_search').prop('disabled', true).val(null).trigger('change'); // Disable and reset customer search
        }

        function enableDeliveryFields() {
            $('#customer_name').prop('disabled', false);
            $('#phone_number').prop('disabled', false);
            $('#address').prop('disabled', false);
            $('#customer_search').prop('disabled', false); // Enable customer search
        }

        // Run on page load to set the initial state
        const initialType = $('select[name="type"]').val();
        if (initialType === 'take_away') {
            disableDeliveryFields();
        } else if (initialType === 'delivery') {
            enableDeliveryFields();
        }
    });
</script>

