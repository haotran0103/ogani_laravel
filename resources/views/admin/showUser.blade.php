
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
    <h2>bảng thông tin user</h2>

    <div class="container mt-4">
        <h2>Danh sách user</h2>
        <table class="table" id="userTables">
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
            <tbody id="user-list">
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
                        <input type="hidden" id="edituserId" name="id">
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
        var userIdToDelete = null;
        var userIdToEdit = null; 
        function loaduserAcount() {
            console.log("Mã JavaScript đã chạy!");
    $.ajax({
        url: '{{ route('admin.showUser') }}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var userList = $('#user-list');
            userList.empty();

            $.each(data, function(index, userItem) {
                // Kiểm tra nếu vai trò của người dùng là user, sau đó thêm vào bảng
                if (userItem.role === 'user') {
                    var editButton = '<button class="btn btn-warning btn-sm edit-user" data-id="' + userItem.id + '">Sửa</button>';
                    var deleteButton = '<button class="btn btn-danger btn-sm delete-user" data-id="' + userItem.id + '">Xóa</button>';
                    userList.append('<tr><td>' + userItem.id + '</td><td>' + userItem.first_name + ' ' + userItem.last_name + '</td><td>' + userItem.email + '</td><td>' + userItem.phone_number + '</td><td>' + userItem.address + '</td><td class="action-buttons">' + editButton + ' ' + deleteButton + '</td></tr>');
                }
            });
        }
    });
}

loaduserAcount(); // Gọi hàm để hiển thị danh sách người dùng user khi trang được nạp


   
    $('#userTables').DataTable();
});
</script>
