<?php
$users = getUsers();
?>
<div class="container">
    <h1>Connection</h1>
    <form action="functions/login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit">Log In</button>
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <div class="users-list">
        <h3>List of existing Users</h3>
        <ul>
        <?php foreach ($users as $index => $user): ?>
            <li class="user-item">
                <p><?= $user ?></p>
                <form action="functions/delete_user.php" method="post">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit" class="delete-button small"> Delete User</button>
                </form>
            </li>
        <?php endforeach; ?>            
        </ul>
    </div>
</div>