<?php
$histories = getTodos('history');
?>
    <div class="container">
        <h1>History</h1>
        <a href="index.php" class="button">Back</a>
        <div class="row">
            <ul>
            <?php foreach ($histories as $index => $history): ?>
                <?php if($history['username'] == $_SESSION['username']):?>
                    <li>
                        <div class="row">
                            <div class="column">
                                <p class="categ"><?= $history['category'] ?></p>
                            </div> 
                        </div>
                        <div class="row task-content">
                            <div class="row">
                                <div class="column">
                                    <p><?= htmlspecialchars($history['task']) ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="column">
                                    <?php
                                    // formater date pour pouvoir la comparer avec la date du jour
                                    $due_date = strtotime($history['due_date']);
                                    // obtenir la date actuelle
                                    $current_date = time();
                                    // Comparer les dates
                                    $date_class = $due_date <= $current_date ? 'red' : 'green';
                                    ?>
                                    <p class="<?= $date_class?>"><?= htmlspecialchars(date('d-m-Y', strtotime($history['due_date']))) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column">
                                <form action="functions/restore.php" method="post">
                                    <input type="hidden" name="task" value="<?= $history['task'] ?>">
                                    <input type="hidden" name="due_date" value="<?= $history['due_date'] ?>">
                                    <input type="hidden" name="category" value="<?= $history['category'] ?>">
                                    <input type="hidden" name="completed" value="<?= $history['completed'] ?>">
                                    <input type="hidden" name="user" value="<?= $history['user'] ?>">
                                    <button type="submit" class="small">Restore</button>
                                </form>
                            </div>
                            <div class="column">
                                <form action="functions/delete_history.php" method="post" style="display:inline;">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="delete-button small">Delete definitly</button>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
