<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@extends('adminnav')
@section('admin')
<style>

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
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
</style>


    @include('adminnav')
    @yield('navigation')
    <div id="page-wrapper">
        <div class="container-fluid">
    <div class="container">
        <div class="container mt-4">
            <h2>Danh sách sản phẩm</h2>

            <table class="table" id="ProductTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>ảnh</th>
                        <th>số lượng tồn kho</th>
                        <th>xuất xứ</th>

                        <th>thời gian đăng</th>
                        <th>thời gian được update</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="Product-list">

                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>
    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa thú cưng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sửa Thú Cưng -->
<!-- Modal Sửa Thú Cưng -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Chỉnh sửa Thức ăn cho thú cưng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editProductId" name="id">
                    <div class="form-group">
                        <label for="editName">Tên:</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Mô tả:</label>
                        <input type="text" class="form-control" id="editDescription" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="editPrice">Giá:</label>
                        <input type="text" class="form-control" id="editPrice" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="stock_quantity">hàng tồn kho:</label>
                        <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="manufacturer">xuất xứ:</label>
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" required>
                    </div>
                    <div class="form-group">
                        <label for="editImage">Hình ảnh:</label>
                        <input type="file" class="form-control-file" id="editImage" name="image">
                        <img src="" id="editImagePreview" alt="Hình ảnh hiện tại" style="max-width: 100px; max-height: 100px; display: none;">
                    </div>
                                       
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveEditProduct">Lưu</button>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    $(document).ready(function() {
        var ProductIdToDelete = null; // Biến lưu ID thú cưng cần xóa
        var ProductIdToEdit = null; // Biến lưu ID thú cưng cần chỉnh sửa

        function loadProduct() {
            $.ajax({
                url: '{{ route('admin.loadProduct') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var ProductList = $('#Product-list');
                    ProductList.empty();

                    $.each(data, function(index, Product) {
                        var formattedPrice = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(Product.price);
                        var formattedCreatedAt = new Date(Product.created_at).toLocaleString('vi-VN', { timeZoneName: 'short' });
                        var formattedUpdatedAt = new Date(Product.updated_at).toLocaleString('vi-VN', { timeZoneName: 'short' });
                        var editButton = '<button class="btn btn-warning btn-sm edit-Product" data-id="' + Product.id + '">Sửa</button>';
                        var deleteButton = '<button class="btn btn-danger btn-sm delete-Product" data-id="' + Product.id + '">Xóa</button>';
                        var imagesDiv = '<div class="Product-images">';
                        var limitedDescription = limitText(Product.description, 20);
                        var attachments = JSON.parse(Product.attachments);
                            $.each(attachments, function(i, attachment) {
                            imagesDiv += '<img src="/uploads/images/' + attachment + '" alt="Hình ảnh sản phẩm" width="100">';
                        });
                            imagesDiv += '</div>';
                        ProductList.append('<tr><td>' + Product.id + '</td><td>' + Product.name + '</td><td>' + limitedDescription + '</td><td>' + formattedPrice + '</td><td>' + imagesDiv + '</td><td>' + Product.stock_quantity + '</td><td>' + Product.manufacturer + '</td><td>' + formattedCreatedAt + '</td><td>' + formattedUpdatedAt + '</td><td class="action-buttons">' + editButton + ' ' + deleteButton + '</td></tr>');
                    });
                }
            });
        }

        loadProduct();
        function limitText(text, maxLength) {
        if (text.length > maxLength) {
            return text.substring(0, maxLength) + '...';
        }
        return text;
    }

        // Xóa thú cưng
        $(document).on('click', '.delete-Product', function() {
            ProductIdToDelete = $(this).data('id'); // Lưu ID của thú cưng cần xóa
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').on('click', function() {
            if (ProductIdToDelete) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Lấy mã CSRF token
                $.ajax({
                    url: '/delete-Product/' + ProductIdToDelete,
                    type: 'DELETE',
                    data: { _token: csrfToken },
                    success: function() {
                        $('#deleteModal').modal('hide');
                        loadProduct();
                        ProductIdToDelete = null;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

$(document).on('click', '.edit-Product', function() {
    ProductIdToEdit = $(this).data('id'); 
    $.ajax({
        url: '/Product-loadEdit/' + ProductIdToEdit,
        type: 'GET',
        dataType: 'json',
        success: function(Product) {
            $('#editProductId').val(Product.id);
            $('#editName').val(Product.name);
            $('#editDescription').val(Product.description);
            $('#editPrice').val(Product.price);
            $('#stock_quantity').val(Product.stock_quantity);
            $('#manufacturer').val(Product.manufacturer);
            $('#attachments').val(Product.category_id);
            var currentImagePreview = $('#editImagePreview');
            var attachments = JSON.parse(Product.attachments);
            var imagesDiv = '<div class="Product-images">';
            $.each(attachments, function(i, attachment) {
            imagesDiv += '<img src="/uploads/images/' + attachment + '" alt="Hình ảnh sản phẩm" width="100">';
            });
            imagesDiv += '</div>';
            currentImagePreview.append(imagesDiv)
            $('#editImage').val('');
            $('#editProductModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

$('#saveEditProduct').on('click', function() {
    if (ProductIdToEdit) {
        var editForm = document.getElementById('editProductForm');
        var formData = new FormData(editForm);
        $.ajax({
            url: '/update-Product/' + ProductIdToEdit,
            type: 'POST', // Sử dụng POST để gửi dữ liệu form, không phải PUT
            data: formData,
            processData: false, // Không xử lý dữ liệu gửi đi (để tránh lỗi)
            contentType: false, // Không đặt lại loại nội dung (để tránh lỗi)
            success: function() {
                $('#editProductModal').modal('hide');
                loadProduct();
                ProductIdToEdit = null;
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});

$('#editImage').on('change', function() {
    var inputImage = $(this)[0];
    var imagePreview = $('#editImagePreview');

    if (inputImage.files && inputImage.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.attr('src', e.target.result);
            imagePreview.css('display', 'block');
        };

        reader.readAsDataURL(inputImage.files[0]);
    }
});

        $('#ProductTable').DataTable();
    });
</script>
