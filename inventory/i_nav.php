<?php
    if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
        header("Location: index.php");
        exit();
    }
    if (!isset($_SESSION['last_active_page'])) {
        $_SESSION['last_active_page'] = 'dashboard.php'; 
    }
?>
<style>
    .nav-link.inactive {
        color: darkgray;
    }
</style>

<div class="container w-50 my-3">
    <h1 class="text-start mt-4">Inventory</h1>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : 'inactive'; ?>" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'accession.php') ? 'active' : 'inactive'; ?>" href="accession.php">Accession</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'transfer.php') ? 'active' : 'inactive'; ?>" href="transfer.php">Transfer</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'history.php') ? 'active' : 'inactive'; ?>" href="history.php">History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'exhibits.php') ? 'active' : 'inactive'; ?>" href="exhibits.php">Exhibits</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'racking.php') ? 'active' : 'inactive'; ?>" href="racking.php">Location</a>
        </li>
    </ul>
</div>
