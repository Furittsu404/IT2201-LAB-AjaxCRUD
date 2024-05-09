<?php
session_start();
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../login");
}
$connection = new Connection();
$database = new adminAction($connection->connect());

$user_id = $_POST['user_ID'];
$result = $database->showRecords('userdata', "WHERE user_ID = $user_id");
$result2 = $database->showRecords('userlogin', "WHERE user_ID = $user_id");
?>

<div class="main-action p-3 d-flex flex-column align-content-center">
    <form class="container" method="post" id="editForm">
        <h1 class="display-5 ">Edit User</h1> <br>
        <div class="form-group row">
            <label for="user_Name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" oninput="letterOnly(this.id);" class="form-control" id="user_Name" name="user_Name"
                    placeholder="Name" value="<?php echo isset($result[0][2]) ? $result[0][2] : '' ?>" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Nickname" class="col-sm-2 col-form-label">Nickname</label>
            <div class="col-sm-10">
                <input type="text" oninput="validSymbol(this.id);" class="form-control" id="user_Nickname"
                    name="user_Nickname" placeholder="Nickname"
                    value="<?php echo isset($result[0][1]) ? $result[0][1] : '' ?>" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" oninput="validSymbol(this.id);" class="form-control" id="user_Email"
                    name="user_Email" placeholder="Email"
                    value="<?php echo isset($result2[0][1]) ? $result2[0][1] : '' ?>" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" oninput="validSymbol(this.id);" class="form-control" id="user_Password"
                    name="user_Password" placeholder="Password (Optional)">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="confirmPass" class="col-sm-2 col-form-label">Confirm Password</label>
            <div class="col-sm-10">
                <input type="password" oninput="validSymbol(this.id);" class="form-control" id="confirmPass"
                    name="confirmPass" placeholder="Confirm Password">
            </div>
        </div>
        <br>
        <div class="form-row-end">
            <input type="checkbox" class="form-check-input"
                onclick="showPassword('user_Password','confirmPass')"><a>Show Password</a>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Phone" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
                <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control" id="user_Phone"
                    name="user_Phone" placeholder="10-Digits Phone Number (Optional)"
                    value="<?php echo isset($result[0][3]) ? $result[0][3] : '' ?>">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Location" class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-10">
                <input type="text" oninput="validSymbol(this.id);" class="form-control" id="user_Location"
                    name="user_Location" placeholder="Location (Optional)"
                    value="<?php echo isset($result[0][4]) ? $result[0][4] : '' ?>">
            </div>
        </div>
        <br>
        <div class="form-group row hidden">
            <label for="user_ID" class="col-sm-2 col-form-label">USER_ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_ID" name="user_ID" placeholder="USERID"
                    value="<?php echo isset($result[0][0]) ? $result[0][0] : '' ?>">
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end gap-3">
            <button type="button" onclick="cancel()" class="btn btn-secondary w-25"><span
                    class="btn-text">Cancel</span><i class="bi bi-x-lg btn-icon"></i></button>
            <button type="submit" name="edit" class="btn btn-success w-25"><span class="btn-text">Edit
                    User</span><i class="bi bi-check-lg btn-icon"></i></button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'EDIT.process.php',
                data: $('#editForm').serialize(),
                success: function (response) {
                    if (response == 'success') {
                        $.ajax({
                            url: 'updateList.php',
                            success: function (response) {
                                $('#users-table-body').html(response);
                            }
                        });
                        document.getElementById('actionModal').innerHTML = "";
                        alert('Record Updated Successfully');
                    } else {
                        alert(response);
                    }
                }
            });
        });
    });
    function cancel() {
        document.getElementById('actionModal').innerHTML = "";
    }
</script>