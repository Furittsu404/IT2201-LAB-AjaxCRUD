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

    <form class="container" method="post" id="deleteForm">
        <h1 class="display-5 ">Delete User?</h1> <br>
        <div class="form-group row">
            <label for="user_Name" class="col-sm-2 col-form-label fw-bold">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_Name" name="user_Name" placeholder="Name"
                    value="<?php echo isset($result[0][2]) ? $result[0][2] : '' ?>" readonly>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Nickname" class="col-sm-2 col-form-label fw-bold">Nickname</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_Nickname" name="user_Nickname" placeholder="Nickname"
                    value="<?php echo isset($result[0][1]) ? $result[0][1] : '' ?>" readonly>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Email" class="col-sm-2 col-form-label fw-bold">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="user_Email" name="user_Email" placeholder="Email"
                    value="<?php echo isset($result2[0][1]) ? $result2[0][1] : '' ?>" readonly>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Phone" class="col-sm-2 col-form-label fw-bold">Phone</label>
            <div class="col-sm-10">
                <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control" id="user_Phone"
                    name="user_Phone" placeholder="10-Digits Phone Number (Optional)"
                    value="<?php echo isset($result[0][3]) ? $result[0][3] : '' ?>" readonly>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Location" class="col-sm-2 col-form-label fw-bold">Location</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_Location" name="user_Location"
                    placeholder="Location (Optional)" value="<?php echo isset($result[0][4]) ? $result[0][4] : '' ?>"
                    readonly>
            </div>
        </div>
        <br>
        <div class="form-group row hidden">
            <label for="user_ID" class="col-sm-2 col-form-label">USER_ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="user_ID" name="user_ID" placeholder="USERID"
                    value="<?php echo isset($result[0][0]) ? $result[0][0] : '' ?>" readonly>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end gap-3">
            <button type="button" class="btn btn-secondary w-25" onclick="cancel()"><span class="btn-text">Cancel</span>
                <i class="bi bi-backspace btn-icon"></i></button>
            <button type="submit" name="delete" class="btn btn-danger w-25"><span class="btn-text">Delete
                    User</span><i class='bi bi-trash btn-icon'></i></button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#deleteForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'DELETE.process.php',
                data: $('#deleteForm').serialize(),
                success: function (response) {
                    if (response == 'success') {
                        $.ajax({
                            url: 'updateList.php',
                            success: function (response) {
                                $('#users-table-body').html(response);
                            }
                        });
                        document.getElementById('actionModal').innerHTML = "";
                        $.ajax({
                            url: 'updatePages.php',
                            success: function (response) {
                                $('#table-pages').html(response);
                            }
                        });
                        alert('Record Deleted Successfully');
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