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
$totalPages = $database->pagination('user_id', 10, 'userdata');
?>

<ul class="pagination justify-content-center p-3">
    <?php if ($page > 1): ?>
        <li class="page-item">
            <a class="page-link" href="?page=1<?php if (isset($_GET['search'])) {
                echo '&search=' . $searchq;
            } ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;&laquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?page=<?= ($page - 1) ?><?php if (isset($_GET['search'])) {
                    echo '&search=' . $searchq;
                } ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item"><a class="page-link <?= ($i === $page) ? "active" : "" ?>" href="?page=<?= $i ?><?php if (isset($_GET['search'])) {
                      echo '&search=' . $searchq;
                  } ?>"><?= $i ?></a>
        </li>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <li class="page-item">
            <a class="page-link" href="?page=<?= ($page + 1) ?><?php if (isset($_GET['search'])) {
                    echo '&search=' . $searchq;
                } ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?page=<?= $totalPages ?><?php if (isset($_GET['search'])) {
                  echo '&search=' . $searchq;
              } ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;&raquo;</span>
            </a>
        </li>
    <?php endif; ?>
</ul>