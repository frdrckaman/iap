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
                if (Input::get('edit_department')) {
                    $validate = $validate->check($_POST, array(

                    ));
                    if ($validate->passed()) {
                        try {
                            $user->updateRecord('department', array(
                                'name' => Input::get('name'),
                            ), Input::get('id'));
                            $successMessage = 'Department Successful Updated';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        $pageError = $validate->errors();
                    }
                }
            }elseif ($_GET['id'] == 3){
                if (Input::get('add_specs')) {
                    $validate = $validate->check($_POST, array(

                    ));
                    if ($validate->passed()) {
                        try {
                            $user->createRecord('computer_specs', array(
                                'brand' => Input::get('brand'),
                                'processor' => Input::get('processor'),
                                'ram' => Input::get('ram'),
                                'hdd' => Input::get('hdd'),
                                'os' => Input::get('os'),
                                'display' => Input::get('display'),
                                'graphic_card' => Input::get('graphic_card'),
                                'web_cam' => Input::get('web_cam'),
                                'battery' => Input::get('battery'),
                                'keyboard' => Input::get('keyboard'),
                                'wifi' => Input::get('wifi'),
                                'mouse' => Input::get('mouse'),
                                'warranty' => Input::get('warranty'),
                                'other_specs' => Input::get('other_specs'),
                                'specs_date' => date('Y-m-d'),
                                'staff_id' => $user->data()->id,
                                'request_id' => Input::get('id'),

                            ));
                            $user->updateRecord('computer_request', array(
                                'specs_status' => 1,
                            ), Input::get('id'));
                            $successMessage = 'Specs Successful Added';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        $pageError = $validate->errors();
                    }
                }
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
                    <div class="col-md-6">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>List of Department</h1>
                            <ul class="buttons">
                                <li><a href="#" class="isw-download"></a></li>
                                <li><a href="#" class="isw-attachment"></a></li>
                                <li>
                                    <a href="#" class="isw-settings"></a>
                                    <ul class="dd-list">
                                        <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                        <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                        <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                <tr>
                                    <th width="25%">Name</th>
                                    <th width="5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($override->getData('department') as $position) { ?>
                                    <tr>
                                        <td> <?= $position['name'] ?></td>
                                        <td><a href="#position<?= $position['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                        <!-- EOF Bootrstrap modal form -->
                                    </tr>
                                    <div class="modal fade" id="position<?= $position['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Edit Department Info</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="block-fluid">
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Name:</div>
                                                                    <div class="col-md-9"><input type="text" name="name" value="<?= $position['name'] ?>" required /></div>
                                                                </div>
                                                            </div>
                                                            <div class="dr"><span></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?= $position['id'] ?>">
                                                        <input type="submit" name="edit_department" class="btn btn-warning" value="Save updates">
                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }elseif ($_GET['id'] == 2){?>
                    <div class="col-md-12">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Request Status</h1>
                            <ul class="buttons">
                                <li><a href="#" class="isw-download"></a></li>
                                <li><a href="#" class="isw-attachment"></a></li>
                                <li>
                                    <a href="#" class="isw-settings"></a>
                                    <ul class="dd-list">
                                        <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                        <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                        <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall" /></th>
                                    <th width="10%">Employee Name</th>
                                    <th width="5%">Employee ID</th>
                                    <th width="15%">Job title</th>
                                    <th width="10%">Request date</th>
                                    <th width="45%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach($override->get('computer_request','staff_id', $user->data()->id) as $request){?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox" /></td>
                                        <td><?=$request['name']?></td>
                                        <td><?=$request['employee_id']?></td>
                                        <td><?=$request['job_title']?></td>
                                        <td><?=$request['request_date']?></td>
                                        <td>
                                            <a href="#" role="button" class="btn <?php if($request['specs_status']==1){echo 'btn btn-success';$sp='Specs(Done)';}else{echo 'btn btn-warning';$sp='Specs(Wait..)';}?> "><?=$sp?></a>
                                            <a href="#" role="button" class="btn <?php if($request['pmu_status']==1){echo 'btn btn-success';}else{echo 'btn btn-warning';}?> ">PMU</a>
                                            <a href="#" role="button" class="btn <?php if($request['check_status']==1){echo 'btn btn-success';}else{echo 'btn btn-warning';}?> ">Specs Check</a>
                                            <a href="#" role="button" class="btn <?php if($request['receive_status']==1){echo 'btn btn-success';}else{echo 'btn btn-warning';}?> ">Receive Confirmation</a>


                                        </td>
                                        <td>
                                            <a href="#view<?=$request['id']?>" role="button" class="btn btn-default" data-toggle="modal">View</a>

                                        </td>
                                    </tr>
                                    <div class="modal fade" id="view<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>View Request</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="block-fluid">
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Requester Name:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="<?=$request['requester_name']?>" type="text" name="requester_name" id="requester_name" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Requester ID:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="<?=$request['requester_id']?>" type="text" name="requester_id" id="requester_id" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Department</div>
                                                                    <div class="col-md-9">
                                                                        <select name="department" style="width: 100%;" required>
                                                                            <option value=""><?=$request['department']?></option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Unit</div>
                                                                    <div class="col-md-9">
                                                                        <select name="unit" style="width: 100%;" required>
                                                                            <option value=""><?=$request['unit']?></option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Visitor Name:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="<?=$request['visitor_name']?>" type="text" name="visitor_name" id="visitor_name" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Visitor Organisation:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="<?=$request['visitor_org']?>" type="text" name="visitor_org" id="visitor_org" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Visitor Phone Number:</div>
                                                                    <div class="col-md-9"><input value="<?=$request['visitor_phone']?>" class="" type="text" name="visitor_phone" id="phone" required disabled/> <span>Example: 0700 000 111</span></div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Visitor Email Address:</div>
                                                                    <div class="col-md-9"><input value="<?=$request['visitor_email']?>" class="validate[required,custom[email]]" type="text" name="visitor_email" id="email" disabled/> <span>Example: someone@nowhere.com</span></div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Visitor Address:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="<?=$request['visitor_address']?>" class="validate[required]" type="text" name="visitor_address" id="visitor_address" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Start Date:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="<?=$request['start_date']?>" class="validate[required,custom[date]]" type="text" name="start_date" id="start_date" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Start Time:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="<?=$request['start_time']?>" class="validate[required]" type="text" name="start_time" id="start_time" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">End Date:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="<?=$request['end_date']?>" class="validate[required,custom[date]]" type="text" name="end_date" id="end_date" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">End Time:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="<?=$request['end_time']?>" class="validate[required]" type="text" name="end_time" id="end_time" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Reasons:</div>
                                                                    <div class="col-md-9">
                                                                        <textarea name="textarea" placeholder="Reason for visit..." disabled><?=$request['textarea']?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="dr"><span></span></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" value="">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="approve<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Approve Request</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to approve this request</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$request['id']?>">
                                                        <input type="submit" name="approve_request" value="Approve" class="btn btn-success">
                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="decline<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Approve Decline</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <strong style="font-weight: bold;color: red">
                                                            <p>Are you sure you want to decline this request</p>
                                                        </strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$request['id']?>">
                                                        <input type="submit" name="decline_request" value="Decline" class="btn btn-danger">
                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }elseif ($_GET['id'] == 3){?>
                    <div class="col-md-12">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Request Status</h1>
                            <ul class="buttons">
                                <li><a href="#" class="isw-download"></a></li>
                                <li><a href="#" class="isw-attachment"></a></li>
                                <li>
                                    <a href="#" class="isw-settings"></a>
                                    <ul class="dd-list">
                                        <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                        <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                        <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall" /></th>
                                    <th width="10%">Employee Name</th>
                                    <th width="10%">Employee ID</th>
                                    <th width="15%">Job title</th>
                                    <th width="10%">request date</th>
                                    <th width="30%">Comments</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach($override->get('computer_request','staff_id', $user->data()->id) as $request){
                                    $checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
                                    if($checkSpecs){$specs=$checkSpecs[0];}?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox" /></td>
                                        <td><?=$request['name']?></td>
                                        <td><?=$request['employee_id']?></td>
                                        <td><?=$request['job_title']?></td>
                                        <td><?=$request['request_date']?></td>
                                        <td><?=$request['comments']?></td>
                                        <td>
                                            <a href="#specs<?=$request['id']?>" role="button" class="btn btn-info" data-toggle="modal">Add Specs</a>
                                            <a href="#specsCheck<?=$request['id']?>" role="button" class="btn btn-info" data-toggle="modal">Specs Check</a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="specs<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>View Request</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="block-fluid">
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Brand:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="" type="text" name="brand" id="brand" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">PROCESSOR:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="" type="text" name="processor" id="processor" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">RAM:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="" type="text" name="ram" id="ram" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">OS:</div>
                                                                    <div class="col-md-9">
                                                                        <select name="os" style="width: 100%;" required>
                                                                            <option value="window 10">Window 10</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">HDD:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="" type="text" name="hdd" id="hdd" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">DISPLAY:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="" type="text" name="display" id="display" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">GRAPHIC CARD:</div>
                                                                    <div class="col-md-9">
                                                                        <input class="validate[required]" value="" type="text" name="graphic_card" id="graphic_card" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">WEB CAM:</div>
                                                                    <div class="col-md-9"><input value="" class="validate[required]" type="text" name="web_cam" id="web_cam" /> </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">BATTERY:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="" class="validate[required]" type="text" name="battery" id="battery" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">KEYBOARD:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="" class="validate[required]" type="text" name="keyboard" id="keyboard" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">MOUSE:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="" class="validate[required]" type="text" name="mouse" id="mouse" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">WIFI/BLUETOOTH MODULE:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="" class="validate[required]" type="text" name="wifi" id="wifi" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">WARRANT:</div>
                                                                    <div class="col-md-9">
                                                                        <input value="" class="validate[required]" type="text" name="warranty" id="warranty" />
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">OTHER ADDITIONAL SPECIFICATION:</div>
                                                                    <div class="col-md-9">
                                                                        <textarea name="other_specs" placeholder="Reason for visit..." ></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="dr"><span></span></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" value="<?=$request['id']?>">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            <input type="submit" class="btn btn-success" value="Submit" name="add_specs">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="specsCheck<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>View Request</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="block-fluid">
                                                                <div class="row-form clearfix">
                                                                   <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">BRAND: <?=$specs['brand']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="brand" type="radio" value="1"> Yes <input name="brand" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="processor" type="radio" value="1"> Yes <input name="processor" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">RAM: <?=$specs['ram']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="ram" type="radio" value="1"> Yes <input name="ram" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">OS: <?=$specs['os']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="os" type="radio" value="1"> Yes <input name="os" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">HDD: <?=$specs['hdd']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="hdd" type="radio" value="1"> Yes <input name="hdd" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="display" type="radio" value="1"> Yes <input name="display" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="graphic_card" type="radio" value="1"> Yes <input name="graphic_card" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="web_cam" type="radio" value="1"> Yes <input name="web_cam" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="battery" type="radio" value="1"> Yes <input name="battery" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="keyboard" type="radio" value="1"> Yes <input name="keyboard" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="mouse" type="radio" value="1"> Yes <input name="mouse" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="wifi" type="radio" value="1"> Yes <input name="wifi" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="warranty" type="radio" value="1"> Yes <input name="warranty" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="other_specs" type="radio" value="1"> Yes <input name="other_specs" type="radio" value="1"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-3">Comments:</div>
                                                                    <div class="col-md-9">
                                                                        <textarea name="comments" placeholder="Additional comments..." ></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="dr"><span></span></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" value="<?=$specs['id']?>">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            <input type="submit" class="btn btn-success" value="Submit" name="check_specs">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
