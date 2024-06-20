<?php

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = $_POST['index'];
    $todos = getTodos();
    $categories = getCategories();
    $todo = $todos[$index];
}
?>
    <div class="container">
        <h1>Edit Task</h1>
        <form action="functions/edit.php" method="post">
            <div class="row">
                <div class="column">
                    <label for="task">Add Task</label>
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <input type="text" name="task" value="<?= htmlspecialchars($todo['task']) ?>" required> 
                </div>
                <div class="column">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" value="<?= htmlspecialchars($todo['due_date']) ?>" required>
                </div>
                <div class="column">
                    <label for="category">Category</label>
                    <select name="category" id="category" required>
                        <option value="" disabled selected>-- Choose a category --</option>
                        <option value="sport" <?= $todo['category'] == 'sport' ? 'selected' : '' ?>>Sport</option>
                        <option value="work" <?= $todo['category'] == 'work' ? 'selected' : '' ?>>Work</option>
                        <option value="appointment" <?= $todo['category'] == 'appointment' ? 'selected' : '' ?>>Appointment</option>
                        <option value="tobuy" <?= $todo['category'] == 'tobuy' ? 'selected' : '' ?>>To Buy</option>
                        <option value="other" <?= $todo['category'] == 'other' ? 'selected' : '' ?>>Other</option>
                        <?php if(count($categories) > 0):?>
                        <?php foreach ($categories as $category): ?>
                            <option value='<?=$category?>' <?= $filter == $category ? 'selected' : '' ?>><?= $category?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <button type="submit">Update</button>
            <a href="index.php" class="button">Back</a>
        </form>
    </div>
