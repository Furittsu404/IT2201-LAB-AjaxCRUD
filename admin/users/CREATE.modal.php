<?php
session_start();
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../login");
}
$connection = new Connection();
$database = new adminAction($connection->connect());
?>

<div class="main-action p-3 d-flex flex-column align-content-center">
    <form class="container" method="post" id="createForm">
        <h1 class="display-5 ">Create User</h1> <br>
        <div class="form-group row">
            <label for="user_Name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" oninput="letterOnly(this.id);" class="form-control" id="user_Name" name="user_Name"
                    placeholder="Name" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Nickname" class="col-sm-2 col-form-label">Nickname</label>
            <div class="col-sm-10">
                <input type="text" oninput="validSymbol(this.id);" class="form-control" id="user_Nickname"
                    name="user_Nickname" placeholder="Nickname" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" oninput="validSymbol(this.id);" class="form-control" id="user_Email"
                    name="user_Email" placeholder="Email" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Password" oninput="validSymbol(this.id);" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="user_Password" name="user_Password"
                    placeholder="Password" required>
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
                    name="user_Phone" placeholder="10-Digits Phone Number (Optional)">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="user_Location" class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-10">
                <input type="text" oninput="validSymbol(this.id);" class="form-control" id="user_Location"
                    name="user_Location" placeholder="Location (Optional)">
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end gap-3">
            <button type="button" class="btn btn-secondary w-25" onclick="cancel()">Cancel</button>
            <button type="submit" name="create" class="btn btn-success w-25">Create User</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#createForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'CREATE.process.php',
                data: $('#createForm').serialize(),
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
                        alert('Record Created Successfully');
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