<aside id="sidebar">
    <div class="d-flex">
        <a href="../" class="toggle-btn">
            <i class="lni lni-grid-alt"></i>
        </a>
        <div class="sidebar-logo">
            <a href="../">Dashboard</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="../users" class="sidebar-link <?= ($_SESSION['site'] === 'users') ? "active-tab" : "" ?>">
                <i class="lni lni-user"></i>
                <span>Users</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="../../db/logout.php" class="sidebar-link">
            <i class="lni lni-exit"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>