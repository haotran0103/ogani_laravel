<style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin-top: 50px;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
        }
        .action-buttons button {
            margin-right: 5px;
        }
        .custom-file-label {
            overflow: hidden;
        }
        .custom-file-label::after {
            content: "Chọn tệp";
        }
    </style>
    <!-- Bao gồm thanh điều hướng -->
    @extends('adminnav')
    @section('admin')
    <!-- Thông báo thành công -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
        @if (Session::has('success'))
        <div class="alert alert-success" id="success-alert">
            {{ Session::get('success') }}
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-warning" id="success-alert">
            {{ Session::get('error') }}
        </div>
        @endif
        <h2>Thêm sản phẩm tạp hóa</h2>
        <form action="{{ route('admin.storeProduct') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="text" name="price" id="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="stock_quantity" class="form-label">Số lượng tồn kho</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="manufacturer" class="form-label">Nhà sản xuất</label>
                <input type="text" name="manufacturer" id="manufacturer" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="attachments" class="form-label">Tệp đính kèm</label>
                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple required>
            </div>
            <div class="mb-3" style="margin-top: 15px ; margin-bottom: 25px">
                <label for="parent_id">Parent ID:</label>
                <select class="form-control" id="parent_id" name="parent_id" required>
                    <option value="">Chọn thể loại</option>
                </select>
            </div>
            <div id="selected-images"></div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
            </div>
        </div>
    </div>
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
   
        $(document).ready(function() {

            function loadCategories() {
            $.ajax({
                url: '{{ route('admin.loadCategory') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                   
                    var categoryDropdown =  $('#parent_id')
                    $.each(data , function (index, category) {
                        var optionbtn = $('<option value="' + category.id + '">' + category.name + '</option> ');
                        categoryDropdown.append(optionbtn);

                    })
                }
            });
        }
        loadCategories();
    
            document.getElementById('attachments').addEventListener('change', function() {
                var selectedImages = document.getElementById('selected-images');
                selectedImages.innerHTML = '';
                var files = this.files;
                for (var i = 0; i < files.length; i++) {
                    var image = document.createElement('img');
                    image.src = URL.createObjectURL(files[i]);
                    image.style.maxWidth = '100px';
                    image.style.maxHeight = '100px';
                    selectedImages.appendChild(image);
                }
            });
        });

    </script>
