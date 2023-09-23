
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
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
    <div class="container">
        @if (Session::has('success'))
        <div class="alert alert-success" id="success-alert">
            {{ Session::get('success') }}
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-success" id="success-alert">
            {{ Session::get('error') }}
        </div>
        @endif
        <h2>Thêm tài khoản admin</h2>
        <form id="addadminForm" action="{{ route('admin.storeadmin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="first_name">Họ:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Tên:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Tạo admin</button>
        </form>
        <div class="container mt-4">
            <h2>Danh sách Admin</h2>
            <table class="table" id="adminTables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên </th>
                        <th>email</th>
                        <th>số điện thoại</th>
                        <th>địa chỉ</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody id="admin-list">
                    <!-- Dữ liệu thể loại sẽ được hiển thị ở đây sau khi cập nhật -->
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>
    @endsection
        <!-- Thông báo thành công -->
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
                            <input type="hidden" id="editadminId" name="id">
                            <div class="form-group">
                                <label for="editfirstName">Họ:</label>
                                <input type="text" class="form-control" id="editfirstName" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="editlastName">Tên:</label>
                                <input type="text" class="form-control" id="editlastName" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label for="editaddress">địa chỉ:</label>
                                <input type="text" class="form-control" id="editaddress" name="address">
                            </div>
                            <div class="form-group">
                                <label for="editemail">email:</label>
                                <input type="email" class="form-control" id="editemail" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="editphoneNumber">Số điện thoại:</label>
                                <input type="text" class="form-control" id="editphoneNumber" name="phone_number">
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var adminIdToDelete = null;
            var adminIdToEdit = null; 
            function loadAdminAcount() {
                console.log("Mã JavaScript đã chạy!");
        $.ajax({
            url: '{{ route('admin.loadAdmin') }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var adminList = $('#admin-list');
                adminList.empty();

                $.each(data, function(index, adminItem) {
                    // Kiểm tra nếu vai trò của người dùng là admin, sau đó thêm vào bảng
                    if (adminItem.role === 'admin') {
                        var editButton = '<button class="btn btn-warning btn-sm edit-admin" data-id="' + adminItem.id + '">Sửa</button>';
                        var deleteButton = '<button class="btn btn-danger btn-sm delete-admin" data-id="' + adminItem.id + '">Xóa</button>';
                        adminList.append('<tr><td>' + adminItem.id + '</td><td>' + adminItem.first_name + ' ' + adminItem.last_name + '</td><td>' + adminItem.email + '</td><td>' + adminItem.phone_number + '</td><td>' + adminItem.address + '</td><td class="action-buttons">' + editButton + ' ' + deleteButton + '</td></tr>');
                    }
                });
            }
        });
    }

    loadAdminAcount(); // Gọi hàm để hiển thị danh sách người dùng admin khi trang được nạp

    
        $('#addadminForm').on('submit', function(e) {
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
                    $('#addadminModal').modal('hide');
                    $('#addadminForm')[0].reset();
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

    $(document).on('click', '.delete-admin', function() {
            adminIdToDelete = $(this).data('id'); 
            $('#deleteModal').modal('show');
        });
        $('#confirmDelete').on('click', function() {
            if (adminIdToDelete) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content'); 
                $.ajax({
                    url: '/delete-admin/' + adminIdToDelete,
                    type: 'DELETE',
                    data: { _token: csrfToken },
                    success: function() {
                        $('#deleteModal').modal('hide');                        
                        $('#admin-list tr[data-id="' + adminIdToDelete + '"]').remove();
                        adminIdToDelete = null; 
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        $(document).on('click', '.edit-admin', function() {
    adminIdToEdit = $(this).data('id'); // Lưu ID của thể loại cần chỉnh sửa

    $.ajax({
        url: '/admin-loadEdit/' + adminIdToEdit, // Sử dụng URL tường minh
        type: 'GET',
        dataType: 'json',
        success: function(admin) {
            $('#editadminId').val(admin.id);
            $('#editfirstName').val(admin.first_name);
            $('#editlastName').val(admin.last_name);
            $('#editemail').val(admin.email);
            $('#editphoneNumber').val(admin.phone_number);
            $('#editaddress').val(admin.address);
            $('#editModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

        $('#confirmEdit').on('click', function() {
            if (adminIdToEdit) {
                var editData = $('#editForm').serialize();

                $.ajax({
                    url: '/update-admin/' + adminIdToEdit, // Sử dụng URL tường minh
                    type: 'PUT',
                    data: editData,
                    success: function() {
                        $('#editModal').modal('hide');
                        
                        var editedRow = $('#admin-list tr[data-id="' + adminIdToEdit + '"]');
                        editedRow.find('td:nth-child(2)').text($('#editName').val());
                        editedRow.find('td:nth-child(3)').text($('#editParentId').val());

                        adminIdToEdit = null; // Đặt lại giá trị sau khi chỉnh sửa
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        $('#adminTables').DataTable();
});
    </script>
