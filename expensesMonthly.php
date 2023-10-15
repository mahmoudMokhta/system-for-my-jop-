<?php
// ob_start();
include_once "inc/header.php";
include_once "inc/db.php";



if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $updated_at = $_POST['updated_at'];


    if ($_POST['a_action'] == 'add') {
    
        unset($_POST['a_action']) ;
        $DB->insert('expensesMonthly', $_POST);
    } elseif ($_POST['a_action'] == 'edit') {
        $id = $_POST['a_id'];
        unset($_POST['a_action']) ;
            $DB->update('expensesMonthly', $_POST, $id);
    
    }
    header("Location: expensesMonthly.php");
}

$data = $DB->selectAll('expensesMonthly');

  if (isset($_GET['a_del_id'])) {
    $id = $_GET['a_del_id']; 
    $DB->delete('expensesMonthly',$id );

    header("Location: expensesMonthly.php");
}

if (isset($_GET['a_edit_id'])) {
    $id = $_GET['a_edit_id']; 
    $dataOne = $DB->selectOne('expensesMonthly', 'id', $id);
        $dataOne = $dataOne[0];
}
?>
<body>
    <div class="container">

        <form action="expensesMonthly.php" method="POST" class="my-3 card p-4 costum-bg">
            <?php if (isset($_GET['a_edit_id'])): ?>
                <input type="hidden" name="a_action" value="edit">
                <input type="hidden" name="a_id" value="<?= $_GET['a_edit_id'] ?>">
            <?php else: ?>
                <input type="hidden" name="a_action" value="add">
            <?php endif; ?>
            <div class="row mb-4 ">

                <div class="col">
                    <div class="form-outline">
                        <label class="form-label" for="form3Example1">اسم المصروف</label>
                        <input name="name" type="text" id="form3Example1" class="form-control"value="<?= isset($dataOne) ? $dataOne['name'] : '' ?>" />
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <label class="form-label" for="form3Example2">منصرف</label>
                        <input name="price" type="number" id="form3Example2" class="form-control"value="<?= isset($dataOne) ? $dataOne['price'] : '' ?>" />
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <label class="form-label" for="form3Example2">التاريخ</label>
                        <input name="updated_at" type="date" id="form3Example2" class="form-control" value="<?= isset($dataOne) ? $dataOne['updated_at'] : '' ?>"/>
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-outline-dark btn-block mb-4 bold">تسجيل</button>


        </form>
    </div>
    <div class="container mt-5">
        <h1 class="text-center">جدول المصروفات الشهريه</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">N</th>
                    <th scope="col">التاريخ</th>
                    <th scope="col-3">اسم المصروف</th>
                    <th scope="col">المنصرف</th>
                    <th scope="col">تفاعل</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $totlePrice = 0;


                foreach ($data as $key => $item):

                    $totlePrice += $item['price']
                        ?>
                    <tr>
                        <td>
                            <?= $key + 1 ?>
                        </td>
                        <td>
                            <?= $item['updated_at'] ?>
                        </td>
                        <td>
                            <?= $item['name'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['price'] ?>
                        </td>
                        <td>
                            <a class="btn btn-outline-danger" href="expensesMonthly.php?a_del_id=<?= $item['id'] ?>">مسح</a>
                            <a class="btn btn-outline-success" href="expensesMonthly.php?a_edit_id=<?= $item['id'] ?>">تعديل</a>

                        </td>
                    </tr>
                <?php endforeach;

                $_SESSION['totleexpensesMonthly'] = $totlePrice;
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">المجموع</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">
                        <?= $totlePrice ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    <hr>
<!-- <div id="result"></div> -->


    <?php include_once "inc/footer.php" ?>