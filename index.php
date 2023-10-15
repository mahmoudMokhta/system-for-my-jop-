    <?php
    // ob_start();
    include_once "inc/header.php";
    include_once "inc/db.php";
    $totalCountArr = [];
    $totlePriceArr = [];
    $totleArba7Arr = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
        $pro_id = $_POST['pro_id'];
        $count = $_POST['count'];
        $price = $_POST['price'];
        $updated_at = $_POST['updated_at'];



        if ($_POST['action'] == 'add') {

            unset($_POST['action']);
            $DB->insert('sales_pro', $_POST);
        } elseif ($_POST['action'] == 'edit') {
            $id = $_POST['id'];

            unset($_POST['action']);
            $DB->update('sales_pro', $_POST, $id);
        }
        header("Location: index.php");
    }
    $allproducts = $DB->selectAll('products');

    if (isset($_GET['del_id'])) {
        $id = $_GET['del_id'];

        $DB->delete('sales_pro', $id);

        header("Location: index.php");
    }
    if (isset($_GET['edit_id'])) {
        $id = $_GET['edit_id'];

        $dataOne = $DB->selectOne('sales_pro', 'id', $id);
        $dataOne = $dataOne[0];
    }

    ?>

    <body>

        <div class="container">

            <form action="index.php" method="POST" class="my-3 card p-4 costum-bg">
                <?php if (isset($_GET['edit_id'])) : ?>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?= $_GET['edit_id'] ?>">
                <?php else : ?>
                <input type="hidden" name="action" value="add">
                <?php endif; ?>


                <div class="row mb-4 ">
                    <div class="col-12 mb-4">
                        <select name="pro_id" class="form-control">
                            <?php foreach ($allproducts as  $product) : ?>
                            <option value="<?= $product['id'] ?>"> <?= $product['name'] ?></option>
                            <?php endforeach; ?>

                        </select>


                    </div>
                    <div class="col-4">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example1">عدد القطع</label>
                            <input name="count" type="number" id="form3Example1" class="form-control"
                                value="<?= isset($dataOne) ? $dataOne['count'] : '' ?>" /> <!-- قم بتحديث هذا الحقل -->
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example2">سعر البيع</label>
                            <input name="price" type="number" id="form3Example2" class="form-control"
                                value="<?= isset($dataOne) ? $dataOne['price'] : '' ?>" /> <!-- قم بتحديث هذا الحقل -->
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-outline">
                            <label class="form-label" for="form3Example2">التاريخ</label>
                            <input name="updated_at" type="date" id="form3Example2" class="form-control"
                                value="<?= isset($dataOne) ? $dataOne['updated_at'] : '' ?>" />
                            <!-- قم بتحديث هذا الحقل -->
                        </div>
                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn btn-outline-dark btn-block mb-4 bold">تسجيل</button>
            </form>
        </div>
        <div class="container mt-5">
            <?php foreach ($allproducts as $i => $product) :

                $sales_pro = $DB->selectOne('sales_pro', 'pro_id', $product['id']);
            ?>
            <h2 class='text-center my-5 text-success'>جدول المبيعات <?= $product['name'] ?></h2>
            <table class='table table-bordered my-4'>
                <thead>
                    <tr>
                        <th scope='col'>N</th>
                        <th scope='col'>التاريخ</th>
                        <th scope='col'>عدد القطع</th>
                        <th scope='col'>سعر البيع</th>
                        <th scope='col'>تمن القطعه فالبيع</th>
                        <th scope='col'> الارباح</th>
                        <th scope='col'> تفاعل</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalCount = 0;
                        $totlePrice = 0;
                        $totleArba7 = 0;

                        foreach ($sales_pro as $key => $item) :
                            $totalCount += $item['count'];
                            $totlePrice += $item['price'];
                            $arba7 = $item['price'] - ($product['price'] * $item['count']);
                            $totleArba7 += $arba7;
                            // echo $product['price']  . '<br>';
                        ?>

                    <tr>
                        <td>
                            <?= 1 ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['updated_at'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['count'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['price'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $item['price'] / $item['count'] ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= $arba7 ?>
                        </td>
                        <td>
                            <a class="btn btn-outline-danger" href="index.php?del_id=<?= $item['id'] ?>">مسح</a>
                            <a class="btn btn-outline-success" href="index.php?edit_id=<?= $item['id'] ?>">تعديل</a>

                        </td>
                    </tr>
                    <?php endforeach;
                        $totalCountArr[] = $totalCount;
                        $totlePriceArr[] = $totlePrice;
                        $totleArba7Arr[] = $totleArba7;
                        ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">المجموع</th>
                        <th scope="col"></th>
                        <th onclick="highlightCell(this)" scope="col">
                            <?= $totalCount ?>
                        </th>
                        <th onclick="highlightCell(this)" scope="col">
                            <?= $totlePrice ?>
                        </th>
                        <th scope="col"></th>
                        <th onclick="highlightCell(this)" scope="col">
                            <?= $totleArba7 ?>
                        </th>
                        <!-- <th id="result" scope="col"></th> -->
                    </tr>
                </tfoot>
            </table>
            <?php endforeach;
            ?>
            <hr>
            <hr>

            <div class="my-5">
                <h2 class="text-center">جدول عدد القطع</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">اسم المنتج</th>
                            <th scope="col">عدد القطع الاساسيه</th>
                            <th scope="col">عدد القطع المباعه</th>
                            <th scope="col">عدد القطع المخزن</th>
                            <th scope="col">سعر القطع فالمخزن</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $priceAllProductsInStore = 0;
                        foreach ($allproducts as $i => $product) :
                            $priceAllProductsInStore += (($product['count'] - $totalCountArr[$i]) * $product['price']);
                        ?>
                        <tr>
                            <td><?= $product['name']  ?></td>
                            <td onclick="highlightCell(this)"><?= $product['count'] ?></td>
                            <td onclick="highlightCell(this)"> <?= $totalCountArr[$i]  ?></td>
                            <td onclick="highlightCell(this)"> <?= $product['count'] - $totalCountArr[$i]  ?></td>
                            <td onclick="highlightCell(this)">
                                <?= ($product['count'] - $totalCountArr[$i]) * $product['price']  ?></td>


                        </tr>
                        <?php endforeach;
                        $allTotalprice = array_sum($totlePriceArr);
                        $totleArba7 = array_sum($totleArba7Arr)
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="my-5 container">
            <h2 class="text-center">جدول الخلاصه</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">اجمالي سعر بضاعه المخزن</th>
                        <th scope="col">اجمالي المبيعات</th>
                        <th scope="col">اجمالي المصروفات اليوميه</th>
                        <th scope="col">مدفوعات للتجار</th>
                        <th scope="col">الخزنه</th>
                        <th scope="col">صافي الارباح</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td onclick="highlightCell(this)"><?= $priceAllProductsInStore ?></td>
                        <td onclick="highlightCell(this)"><?= $allTotalprice ?></td>
                        <td onclick="highlightCell(this)">
                            <?= isset($_SESSION['totleexpense']) ? $_SESSION['totleexpense'] : 0 ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?= isset($_SESSION['totleexpensesMonthly']) ? $_SESSION['totleexpensesMonthly'] : 0 ?>
                        </td>

                        <td onclick="highlightCell(this)">
                            <?= isset($_SESSION['totleexpense']) && isset($_SESSION['totleexpensesMonthly']) ?
                                $allTotalprice - ($_SESSION['totleexpense'] + $_SESSION['totleexpensesMonthly']) : 0 ?>
                        </td>
                        <td onclick="highlightCell(this)">
                            <?=isset($_SESSION['totleexpense']) ? $totleArba7 - $_SESSION['totleexpense'] : "" ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <?php include_once "inc/footer.php" ?>