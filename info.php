<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ERROR | E_PARSE);
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
                elseif (Input::get('edit_unit')){
                    try {
                        $user->updateRecord('unit', array(
                            'name' => Input::get('name'),
                            'department_id' => Input::get('department_id'),
                        ), Input::get('id'));
                        $successMessage = 'Unit Successful Updated';
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
                elseif (Input::get('edit_manager')){
                    try {
                        $user->updateRecord('managers', array(
                            'staff_id' => Input::get('staff_id'),
                            'department_id' => Input::get('department_id'),
                            'unit_id' => Input::get('unit_id'),
                        ), Input::get('id'));
                        $successMessage = 'Manager Successful Updated';
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
                elseif (Input::get('edit_champion')){
                    try {
                        $user->updateRecord('champion', array(
                            'staff_id' => Input::get('staff_id'),
                            'department_id' => Input::get('department_id'),
                            'unit_id' => Input::get('unit_id'),
                        ), Input::get('id'));
                        $successMessage = 'Champion Successful Updated';
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
                elseif(Input::get('edit_disclaimer')){
					try {
                         $user->updateRecord('disclaimer', array(
                            'name' => Input::get('name'),
							'description' => Input::get('description'),
							'version' => Input::get('version'),
                         ), Input::get('id'));
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
                elseif(Input::get('activate_disclaimer')){
					try {
                         $user->updateRecord('disclaimer', array(
                            'status' => 1,
                         ), Input::get('id'));
                         $successMessage = 'Discalamer Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
                elseif(Input::get('deactivate_disclaimer')){
					try {
                         $user->updateRecord('disclaimer', array(
                            'status' => 2,
                         ), Input::get('id'));
                         $successMessage = 'Discalamer Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
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
								'specs_staff' => $user->data()->id,
                            ), Input::get('id'));
                            $successMessage = 'Specs Successful Added';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        $pageError = $validate->errors();
                    }
                }
            }elseif ($_GET['id'] == 4){
				if (Input::get('check_specs')) {
                   
                    $validate = $validate->check($_POST, array(

                    ));
                    if ($validate->passed()) {
                        try {
                            $user->createRecord('computer_specs_check', array(
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
                                'comments' => Input::get('comments'),
                                'check_date' => date('Y-m-d'),
                                'staff_id' => $user->data()->id,
                                'specs_id' => Input::get('id'),

                            ));
                            $user->updateRecord('computer_request', array(
                                'check_status' => 1,
								'check_officer' => $user->data()->id,
								'check_date' => date('Y-m-d'),
								'check_staff' => $user->data()->id,
                            ), Input::get('request_id'));
                            $successMessage = 'Specs Checks Successful Added';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        $pageError = $validate->errors();
                    }
                }
            }elseif($_GET['id'] == 5){
				if(Input::get('inf_manager')){
					try {
                         $user->updateRecord('computer_request', array(
                            'it_manager_status' => Input::get('approve'),
							'it_manager_comment' => Input::get('comments'),
							'it_manager_id' => $user->data()->id,
							'it_manager_date' => date('Y-m-d'),
                         ), Input::get('id'));
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 6){
				if(Input::get('coupa')){
					try {
                         $user->updateRecord('computer_request', array(
                            'coupa_status' => 1,
							'coupa_staff_id' => $user->data()->id,
							'coupa_date' => date('Y-m-d'),
							'po_number' => Input::get('po_no'),
							'request_no' => Input::get('request_no'),
                         ), Input::get('id'));
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
				elseif(Input::get('receive')){
					try {
                         $user->updateRecord('computer_request', array(
                            'pmu_receive_status' => 1,
							'pmu_receive_staff' => $user->data()->id,
							'pmu_receive_date' => date('Y-m-d'),
							'serial_number' => Input::get('serial_number'),
						
                         ), Input::get('id'));
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 7){
				if(Input::get('unit_head')){
					try {
                         $user->updateRecord('computer_request', array(
                            'head_unit_status' =>  Input::get('approve'),
							'head_unit_id' => $user->data()->id,
							'head_unit_date' => date('Y-m-d'),
							'head_unit_comment' => Input::get('comments'),
							
                         ), Input::get('id'));
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}elseif(Input::get('ce_approval')){
					$id=$override->get('off_budget','request_id',Input::get('request_id'))[0];
					try {
                         $user->updateRecord('off_budget', array(
                            'description' =>  Input::get('comments'),
							'manager_id' => $user->data()->id,
							'manager_status' => 1,
							'manager_date' => date('Y-m-d'),
                         ), $id['id']);
						 
						 $user->updateRecord('computer_request', array(
                            'head_unit_status' =>  1,
							'head_unit_id' => $user->data()->id,
							'head_unit_date' => date('Y-m-d'),
							'head_unit_comment' => Input::get('comments'),
                         ), Input::get('request_id'));
						 
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 8){
				if(Input::get('ce_approve')){
					$id=$override->get('off_budget','request_id',Input::get('request_id'))[0];
					try {
                         $user->updateRecord('off_budget', array(
                            'ce_comments' =>  Input::get('comments'),
							'ce_id' => $user->data()->id,
							'status' => Input::get('approve'),
							'ce_date' => date('Y-m-d'),
                         ), Input::get('id'));
						 
						 $user->updateRecord('computer_request', array(
                            'ce_approval' =>  1,
                         ), Input::get('request_id'));
						 
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 9){
				
			}elseif($_GET['id'] == 10){
				
			}elseif($_GET['id'] == 11){
				if(Input::get('check_quotations')){
					try {
                         $user->updateRecord('computer_request', array(
							'quotation_it' => $user->data()->id,
							'quotation_it_status' => Input::get('review'),
							'quotation_it_comments' => Input::get('comments'),
							'quotation_it_date' => date('Y-m-d'),
                         ), Input::get('request_id'));
						 
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 12){
					if (Input::get('delivery')) {
						$validate = new validate();
						$validate = $validate->check($_POST, array(
					));
					if ($validate->passed()) {
						$errorM = false;
						try {
							$attachment_file = Input::get('delivery_note');
							if (!empty($_FILES['delivery_note']["tmp_name"])) {
								$attach_file = $_FILES['delivery_note']['type'];
								if ($attach_file == "application/pdf") {
									$folderName = 'delivery/';
									$attachment_file = $folderName . basename($_FILES['delivery_note']['name']);
									if (@move_uploaded_file($_FILES['delivery_note']["tmp_name"], $attachment_file)) {
										$file = true;
									} else {
										{
											$errorM = true;
											$errorMessage = 'Your Delivery Note File Not Uploaded ,';
										}
									}
								} else {
									$errorM = true;
									$errorMessage = 'None supported file format';
								}//not supported format
							}else{
								$attachment_file = '';
							}
							
							if($errorM == false){
								$user->updateRecord('computer_request', array(
									'pmu_receive_status' => Input::get('review'),
									'pmu_receive_date' => date('Y-m-d'),
									'pmu_receive_staff' => $user->data()->id,
								),Input::get('request_id'));
								
								
								$user->createRecord('delivery_note', array(
									'request_id' => Input::get('request_id'),
									'attachment' => $attachment_file,
									'staff_id' => $user->data()->id,
									'created_on' => date('Y-m-d'),
								));
								
								$successMessage = 'Request Updated Successful';
							}
						} catch (Exception $e) {
							die($e->getMessage());
						}
					} else {
						$pageError = $validate->errors();
					}
				}
			}elseif($_GET['id'] == 13){
				if (Input::get('delivery')) {
						$validate = new validate();
						$validate = $validate->check($_POST, array(
					));
					if ($validate->passed()) {
						$errorM = false;$errorM2 = false;
						try {
							$attachment_file = Input::get('invoice');
							if (!empty($_FILES['invoice']["tmp_name"])) {
								$attach_file = $_FILES['invoice']['type'];
								if ($attach_file == "application/pdf") {
									$folderName = 'invoice/';
									$attachment_file = $folderName . basename($_FILES['invoice']['name']);
									if (@move_uploaded_file($_FILES['invoice']["tmp_name"], $attachment_file)) {
										$file = true;
									} else {
										{
											$errorM = true;
											$errorMessage = 'Your Delivery Note File Not Uploaded 111 ,';
										}
									}
								} else {
									$errorM = true;
									$errorMessage = 'None supported file format';
								}//not supported format
							}else{
								$attachment_file = '';
							}
							
							
							$attachment_file2 = Input::get('signed_delivery_note');
							if (!empty($_FILES['signed_delivery_note']["tmp_name"])) {
								$attach_file2 = $_FILES['signed_delivery_note']['type'];
								if ($attach_file2 == "application/pdf") {
									$folderName = 'signedDelivery/';
									$attachment_file2 = $folderName . basename($_FILES['signed_delivery_note']['name']);
									if (@move_uploaded_file($_FILES['signed_delivery_note']["tmp_name"], $attachment_file2)) {
										$file = true;
									} else {
										{
											$errorM2 = true;
											$errorMessage = 'Your Delivery Note File Not Uploaded 222,';
										}
									}
								} else {
									$errorM2 = true;
									$errorMessage = 'None supported file format';
								}//not supported format
							}else{
								$attachment_file2 = '';
							}
							
							if($errorM == false && $errorM2 == false){
								$user->updateRecord('computer_request', array(
									'signed_delivery_note' => Input::get('delivery_note'),
									'invoice' => Input::get('invoice_submit'),
								),Input::get('request_id'));
								
								
								$user->createRecord('delivery_note_signed', array(
									'request_id' => Input::get('request_id'),
									'attachment' => $attachment_file2,
									'staff_id' => $user->data()->id,
									'created_on' => date('Y-m-d'),
								));
								
								$user->createRecord('invoice', array(
									'request_id' => Input::get('request_id'),
									'attachment' => $attachment_file,
									'staff_id' => $user->data()->id,
									'created_on' => date('Y-m-d'),
								));
								
								$successMessage = 'Request Updated Successful';
							}
						} catch (Exception $e) {
							die($e->getMessage());
						}
					} else {
						$pageError = $validate->errors();
					}
				}
			}elseif($_GET['id'] == 14){
				if(Input::get('add_config')){
					try {
                         $user->updateRecord('computer_request', array(
							'config_staff' => $user->data()->id,
							'config_status' => Input::get('config'),
							'serial_no' => Input::get('serial_no'),
							'config_date' => date('Y-m-d'),
                         ), Input::get('request_id'));
						 
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 15){
				
			}elseif($_GET['id'] == 16){
				if(Input::get('logistic')){
					try {
						$serial_no=$override->get('computer_request', 'id', Input::get('request_id'))[0];
						$user->createRecord('logistic', array(
							'recieve_asset' => Input::get('recieve_asset'),
							'asset_tag' => Input::get('asset_tag'),
							'old_asset' => Input::get('old_asset'),
							'sign_register' => Input::get('sign_register'),
							'staff_id' => $user->data()->id,
							'request_id' => Input::get('request_id'),
							'created_on' => date('Y-m-d'),
                         ));
						 
						 $user->createRecord('assets', array(
							'asset_type' => Input::get('asset_type'),
							'staff_id' => Input::get('staff_id'),
							'serial_no' => $serial_no['serial_no'],
							'request_id' => Input::get('request_id'),
							'period' => 4,
                         ));
						 $asset_id=$override->getNews('assets', 'staff_id', Input::get('staff_id'), 'request_id', Input::get('request_id'))[0];
						 $user->createRecord('asset_history', array(
							'staff_id' => Input::get('staff_id'),
							'asset_id' => $asset_id['id'],
							'start_date' => date('Y-m-d'),
                         ));
						
                         $user->updateRecord('computer_request', array(
							'logistic_status' => 1,
                         ), Input::get('request_id'));
						 
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 17){
				if(Input::get('end_user')){
					try {
                         $user->updateRecord('computer_request', array(
                                 'receive_status' => Input::get('recieve_asset'),
                             'status' => 1,
							'receive_date' => date('Y-m-d'),
                         ), Input::get('request_id'));
						 
                         $successMessage = 'Request Updated Successful';
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
				}
			}elseif($_GET['id'] == 18){
			}elseif($_GET['id'] == 19){
                if(Input::get('mgt_quotations')){
				    try {
                        $user->updateRecord('computer_request', array(
                            'quotation_it_manager' => $user->data()->id,
                            'quotation_it_manager_status' => Input::get('review'),
                            'quotation_it_manager_comments' => Input::get('comments'),
                            'quotation_it_date' => date('Y-m-d'),
                        ), Input::get('request_id'));

                        $successMessage = 'Request Updated Successful';
                    } catch (Exception $e) {
                        die($e->getMessage());
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
                    <div class="col-md-6">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>List of Units</h1>
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
                                    <th width="25%">Department</th>
                                    <th width="5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($override->getData('unit') as $unit) {
                                    $department=$override->get('department','id', $unit['department_id'])[0]?>
                                    <tr>
                                        <td> <?= $unit['name'] ?></td>
                                        <td><?=$department['name']?></td>
                                        <td><a href="#unit<?= $unit['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                        <!-- EOF Bootrstrap modal form -->
                                    </tr>
                                    <div class="modal fade" id="unit<?= $unit['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Edit Unit Info</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Department:</div>
                                                                <div class="col-md-9">
                                                                    <select name="department_id" id="s2_1" style="width: 100%;" required>
                                                                        <option value="<?=$department['id']?>"><?php if($department){echo $department['name'];}else{echo 'Choose Department...';}?></option>
                                                                        <?php foreach ($override->getData('department') as $department){?>
                                                                            <option value="<?=$department['id']?>"><?=$department['name']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Unit Name:</div>
                                                                <div class="col-md-9">
                                                                    <input value="<?=$unit['name']?>" class="validate[required]" type="text" name="name" id="name" required/>
                                                                </div>
                                                            </div>
                                                            <div class="dr"><span></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?= $unit['id'] ?>">
                                                        <input type="submit" name="edit_unit" class="btn btn-warning" value="Save updates">
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
                    <div class="col-md-6">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>List of Managers</h1>
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
                                    <th width="25%">Username</th>
                                    <th width="25%">Department</th>
                                    <th width="25%">Unit</th>
                                    <th width="5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($override->getData('managers') as $manager) {
                                    $department=$override->get('department','id', $manager['department_id'])[0];
                                    $unit=$override->get('unit', 'id', $manager['unit_id'])[0];
                                    $staff=$override->get('user','id', $manager['staff_id'])[0]?>
                                    <tr>
                                        <td> <?= $staff['username'] ?></td>
                                        <td><?=$department['name']?></td>
                                        <td><?=$unit['name']?></td>
                                        <td><a href="#manager<?= $manager['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                        <!-- EOF Bootrstrap modal form -->
                                    </tr>
                                    <div class="modal fade" id="manager<?= $manager['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Edit Manager Info</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Department:</div>
                                                                <div class="col-md-9">
                                                                    <select name="department_id" id="s2_1" style="width: 100%;" required>
                                                                        <option value="<?=$department['id']?>"><?php if($department){echo $department['name'];}else{echo 'Choose Department...';}?></option>
                                                                        <?php foreach ($override->getData('department') as $department){?>
                                                                            <option value="<?=$department['id']?>"><?=$department['name']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Unit Name:</div>
                                                                <div class="col-md-9">
                                                                    <select name="unit_id" id="s2_1" style="width: 100%;" required>
                                                                        <option value="<?=$unit['id']?>"><?php if($unit){echo $unit['name'];}else{echo 'Choose Unit...';}?></option>
                                                                        <?php foreach ($override->getData('unit') as $units){?>
                                                                            <option value="<?=$units['id']?>"><?=$units['name']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Manager ID:</div>
                                                                <div class="col-md-9">
                                                                    <select name="staff_id" id="s2_1" style="width: 100%;" required>
                                                                        <option value="<?=$staff['id']?>"><?php if($manager){echo $staff['username'];}else{echo 'Choose Manager ID...';}?></option>
                                                                        <?php foreach ($override->getData('user') as $staff){?>
                                                                            <option value="<?=$staff['id']?>"><?=$staff['username']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="dr"><span></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?= $manager['id'] ?>">
                                                        <input type="submit" name="edit_manager" class="btn btn-warning" value="Save updates">
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
                    <div class="col-md-6">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>List of Champions</h1>
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
                                    <th width="25%">Username</th>
                                    <th width="25%">Department</th>
                                    <th width="25%">Unit</th>
                                    <th width="5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($override->getData('champion') as $champion) {
                                    $department=$override->get('department','id', $champion['department_id'])[0];
                                    $unit=$override->get('unit', 'id', $champion['unit_id'])[0];
                                    $staff=$override->get('user','id', $champion['staff_id'])[0]?>
                                    <tr>
                                        <td> <?=$staff['username'] ?></td>
                                        <td><?=$department['name']?></td>
                                        <td><?=$unit['name']?></td>
                                        <td><a href="#champion<?= $champion['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                        <!-- EOF Bootrstrap modal form -->
                                    </tr>
                                    <div class="modal fade" id="champion<?= $champion['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Edit Champion Info</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Department:</div>
                                                                <div class="col-md-9">
                                                                    <select name="department_id" id="s2_1" style="width: 100%;" required>
                                                                        <option value="<?=$department['id']?>"><?php if($department){echo $department['name'];}else{echo 'Choose Department...';}?></option>
                                                                        <?php foreach ($override->getData('department') as $department){?>
                                                                            <option value="<?=$department['id']?>"><?=$department['name']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Unit Name:</div>
                                                                <div class="col-md-9">
                                                                    <select name="unit_id" id="s2_1" style="width: 100%;" required>
                                                                        <option value="<?=$unit['id']?>"><?php if($unit){echo $unit['name'];}else{echo 'Choose Unit...';}?></option>
                                                                        <?php foreach ($override->getData('unit') as $units){?>
                                                                            <option value="<?=$units['id']?>"><?=$units['name']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Champion ID:</div>
                                                                <div class="col-md-9">
                                                                    <select name="staff_id" id="s2_1" style="width: 100%;" required>
                                                                        <option value="<?=$staff['id']?>"><?php if($champion){echo $staff['username'];}else{echo 'Choose Champion ID...';}?></option>
                                                                        <?php foreach ($override->getData('user') as $staff){?>
                                                                            <option value="<?=$staff['id']?>"><?=$staff['username']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="dr"><span></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$champion['id'] ?>">
                                                        <input type="submit" name="edit_champion" class="btn btn-warning" value="Save updates">
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
					<div class="col-md-12">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>List of Disclamers</h1>
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
                                    <th width="15%">Name</th>
                                    <th width="45%">Descriptions</th>
                                    <th width="5%">Version</th>
									<th width="10%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($override->getData('disclaimer') as $disclaimer) {?>
                                    <tr>
                                        <td> <?=$disclaimer['name'] ?></td>
                                        <td><?=$disclaimer['description']?></td>
                                        <td><?=$disclaimer['version']?></td>
										<td>
											<?php if($disclaimer['status'] == 1){?>
												<a href="#" role="button" class="btn btn-success">Active</a>
											<?php }elseif($disclaimer['status'] == 0){?>
												<a href="#" role="button" class="btn btn-warning">Inactive</a>
											<?php }else {?>
												<a href="#" role="button" class="btn btn-danger">Deactivated</a>
											<?php }?>
										</td>
                                        <td>
											<a href="#disclaimer<?=$disclaimer['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a>
											<a href="#active<?=$disclaimer['id'] ?>" role="button" class="btn btn-success" data-toggle="modal">Activate</a>
											<a href="#deactive<?=$disclaimer['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Deactivate</a>
										</td>
                                        <!-- EOF Bootrstrap modal form -->
                                    </tr>
                                    <div class="modal fade" id="disclaimer<?= $disclaimer['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Edit Disclamer Info</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">name:</div>
                                                                <div class="col-md-9">
                                                                    <input value="<?=$disclaimer['name']?>" class="validate[required]" type="text" name="name" id="name" required/>
                                                                </div>
                                                            </div>
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Description:</div>
                                                                <div class="col-md-9">
                                                                    <textarea name="description" placeholder="Description..."><?=$disclaimer['description']?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row-form clearfix">
                                                                <div class="col-md-3">Version:</div>
                                                                <div class="col-md-9">
                                                                   <input value="<?=$disclaimer['version']?>" class="validate[required]" type="number" name="version" id="version" required/>
                                                                </div>
                                                            </div>
                                                            <div class="dr"><span></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$disclaimer['id'] ?>">
                                                        <input type="submit" name="edit_disclaimer" class="btn btn-warning" value="Save updates">
                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
									<div class="modal fade" id="active<?=$disclaimer['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Edit Disclamer Info</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
														<div class="row-form clearfix">
															<h4 style='color: #eea236;font-weight: bold;'>Are you sure you want to activate this?</h4>
														</div>
                                                        <div class="dr"><span></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$disclaimer['id'] ?>">
														<input type="hidden" name="status" value="1">
                                                        <input type="submit" name="activate_disclaimer" class="btn btn-warning" value="Save updates">
                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
									<div class="modal fade" id="deactive<?=$disclaimer['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Edit Disclamer Info</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="row-form clearfix">
																<h4 style='color: #eea236;font-weight: bold;'>Are you sure you want to deactivate this?</h4>
															</div>
                                                            <div class="dr"><span></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$disclaimer['id'] ?>">
														<input type="hidden" name="status" value="2">
                                                        <input type="submit" name="deactivate_disclaimer" class="btn btn-warning" value="Save updates">
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
                                        <th width="60%">Status</th>
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
											<a href="#" role="button" class="btn <?php if($request['it_manager_status']==1){echo 'btn btn-success';$sp='IT Manager(Done)';}elseif($request['it_manager_status']==2){echo 'btn btn-warning';$sp='IT Manager(Declined)';}else{echo 'btn btn-warning';$sp='IT Manager Approval(Wait..)';}?> "><?=$sp?></a>
                                            <a href="#" role="button" class="btn <?php if($request['pmu_status']==1){echo 'btn btn-success';}else{echo 'btn btn-warning';}?> ">PMU</a>
											<a href="#" role="button" class="btn <?php if($request['pmu_receive_status']==1){echo 'btn btn-success';}else{echo 'btn btn-warning';}?> ">Supplier</a>
                                            <a href="#" role="button" class="btn <?php if($request['check_status']==1){echo 'btn btn-success';}else{echo 'btn btn-warning';}?> ">Specs Check</a>
                                            <a href="info.php?id=17&rid=<?=$request['id']?>" role="button" class="btn <?php if($request['receive_status']==1){echo 'btn btn-success';}else{echo 'btn btn-warning';}?> ">Receive Confirmation</a>
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
                                        <th width="20%">Comments</th>
                                        <th width="40%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($override->get3('computer_request','status',0,'ce_approval',1,'head_unit_status',1) as $request){
                                    $checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
									 $delivery_note=$override->get('delivery_note', 'request_id', $request['id']);
									 if($delivery_note){$delivery=$delivery_note[0]['attachment'];}
                                    if($checkSpecs){$specs=$checkSpecs[0];}?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox" /></td>
                                        <td><?=$request['name']?></td>
                                        <td><?=$request['employee_id']?></td>
                                        <td><?=$request['job_title']?></td>
                                        <td><?=$request['request_date']?></td>
                                        <td><?=$request['comments']?></td>
                                        <td>
                                            <?php if($request['specs_status'] == 0){?>
                                                <a href="#specs<?=$request['id']?>" role="button" class="btn btn-warning" data-toggle="modal">Add Specs</a>
                                            <?php }?>
                                            <?php if($request['quotation_it'] == 0 && $request['coupa_status'] == 1){?>
                                                <a href="info.php?id=11&rid=<?=$request['id']?>" role="button" class="btn btn-warning" >Approve Quotations</a>
                                            <?php }?>
                                            <?php if($request['check_status'] == 1 && $request['invoice'] == 0){?>
                                                <a href="info.php?id=13&rid=<?=$request['id']?>" class="btn btn-warning" role="button" data-toggle="modal" >Add Invoice</a>
                                            <?php } ?>
                                            <?php if($request['invoice'] == 1 && $request['config_status'] == 0){?>
                                                <a href="info.php?id=14&rid=<?=$request['id']?>" class="btn btn-warning" role="button" data-toggle="modal" >Device Config</a>
                                            <?php } ?>
                                            <?php if($request['pmu_receive_status'] == 1 && $request['check_status'] == 0){?>
                                                <a href="info.php?id=4&rid=<?=$request['id']?>" role="button" class="btn btn-warning" >Specs Check</a>
                                            <?php }?>
                                            <?php if($request['pmu_receive_status'] == 1){?>
                                                    <a href="download.php?file=<?=$delivery?>" class="btn btn-info" target="_blamk" >Delivery Note</a>
                                            <?php } ?>
                                            <?php if($request['quotations_status'] == 1){?>
                                                <a href="info.php?id=10&rid=<?=$request['id']?>" role="button" class="btn btn-info" >Quotations</a>
                                            <?php }?>

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
                                                        <h4>Check Request</h4>
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
                                                                            <input name="brand" type="checkbox" value="1"> Yes <input name="brand" type="checkbox" value="2" checked> No
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="processor" type="radio" value="1"> Yes <input name="processor" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">RAM: <?=$specs['ram']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="ram" type="radio" value="1"> Yes <input name="ram" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">OS: <?=$specs['os']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="os" type="radio" value="1"> Yes <input name="os" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">HDD: <?=$specs['hdd']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="hdd" type="radio" value="1"> Yes <input name="hdd" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="display" type="radio" value="1"> Yes <input name="display" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="graphic_card" type="radio" value="1"> Yes <input name="graphic_card" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="web_cam" type="radio" value="1"> Yes <input name="web_cam" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="battery" type="radio" value="1"> Yes <input name="battery" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="keyboard" type="radio" value="1"> Yes <input name="keyboard" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="mouse" type="radio" value="1"> Yes <input name="mouse" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="wifi" type="radio" value="1"> Yes <input name="wifi" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="warranty" type="radio" value="1"> Yes <input name="warranty" type="radio" value="2"> No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
                                                                        </div>
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox"><input name="other_specs" type="radio" value="1"> Yes <input name="other_specs" type="radio" value="2"> No</label>
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
                                                            <input type="hidden" name="request_id" value="<?=$request['id']?>">
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
                <?php }elseif($_GET['id'] == 4 && $_GET['rid']){?>
					<div class="col-md-offset-1 col-md-8">
					<?php $specs=$override->get('computer_specs', 'request_id', $_GET['rid'])[0];$disclamers=$override->get('disclaimer','status', 1);
					$request=$override->get('computer_request', 'id', $_GET['rid'])[0]?>
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Check Specs</h1>
                        </div>
						<div class="block-fluid">
							<form id="validation" enctype="multipart/form-data" method="post">
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">BRAND: <?=$specs['brand']?></label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<input name="brand" type="radio" value="1"> Yes <input name="brand" type="radio" value="2" checked> No
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="processor" type="radio" value="1"> Yes <input name="processor" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">RAM: <?=$specs['ram']?></label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="ram" type="radio" value="1"> Yes <input name="ram" type="radio" value="2"> No</label>
										</div>
									</div> 
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">OS: <?=$specs['os']?></label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="os" type="radio" value="1"> Yes <input name="os" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">HDD: <?=$specs['hdd']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="hdd" type="radio" value="1"> Yes <input name="hdd" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="display" type="radio" value="1"> Yes <input name="display" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="graphic_card" type="radio" value="1"> Yes <input name="graphic_card" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="web_cam" type="radio" value="1"> Yes <input name="web_cam" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="battery" type="radio" value="1"> Yes <input name="battery" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="keyboard" type="radio" value="1"> Yes <input name="keyboard" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="mouse" type="radio" value="1"> Yes <input name="mouse" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="wifi" type="radio" value="1"> Yes <input name="wifi" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="warranty" type="radio" value="1"> Yes <input name="warranty" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="other_specs" type="radio" value="1"> Yes <input name="other_specs" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-3">Comments:</div>
									<div class="col-md-9">
										<textarea name="comments" placeholder="Additional comments..." ></textarea>
									</div>
								</div>
								<?php foreach($disclamers as $disclamer){?>
									<div class="row-form clearfix" style="color: orange; font-weight: bolder;">
										<div class="col-md-2"><?=$disclamer['name']?> Disclamer:</div>
										<p><?=$disclamer['description']?></p>
									</div>
								<?php }?>
								
								<div class="footer tar">
                                    <input type="hidden" name="id" value="<?=$specs['id']?>">
                                    <input type="hidden" name="request_id" value="<?=$_GET['rid']?>">
                                    <input type="submit" class="btn btn-success" value="Submit" name="check_specs" <?php if($request['check_status']==1){echo 'disabled';}?>>
                                 </div>
							</form>
						</div>
					</div>
				<?php }elseif($_GET['id'] == 5){?>
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
                                        <th width="10%">Job title</th>
                                        <th width="10%">request date</th>
                                        <th width="10%">Specs Officer</th>
                                        <th width="20%">Comments</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($override->get('computer_request', 'status', 0) as $request){
                                    $checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
                                    if($checkSpecs){$specs=$checkSpecs[0];$specsOfficer=$override->get('user', 'id', $specs['staff_id'])[0]['username'];}?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox" /></td>
                                        <td><?=$request['name']?></td>
                                        <td><?=$request['employee_id']?></td>
                                        <td><?=$request['job_title']?></td>
                                        <td><?=$request['request_date']?></td>
										<td><?=$specsOfficer?></td>
                                        <td><?=$request['comments']?></td>
                                        <td>
											<?php if($request['specs_status']==1 && $request['it_manager_status']==0){?>
												<a href="#request<?=$request['id']?>" role="button" class="btn btn-warning" data-toggle="modal">Approve Specs</a>
											<?php }?>
											<?php if($request['quotation_it_status'] == 1 && $request['quotation_it_manager_status']==0){?>
												<a href="info.php?id=19&rid=<?=$request['id']?>" role="button" class="btn btn-warning" data-toggle="modal">Approve Quotation</a>
											<?php }?>

                                            <?php if($request['quotation_it_status'] == 1){?>
                                                <a href="info.php?id=10&rid=<?=$request['id']?>" role="button" class="btn btn-info" >Quotations</a>
                                            <?php }?>
                                            
											<a href="#specsView<?=$request['id']?>" role="button" class="btn btn-info" data-toggle="modal">View Specs</a>
                                        </td>
                                    </tr>
									<div class="modal fade" id="request<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Approve Request</h4>
                                                    </div>
																
													<div class="row-form clearfix">
														<div class="col-md-3">Approval</div>
														<div class="col-md-9">
                                                            <select name="approve" style="width: 100%;" required>
                                                                <option value="">Select</option>
																<option value="1">Approve</option>
																<option value="2">Reject</option>
															</select>
														</div>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">Comments:</div>
                                                        <div class="col-md-9">
                                                            <textarea name="comments" placeholder="Additional comments..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$request['id']?>">
                                                        <input type="submit" name="inf_manager" value="Approve" class="btn btn-success" <?php if($request['it_manager_status'] == 1){echo 'disabled';}else{echo '';}?>>
                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
												</div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="specsView<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Check Request</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="block-fluid">
                                                                <div class="row-form clearfix">
                                                                   <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">BRAND: <?=$specs['brand']?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
                                                                        </div>
                                                                       
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">RAM: <?=$specs['ram']?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">OS: <?=$specs['os']?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">HDD: <?=$specs['hdd']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="dr"><span></span></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" value="<?=$specs['id']?>">
                                                            <input type="hidden" name="request_id" value="<?=$request['id']?>">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                           
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
				<?php }elseif($_GET['id'] == 6){?>
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
									<th width="10%">Request Date</th>
									<th width="10%">PO Num</th>
									<th width="10%">Request Num</th>
									<th width="10%">Specs Officer</th>
									<th width="40%">Action</th>
								</tr>
								</thead>
								<tbody>

								<?php foreach($override->get3('computer_request','it_manager_status', 1, 'coupa_status', 0, 'status', 0) as $request){
									$champion=$override->get('champion','department_id',$request['department'])[0];
									if($user->data()->id == $champion['staff_id']){
									$checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
									if($checkSpecs){$specs=$checkSpecs[0];$specsOfficer=$override->get('user', 'id', $specs['staff_id'])[0]['username'];}?>
									<tr>
										<td><input type="checkbox" name="checkbox" /></td>
										<td><?=$request['name']?></td>
										<td><?=$request['employee_id']?></td>
										<td><?=$request['request_date']?></td>
										<td><?=$request['po_number']?></td>
										<td><?=$request['request_no']?></td>
										<td><?=$specsOfficer?></td>
										<td>
											<?php if($request['pmu_status']==1){?>
												<a href="#receive<?=$request['id']?>" role="button" class="btn btn-info" data-toggle="modal">Receive Order</a>
											<?php }else{ ?>
												<a href="#coupa<?=$request['id']?>" role="button" class="btn btn-warning" data-toggle="modal">Add COUPA Details</a>
											<?php }?>
												<a href="#specsViewPmu<?=$request['id']?>" role="button" class="btn btn-info" data-toggle="modal">View Specs</a>
										</td>
									</tr>
									<div class="modal fade" id="coupa<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>Add COUPA Details</h4>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">PO Number:</div>
														<div class="col-md-9">
															<input value="" class="validate[required]" type="text" name="po_no" id="po_no" />
														</div>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">Request Number:</div>
														<div class="col-md-9">
															<input value="" class="validate[required]" type="text" name="request_no" id="request_no" />
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="id" value="<?=$request['id']?>">
														<input type="submit" name="coupa" value="Approve" class="btn btn-success" <?php if($request['pmu_officer_id'] == 1){echo 'disabled';}else{echo '';}?>>
														<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div class="modal fade" id="receive<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>Receve Order</h4>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">Serial Number:</div>
														<div class="col-md-9">
															<input value="" class="validate[required]" type="text" name="serial_number" id="serial_number" />
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="id" value="<?=$request['id']?>">
														<input type="submit" name="receive" value="Receive" class="btn btn-success" <?php if($request['pmu_officer_id'] == 1){echo 'disabled';}else{echo '';}?>>
														<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div class="modal fade" id="specsViewPmu<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>Check Request</h4>
													</div>
													<div class="modal-body modal-body-np">
														<div class="row">
															<div class="block-fluid">
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BRAND: <?=$specs['brand']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">RAM: <?=$specs['ram']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OS: <?=$specs['os']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">HDD: <?=$specs['hdd']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
																		</div>
																	</div>
																</div>
																<div class="dr"><span></span></div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="id" value="<?=$specs['id']?>">
															<input type="hidden" name="request_id" value="<?=$request['id']?>">
															<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
															
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								<?php }}?>
								</tbody>
							</table>
						</div>
					</div>
                <?php }elseif($_GET['id'] == 7){?>
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
                                        <th width="10%">request date</th>
										<th width="15%">Budget</th>
                                        <th width="20%">Comments</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($override->get('computer_request','head_unit_status', 0) as $request){
									$manager=$override->get('managers','department_id',$request['department'])[0];
									if($user->data()->id == $manager['staff_id']){
                                    $checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
                                    if($checkSpecs){$specs=$checkSpecs[0];$specsOfficer=$override->get('user', 'id', $specs['staff_id'])[0]['username'];}?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox" /></td>
                                        <td><?=$request['name']?></td>
                                        <td><?=$request['employee_id']?></td>
                                        <td><?=$request['job_title']?></td>
                                        <td><?=$request['request_date']?></td>
										<td>
											<?php if($request['off_budget'] == 0){?>
												<a href="#" role="button" class="btn btn-success">Within Budget</a>
											<?php }else{?>
												<a href="#" role="button" class="btn btn-warning">Off Budget</a>
												<?php if($request['ce_approval'] == 0){?>
													<strong><p style="color:red;font-weight:bolder;">CE Approval Required</p></strong>
												<?php }?>
											<?php }?>
										</td>
                                        <td><?=$request['comments']?></td>
                                        <td>
											<?php if($request['ce_approval'] == 1 && $request['head_unit_status'] == 0){?>
												<a href="#unitHeadApprove<?=$request['id']?>" role="button" class="btn btn-warning" data-toggle="modal">Approve</a>
											<?php }else{?>
												<a href="#unitHeadCE<?=$request['id']?>" role="button" class="btn btn-warning" data-toggle="modal">Request CE Approval</a>
											<?php }?>
                                        </td>
                                    </tr>
									<div class="modal fade" id="unitHeadApprove<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Approve Request</h4>
                                                    </div>
																
													<div class="row-form clearfix">
														<div class="col-md-3">Approval</div>
														<div class="col-md-9">
                                                            <select name="approve" style="width: 100%;" required>
                                                                <option value="">Select</option>
																<option value="1">Approve</option>
																<option value="2">Reject</option>
															</select>
														</div>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">Comments:</div>
                                                        <div class="col-md-9">
                                                            <textarea name="comments" placeholder="Additional comments..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="<?=$request['id']?>">
                                                        <input type="submit" name="unit_head" value="Approve" class="btn btn-success" <?php if($request['unit_head_status'] == 1){echo 'disabled';}else{echo '';}?>>
                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
												</div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="unitHeadCE<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Request For CE</h4>
                                                    </div>
                                                    <div class="modal-body modal-body-np">
                                                        <div class="row">
                                                            <div class="block-fluid">
                                                                
                                                                <div class="row-form clearfix">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" style="margin-top: 5px;">
                                                                            <textarea name="comments" placeholder="Additional comments..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="dr"><span></span></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            
                                                            <input type="hidden" name="request_id" value="<?=$request['id']?>">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            <input type="submit" name="ce_approval" class="btn btn-success" value="Submit" name="check_specs">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
								<?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				<?php }elseif($_GET['id'] == 8){?>
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
                                        <th width="5%">Employee</th>
                                        <th width="15%">Job title</th>
                                        <th width="10%">request date</th>
										<th width="35%">Manager Description</th>
                                        
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($override->get('off_budget','status', 0) as $budget){
									$manager=$override->get('managers','department_id',$budget['department'])[0];
									$request=$override->get('computer_request', 'id', $budget['request_id'])[0];
									
                                    $checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
                                    if($checkSpecs){$specs=$checkSpecs[0];$specsOfficer=$override->get('user', 'id', $specs['staff_id'])[0]['username'];}?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox" /></td>
                                        <td><?=$request['name']?></td>
                                        <td><?=$request['employee_id']?></td>
                                        <td><?=$request['job_title']?></td>
                                        <td><?=$request['request_date']?></td>
										<td>
											<?=$budget['description']?>
										</td>
                                        
                                        <td>
											<a href="#CEApprove<?=$request['id']?>" role="button" class="btn btn-warning" data-toggle="modal">Approve</a>
                                        </td>
                                    </tr>
									<div class="modal fade" id="CEApprove<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
                                            <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4>Approve Request</h4>
                                                    </div>
																
													<div class="row-form clearfix">
														<div class="col-md-3">Approval</div>
														<div class="col-md-9">
                                                            <select name="approve" style="width: 100%;" required>
                                                                <option value="">Select</option>
																<option value="1">Approve</option>
																<option value="2">Reject</option>
															</select>
														</div>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">Comments:</div>
                                                        <div class="col-md-9">
                                                            <textarea name="comments" placeholder="Additional comments..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="request_id" value="<?=$request['id']?>">
														<input type="hidden" name="id" value="<?=$budget['id']?>">
                                                        <input type="submit" name="ce_approve" value="Approve" class="btn btn-success" <?php if($request['unit_head_status'] == 1){echo 'disabled';}else{echo '';}?>>
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
				<?php }elseif($_GET['id'] == 9){?>
					<div class="col-md-12">
						<div class="head clearfix">
							<div class="isw-grid"></div>
							<h1>Quotations Status</h1>
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
									<th width="10%">Request Date</th>
									<th width="10%">PO Num</th>
									<th width="10%">Request Num</th>
									<th width="10%">Specs Officer</th>
									<th width="40%">Action</th>
								</tr>
								</thead>
								<tbody>

								<?php foreach($override->get3('computer_request','pmu_status', 0, 'coupa_status', 1, 'status', 0) as $request){
									$champion=$override->get('champion','department_id',$request['department'])[0];
									
									$checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
									$quatations=$override->get('quotation', 'request_id', $request['id']);
									$delivery_note=$override->get('delivery_note', 'request_id', $request['id']);
									if($checkSpecs){$specs=$checkSpecs[0];$specsOfficer=$override->get('user', 'id', $specs['staff_id'])[0]['username'];}
									if($quatations){$quatation=$quatations[0]['quotations'];}
									if($delivery_note){$delivery=$delivery_note[0]['attachment'];}?>
									<tr>
										<td><input type="checkbox" name="checkbox" /></td>
										<td><?=$request['name']?></td>
										<td><?=$request['employee_id']?></td>
										<td><?=$request['request_date']?></td>
										<td><?=$request['po_number']?></td>
										<td><?=$request['request_no']?></td>
										<td><?=$specsOfficer?></td>
										<td>
											<?php if($request['quotation_it_status'] == 0){?>
												<a href="add.php?id=7&rid=<?=$request['id']?>" class="btn btn-warning" >Add Quotation</a>
											<?php }?>	
											<?php if($request['pmu_receive_status'] == 0 && $request['quotation_it_manager_status'] == 1){?>
												<a href="info.php?id=12&rid=<?=$request['id']?>" class="btn btn-warning" >Receive Order</a>
											<?php } ?>
											
											<?php if($request['quotations_status'] == 1){?>
												<a href="download.php?file=<?=$quatation?>" class="btn btn-info" target="_blamk" >Quotation</a>
											<?php } ?>
											<?php if($request['pmu_receive_status'] == 1){?>
												<a href="download.php?file=<?=$delivery?>" class="btn btn-info" target="_blamk" >Delivery Note</a>
											<?php } ?>
										</td>
									</tr>
									<div class="modal fade" id="coupa<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>Add COUPA Details</h4>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">PO Number:</div>
														<div class="col-md-9">
															<input value="" class="validate[required]" type="text" name="po_no" id="po_no" />
														</div>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">Request Number:</div>
														<div class="col-md-9">
															<input value="" class="validate[required]" type="text" name="request_no" id="request_no" />
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="id" value="<?=$request['id']?>">
														<input type="submit" name="coupa" value="Approve" class="btn btn-success" <?php if($request['pmu_officer_id'] == 1){echo 'disabled';}else{echo '';}?>>
														<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div class="modal fade" id="receive<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>Receve Order</h4>
													</div>
													<div class="row-form clearfix">
														<div class="col-md-3">Serial Number:</div>
														<div class="col-md-9">
															<input value="" class="validate[required]" type="text" name="serial_number" id="serial_number" />
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="id" value="<?=$request['id']?>">
														<input type="submit" name="receive" value="Receive" class="btn btn-success" <?php if($request['pmu_officer_id'] == 1){echo 'disabled';}else{echo '';}?>>
														<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div class="modal fade" id="specsViewPmu<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>Check Request</h4>
													</div>
													<div class="modal-body modal-body-np">
														<div class="row">
															<div class="block-fluid">
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BRAND: <?=$specs['brand']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">RAM: <?=$specs['ram']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OS: <?=$specs['os']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">HDD: <?=$specs['hdd']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
																		</div>
																	</div>
																</div>
																<div class="dr"><span></span></div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="id" value="<?=$specs['id']?>">
															<input type="hidden" name="request_id" value="<?=$request['id']?>">
															<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
															
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
				<?php }elseif($_GET['id'] == 10){?>
					<div class="col-md-6">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>List of Units</h1>
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
                                    <th width="25%">File</th>
                                    <th width="5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($override->get('quotation', 'request_id', $_GET['rid']) as $quotation) {?>
                                    <tr>
                                        <td> <?= $quotation['name'] ?></td>
                                        <td><?=$quotation['quotations']?></td>
                                        <td><a href="download.php?file=<?=$quotation['quotations']?>" target="_blank" class="btn btn-info">View</a></td>
                                        <!-- EOF Bootrstrap modal form -->
                                    </tr>
                                    
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				<?php }elseif($_GET['id'] == 11){$request=null;?>
					<div class="col-md-offset-1 col-md-8">
                        <?php
                        $manager=$override->getNews('managers','staff_id',$user->data()->id, 'department_id', 1);
                        $request=$override->getNews('computer_request', 'id', $_GET['rid'], 'quotation_it_status', 0)[0];

                        if($request){?>
                            <div class="head clearfix">
                                <div class="isw-ok"></div>
                                <h1>Review Quotations</h1>
                            </div>
                            <div class="block-fluid">
                                <form id="validation" enctype="multipart/form-data" method="post">
                                    <div class="row-form clearfix">
                                        <div class="col-md-12">
                                            <div class="form-group" style="margin-top: 5px;">
                                                <label class="checkbox">Have you reviewed the Quotations to the best of your ability and your ok to allow PMU procedures to continue?</label>
                                            </div>
                                            <div class="form-group" style="margin-top: 5px;">
                                                <input name="review" type="radio" value="1"> Yes <input name="review" type="radio" value="2" checked> No
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row-form clearfix">
                                        <div class="col-md-3">Comments:</div>
                                        <div class="col-md-9">
                                            <textarea name="comments" placeholder="Additional comments..." ></textarea>
                                        </div>
                                    </div>
                                    <div class="footer tar">

                                        <input type="hidden" name="request_id" value="<?=$_GET['rid']?>">
                                        <input type="submit" class="btn btn-success" value="Submit" name="check_quotations">

                                     </div>
                                </form>
                            </div>
                            </div>
					<?php }else {?>
						<div class="alert alert-danger">
                            <h4>Error!</h4>
                            This confirmation is already submitted
                        </div>
					<?php }?>
				<?php }elseif($_GET['id'] == 12){?>
					<div class="col-md-offset-1 col-md-8">
						<?php $check_request=$override->get('computer_request','id', $_GET['rid']);if($check_request){$request=$check_request[0];if($request['pmu_receive_status'] == 0){ ?>
					<div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Recieve Order</h1>
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
                                    <div class="col-md-3">PO No:</div>
                                    <div class="col-md-9">
                                        <input value="<?=$request['po_number']?>" class="validate[required]" type="text" name="name" id="name" disabled/>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Have you recieve the goods from supplier and handleover to IT for specs checks?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<input name="review" type="radio" value="1"> Yes <input name="review" type="radio" value="2" > No
										</div>
									</div>
								</div>
                                <div class="row-form clearfix">
                                    <div class="col-md-5">Delivery Note:</div>
                                    <div class="col-md-7">
                                        <input type="file" id="delivery_note" name="delivery_note" required/>
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
                                    <input type="submit" name="delivery" value="Submit" class="btn btn-default">
                                </div>
                            </form>
                        </div>
						<?php }else {?>
						<?php }}?>
						
                    </div>
				<?php }elseif($_GET['id'] == 13){?>
					<div class="col-md-offset-1 col-md-8">
						<?php $check_request=$override->get('computer_request','id', $_GET['rid']);if($check_request){$request=$check_request[0];if($request['invoice'] == 0){ ?>
					<div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Delivery Note/Invoice</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" enctype="multipart/form-data" method="post">

                                <div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Have you signed the Delivery Note?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<input name="delivery_note" type="radio" value="1"> Yes <input name="delivery_note" type="radio" value="2" > No
										</div>
									</div>
								</div>
                                <div class="row-form clearfix">
                                    <div class="col-md-5">Signed Delivery Note:</div>
                                    <div class="col-md-7">
                                        <input type="file" id="signed_delivery_note" name="signed_delivery_note" required/>
                                    </div>
                                </div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Is invoice submitted to Coupa for Finance to pay the bill?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<input name="invoice_submit" type="radio" value="1"> Yes <input name="invoice_submit" type="radio" value="2" > No
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
                                    <div class="col-md-5">Invoice:</div>
                                    <div class="col-md-7">
                                        <input type="file" id="invoice" name="invoice" required/>
                                    </div>
                                </div>
                                <!--<div class="row-form clearfix">
                                    <div class="col-md-3">Comments:</div>
                                    <div class="col-md-9">
                                        <textarea name="comments" placeholder="Additional Comments"></textarea>
                                    </div>
                                </div>-->
                                <div class="footer tar">
									<input type="hidden" name="request_id" value="<?=$request['id']?>">
                                    <input type="submit" name="delivery" value="Submit" class="btn btn-default">
                                </div>
                            </form>
                        </div>
						<?php }else {?>
						<?php }}?>
						
                    </div>
				<?php }elseif($_GET['id'] == 14){?>
					<div class="col-md-offset-1 col-md-8">
						<?php $check_request=$override->get('computer_request','id', $_GET['rid']);if($check_request){$request=$check_request[0];if($request['config_status'] == 0){ ?>
					<div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Device Configuration</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" enctype="multipart/form-data" method="post">

                                <div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Have you configure the new device according to set standard?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<input name="config" type="radio" value="1"> Yes <input name="config" type="radio" value="2" > No
										</div>
									</div>
								</div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Device Serial Number:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="text" name="serial_no" id="serial_no" />
                                    </div>
                                </div>
								
                               
                                <div class="footer tar">
									<input type="hidden" name="request_id" value="<?=$request['id']?>">
                                    <input type="submit" name="add_config" value="Submit" class="btn btn-default">
                                </div>
                            </form>
                        </div>
						<?php }else {?>
						<?php }}?>
						
                    </div>
				<?php }elseif($_GET['id'] == 15){?>
					<div class="col-md-12">
						<div class="head clearfix">
							<div class="isw-grid"></div>
							<h1>Quotations Status</h1>
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
									<th width="10%">Request Date</th>
									<th width="10%">PO Num</th>
									<th width="10%">Request Num</th>
									<th width="10%">Specs Officer</th>
									<th width="40%">Action</th>
								</tr>
								</thead>
								<tbody>

								<?php foreach($override->getNews('computer_request', 'pmu_receive_status', 1, 'status', 0) as $request){
									$champion=$override->get('champion','department_id',$request['department'])[0];
									
									$checkSpecs=$override->get('computer_specs', 'request_id', $request['id']);
									$quatations=$override->get('quotation', 'request_id', $request['id']);
									$delivery_note=$override->get('delivery_note', 'request_id', $request['id']);
									if($checkSpecs){$specs=$checkSpecs[0];$specsOfficer=$override->get('user', 'id', $specs['staff_id'])[0]['username'];}
									if($quatations){$quatation=$quatations[0]['quotations'];}
									if($delivery_note){$delivery=$delivery_note[0]['attachment'];}?>
									<tr>
										<td><input type="checkbox" name="checkbox" /></td>
										<td><?=$request['name']?></td>
										<td><?=$request['employee_id']?></td>
										<td><?=$request['request_date']?></td>
										<td><?=$request['po_number']?></td>
										<td><?=$request['request_no']?></td>
										<td><?=$specsOfficer?></td>
										<td>

                                            <?php if($request['config_status'] == 1 && $request['logistic_status'] == 0){?>
                                                <a href="info.php?id=16&rid=<?=$request['id']?>" class="btn btn-warning" >Asset Transfer </a>
                                            <?php } ?>
											
											<?php if($request['quotations_status'] == 1){?>
												<a href="download.php?file=<?=$quatation?>" class="btn btn-info" target="_blamk" >Quotation</a>
											<?php } ?>
											<?php if($request['pmu_receive_status'] == 1){?>
												<a href="download.php?file=<?=$delivery?>" class="btn btn-info" target="_blamk" >Delivery Note</a>
											<?php } ?>

										</td>
									</tr>
								
									<div class="modal fade" id="specsViewPmu<?=$request['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>Check Request</h4>
													</div>
													<div class="modal-body modal-body-np">
														<div class="row">
															<div class="block-fluid">
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BRAND: <?=$specs['brand']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">RAM: <?=$specs['ram']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OS: <?=$specs['os']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">HDD: <?=$specs['hdd']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
																		</div>
																	</div>
																</div>
																<div class="dr"><span></span></div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="id" value="<?=$specs['id']?>">
															<input type="hidden" name="request_id" value="<?=$request['id']?>">
															<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
															
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
				<?php }elseif($_GET['id'] == 16){?>
					<div class="col-md-offset-1 col-md-8">
					<?php $specs=$override->get('computer_specs', 'request_id', $_GET['rid'])[0];$disclamers=$override->get('disclaimer','status', 1);
					$request=$override->get('computer_request', 'id', $_GET['rid'])[0];
					if($request['config_status'] == 1 && $request['logistic_status'] == 0){?>
					
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Check Specs</h1>
                        </div>
						<div class="block-fluid">
							<form id="validation" enctype="multipart/form-data" method="post">
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Have you recieve the new device from infrastructure team?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<input name="recieve_asset" type="radio" value="1"> Yes <input name="recieve_asset" type="radio" value="2" checked> No
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Have you place the Asset tag into a new device?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="asset_tag" type="radio" value="1"> Yes <input name="asset_tag" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Have you collect the old asset from user?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="old_asset" type="radio" value="1"> Yes <input name="old_asset" type="radio" value="2"> No</label>
										</div>
									</div> 
								</div>
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Did the user sign the physical register for return the old asset and receiving the new asset?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox"><input name="sign_register" type="radio" value="1"> Yes <input name="sign_register" type="radio" value="2"> No</label>
										</div>
									</div>
								</div>
								<div class="row-form clearfix">
                                    <div class="col-md-3">Staff ID:</div>
                                    <div class="col-md-9">
                                        <select name="staff_id" id="s2_1" style="width: 100%;" required>
                                            <option value="">Choose Staff...</option>
                                            <?php foreach ($override->getData('user') as $staff){?>
                                                <option value="<?=$staff['id']?>"><?=$staff['username']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
								<div class="row-form clearfix">
                                    <div class="col-md-3">Asset Type:</div>
                                    <div class="col-md-9">
                                        <select name="asset_type" style="width: 100%;" required>
                                            <option value="">Choose type...</option>
                                            <?php foreach ($override->getData('assets_type') as $type){?>
                                                <option value="<?=$type['id']?>"><?=$type['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

								<div class="footer tar">
                                    <input type="hidden" name="id" value="<?=$specs['id']?>">
                                    <input type="hidden" name="request_id" value="<?=$_GET['rid']?>">
                                    <input type="submit" class="btn btn-success" value="Submit" name="logistic">
                                 </div>
							</form>
						</div>
					</div>
					<?php }?>
				<?php }elseif($_GET['id'] == 17){?>
					<div class="col-md-offset-1 col-md-8">
					<?php $request=$override->get('computer_request', 'id', $_GET['rid'])[0];$disclamers=$override->get('disclaimer','status', 1);if($request['status'] == 0 && $request['logistic_status'] == 1){?>
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Recieve New Asset</h1>
                        </div>
						<div class="block-fluid">
							<form id="validation" enctype="multipart/form-data" method="post">
								<div class="row-form clearfix">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 5px;">
											<label class="checkbox">Have you receive the new Asset from logistic?</label>
										</div>
										<div class="form-group" style="margin-top: 5px;">
											<input name="recieve_asset" type="radio" value="1"> Yes <input name="recieve_asset" type="radio" value="2" checked> No
										</div>
									</div>
								</div>
								

								<div class="footer tar">
                                    <input type="hidden" name="id" value="<?=$request['id']?>">
                                    <input type="hidden" name="request_id" value="<?=$request['id']?>">
                                    <input type="submit" class="btn btn-success" value="Submit" name="end_user">
                                 </div>
							</form>
						</div>
					</div>
					<?php }?>
				<?php }elseif($_GET['id'] == 18){?>
					<div class="col-md-12">
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>List of Assets</h1>
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
                                    <th width="10%">Asset Type</th>
                                    <th width="10%">Serial No</th>
                                    <th width="10%">Current User</th>
									<th width="10%">End of Life in</th>
									<th width="50%">Specs Summary</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($override->getData('assets') as $asset) {
									$asset_type=$override->get('assets_type', 'id', $asset['asset_type'])[0];
									$staff=$override->get('user', 'id', $asset['staff_id'])[0];
									$commissionDate=$override->get('logistic', 'request_id', $asset['request_id'])[0]['created_on'];
									$endOfLifeDate=date('Y-m-d', strtotime($commissionDate. ' + '.$asset['period'].' year'));
									$specs=$override->get('computer_specs', 'request_id', $asset['request_id'])[0];
									
									$endOfLifeDays=$user->dateDiffNoFormat(date('Y-m-d'),$endOfLifeDate);?>
                                    <tr>
                                        <td><?=$asset_type['name'] ?></td>
                                        <td><?=$asset['serial_no']?></td>
                                        <td><?=$staff['username']?></td>
										
										<td>
											<?php if($endOfLifeDays > 365){?>
												<a href="#" role="button" class="btn btn-success"><?=number_format($endOfLifeDays)?> Days</a>
											<?php }elseif($endOfLifeDays < 365){?>
												<a href="#" role="button" class="btn btn-warning"><?=number_format($endOfLifeDays)?> Days</a>
											<?php }else {?>
												<a href="#" role="button" class="btn btn-danger"><?=number_format($endOfLifeDays)?> Days</a>
											<?php }?>
										</td>
										<td><strong>Brand:</strong> <?=$specs['brand']?>, <strong>Processor:</strong> <?=$specs['processor']?>, <strong>Ram:</strong> <?=$specs['ram']?>. <strong>HDD:</strong> <?=$specs['hdd']?></td>
                                        <td>
											<a href="#specs<?=$specs['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">View Specs</a>
											
										</td>
                                        
                                    </tr>
                                    
									<div class="modal fade" id="specs<?=$specs['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form method="post">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4>View Specs</h4>
													</div>
													<div class="modal-body modal-body-np">
														<div class="row">
															<div class="block-fluid">
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BRAND: <?=$specs['brand']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">PROCESSOR: <?=$specs['processor']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">RAM: <?=$specs['ram']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OS: <?=$specs['os']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">HDD: <?=$specs['hdd']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">DISPLAY: <?=$specs['display']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">GRAPHIC CARD: <?=$specs['graphic_card']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WEB CAM <?=$specs['web_cam']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">BATTERY: <?=$specs['battery']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">KEYBOARD: <?=$specs['keyboard']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">MOUSE: <?=$specs['mouse']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WIFI/BLUETOOTH: <?=$specs['wifi']?></label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">WARRANTY: <?=$specs['warranty']?> </label>
																		</div>
																	</div>
																</div>
																<div class="row-form clearfix">
																	<div class="col-md-12">
																		<div class="form-group" style="margin-top: 5px;">
																			<label class="checkbox">OTHER SPECS: <?=$specs['other_specs']?> </label>
																		</div>
																	</div>
																</div>
																<div class="dr"><span></span></div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="id" value="<?=$specs['id']?>">
															<input type="hidden" name="request_id" value="<?=$asset['request_id']?>">
															<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
															
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				<?php }elseif($_GET['id'] == 19){?>
                    <div class="col-md-offset-1 col-md-8">
                    <?php
                    $manager=$override->getNews('managers','staff_id',$user->data()->id, 'department_id', 1);
                    $request=$override->getNews('computer_request', 'id', $_GET['rid'], 'quotation_it_manager_status', 0)[0];
                    if($request){
                    ?>
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Review Quotations</h1>
                        </div>
                        <div class="block-fluid">
                            <form id="validation" enctype="multipart/form-data" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="checkbox">Have you reviewed the Quotations to the best of your ability and your ok to allow PMU procedures to continue?</label>
                                        </div>
                                        <div class="form-group" style="margin-top: 5px;">
                                            <input name="review" type="radio" value="1"> Yes <input name="review" type="radio" value="2" checked> No
                                        </div>
                                    </div>
                                </div>

                                <div class="row-form clearfix">
                                    <div class="col-md-3">Comments:</div>
                                    <div class="col-md-9">
                                        <textarea name="comments" placeholder="Additional comments..." ></textarea>
                                    </div>
                                </div>
                                <div class="footer tar">

                                    <input type="hidden" name="request_id" value="<?=$_GET['rid']?>">
                                    <input type="submit" class="btn btn-success" value="Submit" name="mgt_quotations">

                                </div>
                            </form>
                        </div>
                        </div>
                    <?php }else {?>
                        <div class="alert alert-danger">
                            <h4>Error!</h4>
                            This confirmation is already submitted
                        </div>
                    <?php }?>
				<?php }elseif($_GET['id'] == 20){?>
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