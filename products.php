<?php
    // ob_start();
    include_once "inc/header.php";
    include_once "inc/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $name = $_POST['name'];
    $count = $_POST['count'];
    $price = $_POST['price'];

    if ($_POST['action'] == 'add') {
        
        unset($_POST['action']) ;
        $DB->insert('products', $_POST);
    } elseif ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
    
        unset($_POST['action']) ;
        $DB->update('products', $_POST, $id);
    }
    header("Location: products.php");
}
$data = $DB->selectAll('products');
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id']; 

    // $DB->command($DB, "DELETE FROM products WHERE id = $id");
    $DB->delete('products',$id );

    header("Location: products.php");
}
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];

    $dataOne = $DB->selectOne('products', 'id', $id);
    $dataOne = $dataOne[0];
}


        ?>
        <div class="container">
        <form action="products.php" method="POST" class="my-3 card p-4 costum-bg">
                <?php if (isset($_GET['edit_id'])): ?>
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $_GET['edit_id'] ?>">
                <?php else: ?>
                    <input type="hidden" name="action" value="add">
                <?php endif; ?>

                <div class="row mb-4 ">
                
                    <div class="col-4">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1">اسم المنتج</label>
                            <input name="name" type="text" id="form3Example1" class="form-control"
                                value="<?= isset($dataOne) ? $dataOne['name'] : '' ?>" /> 
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1">عدد القطع</label>
                            <input name="count" type="number" id="form3Example1" class="form-control"
                                value="<?= isset($dataOne) ? $dataOne['count'] : '' ?>" /> 
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example2">سعر الشراء</label>
                            <input name="price" type="number" id="form3Example2" class="form-control"
                                value="<?= isset($dataOne) ? $dataOne['price'] : '' ?>" /> 
                        </div>
                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn btn-outline-dark btn-block mb-4 bold">تسجيل</button>
            </form>

            <div class="container mt-5">
        <h1 class="text-center">جدول المنتجات</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">N</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col-3">عدد القطع الاصليه</th>
                    <th scope="col">سعر القطعه </th>
                    <th scope="col">سعر الاجمالي</th>
                    <th scope="col">تفاعل</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $item):?>
                    <tr>
                        <td>
                            <?= $key + 1 ?>
                        </td>
                        <td>
                            <?= $item['name'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['count'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['price'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['price'] * $item['count'] ?>
                        </td>
                        <td>
                            <a class="btn btn-outline-danger" href="products.php?del_id=<?= $item['id'] ?>">مسح</a>
                            <a class="btn btn-outline-success" href="products.php?edit_id=<?= $item['id'] ?>">تعديل</a>

                        </td>
                    </tr>
                <?php endforeach;?>

            </tbody>

        </table>
    </div>

        </div>

        <?php include_once "inc/footer.php" ?>
