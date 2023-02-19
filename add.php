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
				try {
					$user->createRecord('disclaimer', array(
						'name' => Input::get('name'),
                        'description' => Input::get('description'),
                        'version' => Input::get('version'),
						'created_on' => date('Y-m-d'),
                    ));
                    $successMessage = 'Disclamer Added Successful';
				} catch (Exception $e) {
                    die($e->getMessage());
                }
            }elseif ($_GET['id'] == 7){
				if (Input::get('add_quotations')) {echo 'Jesus';
						$validate = new validate();
						$validate = $validate->check($_POST, array(
					));
					if ($validate->passed()) {
						$errorM = false;
						try {
							$attachment_file = Input::get('quotations');
							if (!empty($_FILES['quotations']["tmp_name"])) {
								$attach_file = $_FILES['quotations']['type'];
								if ($attach_file == "application/pdf") {
									$folderName = 'Quotations/';
									$attachment_file = $folderName . basename($_FILES['quotations']['name']);
									if (@move_uploaded_file($_FILES['quotations']["tmp_name"], $attachment_file)) {
										$file = true;
									} else {
										{
											$errorM = true;
											$errorMessage = 'Your quotations File Not Uploaded ,';
										}
									}
								} else {
									$errorM = true;
									$errorMessage = 'None supported file format';
								}//not supported format
							}else{
								$attachment_file = '';
							}
							 //$errorM = false;
							if($errorM == false){
								
								$user->createRecord('quotation', array(
									'name' => Input::get('name'),
									'quotations' => $attachment_file,
									'request_id' => $_GET['rid'],
									'comments' => Input::get('comments'),
									'created_on' => date('Y-m-d'),
									'staff_id' => $user->data()->id,
								));
								$user->updateRecord('computer_request', array(
									'quotations_status' => 1,
								),Input::get('request_id'));
								
								$successMessage = 'Quotations Added Successful';
							}
						} catch (Exception $e) {
							die($e->getMessage());
						}
					} else {
						$pageError = $validate->errors();
					}
				}
            }elseif ($_GET['id'] == 8){
				 if (Input::get('computer_transfer')) {
                    $validate = new validate();
                    $validate = $validate->check($_POST, array(

                    ));
                    if ($validate->passed()) {

                        try {
							$user->updateRecord('asset_history', array(
                                'end_date' => date('Y-m-d'),
                            ),Input::get('asset_history_id'));
							
							$user->updateRecord('assets', array(
                                'staff_id' => Input::get('transfer_to'),
                            ),Input::get('asset_id'));
							
                            $user->createRecord('asset_history', array(
                                'asset_id' => Input::get('asset_id'),
								'staff_id' => Input::get('transfer_to'),
								'start_date' => date('Y-m-d'),
                            ));
                            $successMessage = 'Transfer Complited Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        $pageError = $validate->errors();
                    }
                }
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
                                        <select name="department_id" style="width: 100%;" required>
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
                                        <select name="department_id" style="width: 100%;" required>
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
                                        <select name="unit_id" style="width: 100%;" required>
                                            <option value="">Choose Unit...</option>
                                            <?php foreach ($override->getData('unit') as $unit){?>
                                                <option value="<?=$unit['id']?>"><?=$unit['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Manager ID:</div>
                                    <div class="col-md-9">
                                        <select name="staff_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Manager ID...</option>
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
                                        <select name="unit_id" style="width: 100%;" required>
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
					<div class="col-md-offset-1 col-md-8">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Add Disclamer</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Name:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="text" name="name" id="name" required/>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Description:</div>
                                    <div class="col-md-9">
                                        <textarea name="description" placeholder="Description..."></textarea>
                                    </div>
                                </div>
								<div class="row-form clearfix">
                                    <div class="col-md-3">Version:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="number" name="version" id="version" required/>
                                    </div>
                                </div>
                                <div class="footer tar">
                                    <input type="submit" name="add_disclamer" value="Submit" class="btn btn-default">
                                </div>
                            </form>
                        </div>

                    </div>
                <?php }elseif ($_GET['id'] == 7){?>
					<div class="col-md-offset-1 col-md-8">
				<?php $check_request=$override->get('computer_request','id', $_GET['rid']);if($check_request){$request=$check_request[0];if($request['quotation_it_status'] == 0){ ?>
					<div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Add Quotations</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" enctype="multipart/form-data" method="post">
								
								<div class="row-form clearfix">
                                    <div class="col-md-3">Coupa Request No:</div>
                                    <div class="col-md-9">
                                        <input value="<?=$request['request_no']?>" class="validate[required]" type="text" name="name" id="name" disabled/>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Supplier Name:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="text" name="name" id="name" />
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-5">Quotations:</div>
                                    <div class="col-md-7">
                                        <input type="file" id="quotations" name="quotations"/>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Comments:</div>
                                    <div class="col-md-9">
                                        <textarea name="comments" placeholder="Additional Comments"></textarea>
                                    </div>
                                </div>
                                <div class="footer tar">
									<input type="hidden" name="request_id" value="<?=$request['id']?>">
                                    <input type="submit" name="add_quotations" value="Submit" class="btn btn-default">
                                </div>
                            </form>
                        </div>
                    </div>
				<?php }}else{?>
					<div class="alert alert-danger">
                        <h4>Error!</h4>
                        Records Not Found
                    </div>
				<?php }?>
                <?php }elseif ($_GET['id'] == 8){?>
					 <div class="col-md-offset-1 col-md-8">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Computer Transfer</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Current Owner:</div>
                                    <div class="col-md-9">
                                        <select name="current_owner" id="s2_2" style="width: 100%;" required>
                                            <option value="">Choose Staff...</option>
                                            <?php foreach ($override->getData('user') as $staff){?>
                                                <option value="<?=$staff['id']?>"><?=$staff['username']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
								 <span><img src="img/loaders/loader.gif" id="wait_ds" title="loader.gif" /></span>
								<div id="comp_details"></div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Transfer to:</div>
                                    <div class="col-md-9">
                                        <select name="transfer_to" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Staff...</option>
                                            <?php foreach ($override->getData('user') as $transfer){?>
                                                <option value="<?=$transfer['id']?>"><?=$transfer['username']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="footer tar">
                                    <input type="submit" name="computer_transfer" value="Transfer" class="btn btn-info">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php }elseif ($_GET['id'] == 9){?>

                <?php }elseif ($_GET['id'] == 10){?>

                <?php }elseif ($_GET['id'] == 11){?>

                <?php }elseif ($_GET['id'] == 12){?>
				
				<?php }elseif ($_GET['id'] == 13){?>
				
				<?php }elseif ($_GET['id'] == 14){?>
				
				<?php }elseif ($_GET['id'] == 15){?>
				
				<?php }elseif ($_GET['id'] == 16){?>
				
				<?php }elseif ($_GET['id'] == 17){?>

                <?php }?>

                <div class="dr"><span></span></div>

            </div>

        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
		
		$(document).ready(function() {
            $('#wait_ds').hide();
            $('#s2_2').change(function() {
                var getUid = $(this).val();
                $('#wait_ds').show();
                $.ajax({
                    url: "process.php?cnt=transfer_pc",
                    method: "GET",
                    data: {
                        getUid: getUid
                    },
                    success: function(data) {
                        $('#comp_details').html(data);
                        $('#wait_ds').hide();
                    }
                });
            });
   
        });
    </script>
</body>

</html>
