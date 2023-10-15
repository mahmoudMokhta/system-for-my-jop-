<?php
include_once "inc/db.php";
include_once "inc/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $task = $_POST['name'];
    $DB->insert('tasks', $_POST);
    header("Location: toDoList.php");
}

$allTasks = $DB->selectAll('tasks');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $DB->delete('tasks', $id);

    header("Location: toDoList.php");
}
?>

<body>
    <div class="container mt-5">
        <div class="">
            <div class="" >
                <h1 class="text-center mb-4">ملاحظات وحسابات جانبيه</h1>
                <form action="toDoList.php" method="post" style="width: 30rem;" >
                    <div class="input-group mb-3">
                        <input name="name" type="text" id="taskInput" class="form-control" placeholder="Add a new task">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">اضافه</button>
                        </div>
                    </div>
                </form>
                <div class="d-flex flex-wrap">
                    <?php foreach ($allTasks as $key => $value) : ?>
                        <div class=" m-2" >
                            <div class="card" style="width: 16rem;">
                                <div class="card-body">
                                    <p class="card-text"><?= $value['name'] ?></p>
                                    <a href="toDoList.php?id=<?= $value['id'] ?>" class="btn btn-danger">delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

