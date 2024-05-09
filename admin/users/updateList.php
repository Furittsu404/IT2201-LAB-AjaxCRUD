<?php
session_start();
$_SESSION['site'] = 'users';
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../login");
}

$connection = new Connection();
$database = new adminAction($connection->connect());

$page = $_SESSION['page'];
$offset = ($page - 1) * 10;
$result = $database->showRecords('userdata', "LIMIT $offset, 10");
$result2 = $database->showRecords('userlogin', "LIMIT $offset, 10");
?>

<?php
$user_count = 0;
for ($i = 1; $i < $page; $i++) {
    $user_count += 10;
}
if (count($result) > 0) {
    for ($i = 0; $i < count($result); $i++) {
        if ($result[0][0]) {
            echo '<tr class=' . "'expandable'" . '>';
            echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"user' . ++$user_count . '");' . "'>" . $user_count . "</td>";
            echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"user' . $user_count . '");' . "'>" . $result[$i][0] . "</td>";
            echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"user' . $user_count . '");' . "'>" . $result[$i][2] . "</td>";
            echo "<td><button data-id='" . $result[$i][0] . "' class='edit w-40'><span class='action-word'>Edit</span><i class='bi bi-pencil action-btn'></i></button> <button data-id='" . $result[$i][0] . "' class='delete w-40'><span class='action-word'>Delete</span><i class='bi bi-trash action-btn'></i></button></td>";
            echo "</tr>";
            echo "<tr id='user" . $user_count . "' class='hidden'>";
            echo "<td colspan='5'><strong>Email:&nbsp;&nbsp;</strong>" . $result2[$i][1] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Nickname:&nbsp;&nbsp;</strong>" . $result[$i][1] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Phone Number:&nbsp;&nbsp;</strong>" . $result[$i][3] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Location:&nbsp;&nbsp;</strong>" . $result[$i][4] . "</td>";
            echo "</tr>";
        }
    }
}
?>

<script>
    $(document).ready(function () {
        $('.edit').on('click', function (e) {
            e.preventDefault();
            let user_ID = $(this).data('id');
            $.ajax({
                url: 'EDIT.modal.php',
                type: 'POST',
                data: { user_ID: user_ID },
                success: function (response) {
                    $('#actionModal').html(response);
                }
            });
        });
    });
    $(document).ready(function () {
        $('.delete').on('click', function (e) {
            e.preventDefault();
            let user_ID = $(this).data('id');
            $.ajax({
                url: 'DELETE.modal.php',
                type: 'POST',
                data: { user_ID: user_ID },
                success: function (response) {
                    $('#actionModal').html(response);
                }
            });
        });
    });
</script>