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
</style> 

@extends('adminnav')
@section('admin')
<div id="page-wrapper">
    <div class="container-fluid">
<div class="container">
    <h1 class="text-center">Thêm Thể Loại</h1>
    <form id="addCategoryForm" data-action="{{ route('admin.storeCategory') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên Thể Loại:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="parent_id">Parent ID:</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">Chọn thể loại</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Lưu Thể Loại</button>
    </form>

    <div class="container mt-4">
        <h2>Danh sách Thể Loại</h2>
        <table class="table" id="categoryTables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Thể Loại</th>
                    <th>Parent ID</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody id="category-list">
                <!-- Dữ liệu thể loại sẽ được hiển thị ở đây sau khi cập nhật -->
            </tbody>
        </table>
    </div>
</div>
    </div>
</div>
@endsection 
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
                Bạn có chắc chắn muốn xóa thể loại này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sửa -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa Thể Loại</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editCategoryId" name="id">
                    <div class="form-group">
                        <label for="editName">Tên Thể Loại:</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editParentId">Parent ID:</label>
                        <input type="number" class="form-control" id="editParentId" name="parent_id" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="confirmEdit">Lưu</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Thông báo thêm thành công -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Thêm Thành Công</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Sản phẩm đã được thêm thành công!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var categoryIdToDelete = null;
        var categoryIdToEdit = null; 

        function loadCategories() {
            $.ajax({
                url: '{{ route('admin.loadCategory') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var categoryList = $('#category-list');
                    categoryList.empty();

                    $.each(data, function(index, category) {
                        var editButton = '<button class="btn btn-warning btn-sm edit-category" data-id="' + category.id + '">Sửa</button>';
                        var deleteButton = '<button class="btn btn-danger btn-sm delete-category" data-id="' + category.id + '">Xóa</button>';
                        categoryList.append('<tr><td>' + category.id + '</td><td>' + category.name + '</td><td>' + category.parent_id + '</td><td class="action-buttons">' + editButton + ' ' + deleteButton + '</td></tr>');
                    });
                    var categoryDropdown =  $('#parent_id')
                    $.each(data , function (index, category) {
                        var optionbtn = $('<option value="' + category.id + '">' + category.name + '</option> ');
                        categoryDropdown.append(optionbtn);

                    })
                }
            });
        }
        loadCategories();

        $('#addCategoryForm').on('submit', function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    var action = $(this).data('action'); 

    $.ajax({
        url: action, 
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                $('#addCategoryModal').modal('hide');
                $('#addCategoryForm')[0].reset();
                $('#successModal').modal('show');
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

        $(document).on('click', '.delete-category', function() {
            categoryIdToDelete = $(this).data('id'); 
            $('#deleteModal').modal('show');
        });
        $('#confirmDelete').on('click', function() {
            if (categoryIdToDelete) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content'); 
                $.ajax({
                    url: '/delete-category/' + categoryIdToDelete,
                    type: 'DELETE',
                    data: { _token: csrfToken },
                    success: function() {
                        $('#deleteModal').modal('hide');                        
                        $('#category-list tr[data-id="' + categoryIdToDelete + '"]').remove();
                        categoryIdToDelete = null; 
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        $(document).on('click', '.edit-category', function() {
    categoryIdToEdit = $(this).data('id'); // Lưu ID của thể loại cần chỉnh sửa

    $.ajax({
        url: '/category-loadEdit/' + categoryIdToEdit, // Sử dụng URL tường minh
        type: 'GET',
        dataType: 'json',
        success: function(category) {
            $('#editCategoryId').val(category.id);
            $('#editName').val(category.name);
            $('#editParentId').val(category.parent_id);
            $('#editModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

        $('#confirmEdit').on('click', function() {
            if (categoryIdToEdit) {
                var editData = $('#editForm').serialize();

                $.ajax({
                    url: '/update-category/' + categoryIdToEdit, // Sử dụng URL tường minh
                    type: 'PUT',
                    data: editData,
                    success: function() {
                        $('#editModal').modal('hide');
                        
                        var editedRow = $('#category-list tr[data-id="' + categoryIdToEdit + '"]');
                        editedRow.find('td:nth-child(2)').text($('#editName').val());
                        editedRow.find('td:nth-child(3)').text($('#editParentId').val());

                        categoryIdToEdit = null; // Đặt lại giá trị sau khi chỉnh sửa
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        $('#categoryTables').DataTable();
    });
</script>
