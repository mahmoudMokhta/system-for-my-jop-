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
            <div class="">
                <h1 class="text-center mb-4">ملاحظات وحسابات جانبيه</h1>
                <form action="toDoList.php" method="post">
                    <div class=" row">
                        <div class="col-6">
                            <input name="name" type="text" id="taskInput" class="form-control mb-3"
                                placeholder="Add a new task">
                        </div>
                        <div class="col-2">
                            <input name="date" type="date" id="taskInput" class="form-control mb-3">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success" type="submit">اضافه</button>
                        </div>
                    </div>
            </div>
            </form>
            <!-- <div class="d-flex flex-wrap">
                    <?php foreach ($allTasks as $key => $value) : ?>
                    <div class=" m-2">
                        <div class="card" style="width: 16rem;">
                            <div class="card-body">
                                <p class="card-text"><?= $value['name'] ?></p>
                                <a href="toDoList.php?id=<?= $value['id'] ?>" class="btn btn-danger">delete</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div> -->
            <table class="table table-bordered text-light">
                <thead>
                    <tr>
                        <th scope="col">N</th>
                        <th scope="col">تاريخ</th>
                        <th scope="col">الوصف</th>
                        <th scope="col">تفاعل</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allTasks as $key => $value) : ?>
                    <tr>
                        <td>
                            <?= $key + 1 ?>
                        </td>
                        <td>
                            <?= $value['date'] ?>
                        </td>
                        <td>
                            <?= $value['name'] ?>
                        </td>
                        <td>
                            <a class="btn btn-outline-danger" href="toDoList.php?id=<?= $value['id'] ?>">مسح</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
        </div>
    </div>
    </div>
</body>

</html>