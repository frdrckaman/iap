<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();
$successMessage = null;
$pageError = null;
$errorMessage = null;
if ($user->isLoggedIn()) {
    if (!$user->data()->power == 1){
        if (Input::exists('post')) {
            if($_GET['id'] == 1){
                if (Input::get('add_department')) {
                    $validate = new validate();
                    $validate = $validate->check($_POST, array(

                    ));
                    if ($validate->passed()) {

                        try {
                            $user->createRecord('department', array(
                                'name' => Input::get('name'),

                            ));
                            $successMessage = 'Department Added Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        $pageError = $validate->errors();
                    }
                }
            }elseif ($_GET['id'] == 2){
                try {
                    if(!$override->get('user', 'username', strtoupper(Input::get('staff_id')))){
                        $user->createRecord('user', array(
                            'username' => strtoupper(Input::get('staff_id')),

                        ));
                        $successMessage = 'Staff Added Successful';
                    }else{
                        $errorMessage = 'Staff Already Existed';
                    }

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }elseif ($_GET['id'] == 3){
                try {
                    $user->createRecord('unit', array(
                            'name' => Input::get('name'),
                        'department_id' => Input::get('department_id'),

                    ));
                    $successMessage = 'Unit Added Successful';


                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }elseif ($_GET['id'] == 4){
                try {
                    if(!$override->get3('managers', 'staff_id', Input::get('staff_id'), 'department_id', Input::get('department_id'), 'unit_id', Input::get('unit_id'))){
                        $user->createRecord('managers', array(
                            'staff_id' => Input::get('staff_id'),
                            'department_id' => Input::get('department_id'),
                            'unit_id' => Input::get('unit_id'),
                        ));
                        $successMessage = 'Manager Added Successful';
                    }else{
                        $errorMessage = 'Manager Already Existed';
                    }

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }elseif ($_GET['id'] == 5){
                try {
                    if(!$override->get3('champion', 'staff_id', Input::get('staff_id'), 'department_id', Input::get('department_id'), 'unit_id', Input::get('unit_id'))){
                        $user->createRecord('champion', array(
                            'staff_id' => Input::get('staff_id'),
                            'department_id' => Input::get('department_id'),
                            'unit_id' => Input::get('unit_id'),
                        ));
                        $successMessage = 'Coupa Champion Added Successful';
                    }else{
                        $errorMessage = 'Coupa Champion Already Existed';
                    }

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }elseif ($_GET['id'] == 6){

            }elseif ($_GET['id'] == 7){

            }elseif ($_GET['id'] == 8){

            }elseif ($_GET['id'] == 9){

            }elseif ($_GET['id'] == 10){

            }elseif ($_GET['id'] == 11){

            }elseif ($_GET['id'] == 12){

            }elseif ($_GET['id'] == 2){

            }elseif ($_GET['id'] == 2){

            }elseif ($_GET['id'] == 2){

            }
        }
    }else {
        Redirect::to('dashboard.php');
    }
} else {
    Redirect::to('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!--[if gt IE 8]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->

    <title> INFRASTRUCTURE PORTAL </title>

    <?php include 'head.php'?>
</head>
<body>
<div class="wrapper">

    <?php include 'header.php'?>

    <?php include 'menu.php'?>



    <div class="content">


        <div class="breadLine">

            <ul class="breadcrumb">
                <li><a href="#">Simple Admin</a> <span class="divider">></span></li>
                <li class="active">Dashboard</li>
            </ul>

            <ul class="buttons">
                <li>
                    <a href="#" class="link_bcPopupList"><span class="glyphicon glyphicon-user"></span><span class="text">Users list</span></a>

                    <div id="bcPopupList" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-users"></span>
                            <span class="name">List users</span>
                        </div>
                        <div class="body-fluid users">

                            <div class="item clearfix">
                                <div class="image"><a href="#"><img src="img/users/aqvatarius_s.jpg" width="32"/></a></div>
                                <div class="info">
                                    <a href="#" class="name">admin</a>
                                    <span>online</span>
                                </div>
                            </div>

                        </div>
                        <div class="footer">
                            <button class="btn btn-default" type="button">Add new</button>
                            <button class="btn btn-danger link_bcPopupList" type="button">Close</button>
                        </div>
                    </div>

                </li>
                <li>
                    <a href="#" class="link_bcPopupSearch"><span class="glyphicon glyphicon-search"></span><span class="text">Search</span></a>

                    <div id="bcPopupSearch" class="popup">
                        <div class="head clearfix">
                            <div class="arrow"></div>
                            <span class="isw-zoom"></span>
                            <span class="name">Search</span>
                        </div>
                        <div class="body search">
                            <input type="text" placeholder="Some text for search..." name="search"/>
                        </div>
                        <div class="footer">
                            <button class="btn btn-default" type="button">Search</button>
                            <button class="btn btn-danger link_bcPopupSearch" type="button">Close</button>
                        </div>
                    </div>
                </li>
            </ul>

        </div>

        <div class="workplace">

            <div class="row">
                <?php if($errorMessage){?>
                    <div class="alert alert-danger">
                        <h4>Error!</h4>
                        <?=$errorMessage?>
                    </div>
                <?php }elseif($pageError){?>
                    <div class="alert alert-danger">
                        <h4>Error!</h4>
                        <?php foreach($pageError as $error){echo $error.' , ';}?>
                    </div>
                <?php }elseif($successMessage){?>
                    <div class="alert alert-success">
                        <h4>Success!</h4>
                        <?=$successMessage?>
                    </div>
                <?php }?>
                <?php if($_GET['id'] == 1){?>
                    <div class="col-md-offset-1 col-md-8">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Add Department</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Name:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="text" name="name" id="name" />
                                    </div>
                                </div>

                                <div class="footer tar">
                                    <input type="submit" name="add_department" value="Submit" class="btn btn-default">
                                </div>

                            </form>
                        </div>

                    </div>
                <?php }elseif ($_GET['id'] == 2){?>
                    <div class="col-md-offset-1 col-md-8">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Add Staff</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">STAFF ID:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="text" name="staff_id" id="staff_id" />
                                    </div>
                                </div>

                                <div class="footer tar">
                                    <input type="submit" name="add_staff" value="Submit" class="btn btn-default">
                                </div>

                            </form>
                        </div>

                    </div>
                <?php }elseif ($_GET['id'] == 3){?>
                    <div class="col-md-offset-1 col-md-8">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Add Unit</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Department:</div>
                                    <div class="col-md-9">
                                        <select name="department_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Department...</option>
                                            <?php foreach ($override->getData('department') as $department){?>
                                                <option value="<?=$department['id']?>"><?=$department['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Unit Name:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="text" name="name" id="name" required/>
                                    </div>
                                </div>

                                <div class="footer tar">
                                    <input type="submit" name="add_unit" value="Submit" class="btn btn-default">
                                </div>

                            </form>
                        </div>

                    </div>
                <?php }elseif ($_GET['id'] == 4){?>
                    <div class="col-md-offset-1 col-md-8">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Add Manager</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Department:</div>
                                    <div class="col-md-9">
                                        <select name="department_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Department...</option>
                                            <?php foreach ($override->getData('department') as $department){?>
                                                <option value="<?=$department['id']?>"><?=$department['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Unit:</div>
                                    <div class="col-md-9">
                                        <select name="unit_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Unit...</option>
                                            <?php foreach ($override->getData('unit') as $unit){?>
                                                <option value="<?=$unit['id']?>"><?=$unit['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Staff ID:</div>
                                    <div class="col-md-9">
                                        <select name="staff_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Staff ID...</option>
                                            <?php foreach ($override->getData('user') as $staff){?>
                                                <option value="<?=$staff['id']?>"><?=$staff['username']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="footer tar">
                                    <input type="submit" name="add_manager" value="Submit" class="btn btn-default">
                                </div>

                            </form>
                        </div>

                    </div>
                <?php }elseif ($_GET['id'] == 5){?>
                    <div class="col-md-offset-1 col-md-8">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Add Champion</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Department:</div>
                                    <div class="col-md-9">
                                        <select name="department_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Department...</option>
                                            <?php foreach ($override->getData('department') as $department){?>
                                                <option value="<?=$department['id']?>"><?=$department['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Unit:</div>
                                    <div class="col-md-9">
                                        <select name="unit_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Unit...</option>
                                            <?php foreach ($override->getData('unit') as $unit){?>
                                                <option value="<?=$unit['id']?>"><?=$unit['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Staff ID:</div>
                                    <div class="col-md-9">
                                        <select name="staff_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Staff ID...</option>
                                            <?php foreach ($override->getData('user') as $staff){?>
                                                <option value="<?=$staff['id']?>"><?=$staff['username']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="footer tar">
                                    <input type="submit" name="add_manager" value="Submit" class="btn btn-default">
                                </div>

                            </form>
                        </div>

                    </div>
                <?php }elseif ($_GET['id'] == 6){?>

                <?php }elseif ($_GET['id'] == 7){?>

                <?php }elseif ($_GET['id'] == 8){?>

                <?php }elseif ($_GET['id'] == 9){?>

                <?php }elseif ($_GET['id'] == 10){?>

                <?php }elseif ($_GET['id'] == 11){?>

                <?php }elseif ($_GET['id'] == 12){?>

                <?php }?>

                <div class="dr"><span></span></div>

            </div>

        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>
