<?php
include_once "config/database.php";

// Get menu list
$manuFacture = new Manufacture();
$manuFactures = $manuFacture->getAllManu();

// Get protype list
$protype = new Protype();
$protypes = $protype->getAllProtypes();



$productDetail;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $product = new Product();
    $productDetail = $product->getProductById($id);
}


if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['manu_id']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['feature']) && isset($_POST['type_id'])) {
    $product = new Product();
    $idEdit = $_POST["id"];
    $name = $_POST["name"];
    $menu_id = $_POST["manu_id"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $feature = $_POST["feature"];
    $type_id = $_POST["type_id"];


    if ($_FILES['fileUpload']['size'] > 0) {
        var_dump($_POST['fileUpload']);
        $target_dir = "images/";
        $filename = time() . basename($_FILES['fileUpload']['name']);
        $target_file = $target_dir . $filename;
        $upload_ok = true;

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file exists
        if (file_exists($target_file)) {
            $upload_ok = false;
        }

        // Check file size
        if ($_FILES["fileUpload"]["size"] > 5000000) {
            $upload_ok = false;
        }

        // Allow certain file formats
        if (
            $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
            && $file_type != "gif"
        ) {
            $upload_ok = false;
        }


        if ($upload_ok) {
            $upload_done = false;
            if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                $upload_done = true;
            }

            if ($upload_done) {
                if ($product->editProduct($idEdit, $name, $menu_id, $type_id, $price, $filename, $description, $feature)) {
                    header("location: ./index.php");
                } else {
                    echo "Error Edit";
                }
            }
        } else {
            echo "Error";
        }
    } else {
        $currentProduct = $product->getProductById($idEdit);
        $filename = $currentProduct["pro_image"];

        if ($product->editProduct($idEdit, $name, $menu_id, $type_id, $price, $filename, $description, $feature)) {
            header("location: ./index.php");
        } else {
            echo "Error";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mobile Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./images/logo.png" type="image/icon type">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/uniform.css" />
    <link rel="stylesheet" href="css/select2.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-media.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
        ul.pagination {
            list-style: none;
            float: right;
        }

        ul.pagination li.active {
            font-weight: bold
        }

        ul.pagination li {
            display: flex;
            padding: 10px
        }
    </style>
</head>

<body>
    <!--Header-part-->
    <div id="header">
        <h1><a href="#"><img src="./images/logo.png" alt=""></a></h1>
    </div>
    <!--close-Header-part-->
    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li class="dropdown" id="profile-messages"><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i> <span class="text">Welcome Super Admin</span><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.html"><i class="icon-key"></i> Log
                            Out</a></li>
                </ul>
            </li>
            <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i>
                    <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
                    <li class="divider"></li>
                    <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
                </ul>
            </li>
            <li class=""><a title="" href="#"><i class="icon icon-cog"></i>
                    <span class="text">Settings</span></a></li>
            <li class=""><a title="" href="#"><i class="icon
                            icon-share-alt"></i> <span class="text">Logout</span></a>
            </li>
        </ul>
    </div>
    <!--start-top-serch-->
    <div id="search">
        <form action="result.html" method="get">
            <input type="text" placeholder="Search here..." />
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </form>
    </div>
    <!--close-top-serch-->
    <!--sidebar-menu-->
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon
                    icon-th"></i>Tables</a>
        <ul>
            <li><a href="index.html"><i class="icon icon-home"></i> <span>Dashboard</span></a>
            </li>
            <li> <a href="manufactures.html"><i class="icon icon-th-list"></i>
                    <span>Manufactures</span></a></li>
            <li> <a href="protypes.html"><i class="icon icon-th-list"></i>
                    <span>Product type</span></a></li>
            <li> <a href="users.html"><i class="icon icon-th-list"></i>
                    <span>Users</span></a></li>

        </ul>
    </div><!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i>
                    Home</a></div>
            <h1>Add New Product</h1>
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Product info</h5>
                        </div>
                        <div class="widget-content nopadding">

                            <!-- BEGIN USER FORM -->
                            <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= isset($productDetail) ? $productDetail["id"] : "" ?>" />

                                <div class="control-group">
                                    <label class="control-label">Name :</label>
                                    <div class="controls">
                                        <input type="text" class="span11" placeholder="Product name" name="name" value="<?= isset($productDetail) ? $productDetail["name"] : "" ?>" /> *
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Choose a
                                        manufacture:</label>
                                    <div class="controls">
                                        <select name="manu_id" id="cate">
                                            <?php
                                            foreach ($manuFactures as $key => $manu) {
                                            ?>
                                                <option value="<?= $manu["manu_id"] ?>" selected="<?= isset($productDetail) && $productDetail["manu_id"] == $protypeItem["manu_id"] ? "selected" : "" ?>">
                                                    <?= $manu["manu_name"] ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select> *
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Choose a
                                        product type:</label>
                                    <div class="controls">
                                        <select name="type_id" id="subcate">
                                            <?php
                                            foreach ($protypes as $key => $protypeItem) {
                                            ?>
                                                <option value="<?= $protypeItem["type_id"] ?>" selected="<?= isset($productDetail) && $productDetail["type_id"] == $protypeItem["type_id"] ? "selected" : "" ?>">
                                                    <?= $protypeItem["type_name"] ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select> *
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Choose
                                            an image :</label>
                                        <div class="controls">
                                            <input type="file" name="fileUpload" id="fileUpload">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Description</label>
                                        <div class="controls">
                                            <textarea class="span11" placeholder="Description" name="description"><?= isset($productDetail) ? $productDetail["description"] : "" ?></textarea>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Price
                                                :</label>
                                            <div class="controls">
                                                <input type="text" class="span11" placeholder="price" name="price" value="<?= isset($productDetail) ? $productDetail["price"] : "" ?>" /> *
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Feature
                                                :</label>
                                            <div class="controls">
                                                <input type="number" class="span11" name="feature" value="<?= isset($productDetail) ? $productDetail["feature"] : "" ?>" /> *
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn
                                                    btn-success">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END USER FORM -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <!--Footer-part-->
    <div class="row-fluid">
        <div id="footer" class="span12"> 2017 &copy; TDC - Lập trình web 1</div>
    </div>
    <!--end-Footer-part-->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.ui.custom.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.uniform.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/matrix.js"></script>
    <script src="js/matrix.tables.js"></script>
</body>

</html>