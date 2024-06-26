<div class="container">
        <div class="row header">
            <div class="theme-select">
                <form name="themeform" id="themeform" method="post" action="index.php" class="row">
                    <select name="theme" id="theme">
                        <option value="light" <?= $theme == 'light' ? 'selected' : '' ?>>Light</option>
                        <option value="dark" <?= $theme == 'dark' ? 'selected' : '' ?>>Dark</option>
                    </select>
                    <button type="submit" class="small">Ok</button>
                </form>
            </div>
            <div class="title-container">
                <h1 class="title">To Do List</h1>
                <p><b>Connected as User :</b> <?= $_SESSION['username']?></p>
            </div>
            <a href="../functions/logout.php" class="button logout">Logout</a>
        </div>
        <div class="row menu">
            <div class="filter-select">
                <form name="filterform" id="filterform" method="post" action="index.php" class="row">
                        <label for="filter">Filter by category :</label>
                        <select name="filter" id="filter">
                            <option value="all" <?= $filter == 'all' ? 'selected' : '' ?>>All</option>
                            <option value="sport" <?= $filter == 'sport' ? 'selected' : '' ?>>Sport</option>
                            <option value="work" <?= $filter == 'work' ? 'selected' : '' ?>>Work</option>
                            <option value="appointment" <?= $filter == 'appointment' ? 'selected' : '' ?>>Appointment</option>
                            <option value="tobuy" <?= $filter == 'tobuy' ? 'selected' : '' ?>>To Buy</option>
                            <option value="other" <?= $filter == 'other' ? 'selected' : '' ?>>Other</option>
                            <?php if(count($categories) > 0):?>
                            <?php foreach ($categories as $category): ?>
                                <option value='<?=$category?>' <?= $filter == $category ? 'selected' : '' ?>><?= $category?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <button type="submit" class="small">Ok</button>
                </form>
                <a href="index.php?page=add_category" class="button small">Add new category</a>
                <a href="index.php?page=history" class="button small">History</a>
            </div>
        </div>
        <form action="functions/add.php" method="post">
            <div class="row">
                <input type="hidden" name='username'>
                <div class="column">
                    <label for="task">Add Task</label>
                    <input type="text" name="task" placeholder="Something to do" required>
                </div>
                <div class="column">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" required>
                </div>
                <div class="column">
                    <label for="category">Category</label>
                    <select name="category" id="category" required>
                        <option value="" disabled selected>-- Choose a category --</option>
                        <option value="sport">Sport</option>
                        <option value="work">Work</option>
                        <option value="appointment">Appointment</option>
                        <option value="tobuy">To Buy</option>
                        <option value="other">Other</option>
                        <?php if(count($categories) > 0):?>
                        <?php foreach ($categories as $category): ?>
                        <option value='<?=$category?>'><?= $category?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="add-button-container">
                    <button type="submit" class="add-button">Add</button>
                </div>
            </div>
        </form>
        <div class="row clearfix">
            <div class="float-left task-todo">
                <ul>
                    <?php foreach ($existingCategories as $existingCategory):?>
                    <div class="row">
                        <div class="column">
                            <p class="categ"><?= $existingCategory ?></p>
                        </div> 
                    </div>
                    <li>
                    <?php foreach ($todos as $index => $todo): ?>
                    <?php if($todo['username'] == $_SESSION['username']):?>
                    <?php if($todo['completed'] == False and $todo['category'] == $existingCategory) : ?>
                        <div class="row task-content">
                            <div class="row">
                                <div class="column">
                                    <p><?= htmlspecialchars($todo['task']) ?></p>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="column">
                                        <?php
                                        // formater date pour pouvoir la comparer avec la date du jour
                                        $due_date = strtotime($todo['due_date']);
                                        // obtenir la date actuelle
                                        $current_date = time();
                                        // Comparer les dates
                                        $date_class = $due_date <= $current_date ? 'red' : 'green';
                                        ?>
                                        <p class="<?= $date_class?>"><?= htmlspecialchars(date('d-m-Y', strtotime($todo['due_date']))) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="column">
                                    <form action="index.php?page=edit" method="post">
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <button type="submit" class="small">Edit</button>
                                    </form>
                                </div>
                                <div class="column">
                                    <form action="functions/toggle.php" method="post">
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <button type="submit" class="validate-button small"><?= $todo['completed'] ? 'Restore Task' : 'End Task' ?></button>
                                    </form>
                                </div>
                                <div class="column">
                                    <form action="functions/delete.php" method="post" style="display:inline;">
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <button type="submit" class="delete-button small">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php endif;?>
                            <?php endforeach; ?>
                        </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="float-right task-ended">
                <ul>
                <?php foreach ($existingCategories as $existingCategory):?>   
                    <div class="row">
                        <div class="column">
                        <p class="categ"><?= $existingCategory ?></p>
                        </div> 
                    </div>
                    <li>
                        <?php foreach ($todos as $index => $todo): ?>
                        <?php if($todo['username'] == $_SESSION['username']):?>
                        <?php if($todo['completed'] == True and $todo['category'] == $existingCategory):?>
                        <div class="row task-content">
                            <div class="column">
                                <p class="ended"><?= htmlspecialchars($todo['task']) ?></p>
                            </div>
                            <div class="column">
                                <p class="ended"><?= htmlspecialchars(date('d-m-Y', strtotime($todo['due_date'])))?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column">
                                <form action="functions/toggle.php" method="post">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="validate-button small"><?= $todo['completed'] ? 'Restore Task' : 'End Task' ?></button>
                                </form>
                            </div>
                            <div class="column">
                                <form action="functions/delete.php" method="post" style="display:inline;">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="delete-button small">Delete</button>
                                </form>
                            </div>
                        </div>
                        <?php endif;?>
                        <?php endif;?>
                        <?php endforeach; ?>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>