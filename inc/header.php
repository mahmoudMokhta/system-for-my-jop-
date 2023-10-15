<?php session_start() ; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"> <span class="" id="result"></span></a>
            <a class="navbar-brand h4" href="#">
                <th id="result" scope="col"></th>
            </a>

            <div class=" navbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="toDoList.php">ملاحظات</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="products.php">المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="expensesMonthly.php">مدفوعات للتجار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="expenses.php">مصروفات اليوميه</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">الصفحه الرئيسيه</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>