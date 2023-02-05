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
        if (Input::get('add_request')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
               
                
            ));
            if ($validate->passed()) {
                $errorM = false;
                try {
                    $attachment_file = Input::get('approval');
                    if (!empty($_FILES['approval']["tmp_name"])) {
                        $attach_file = $_FILES['approval']['type'];
                        if ($attach_file == "application/pdf") {
                            $folderName = 'approvals/';
                            $attachment_file = $folderName . basename($_FILES['approval']['name']);
                            if (@move_uploaded_file($_FILES['approval']["tmp_name"], $attachment_file)) {
                                $file = true;
                            } else {
                                {
                                    $errorM = true;
                                    $errorMessage = 'Your Approval File Not Uploaded ,';
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
                        $user->createRecord('computer_request', array(
                            'name' => Input::get('name'),
                            'employee_id' => Input::get('employee_id'),
                            'department' => Input::get('department'),
                            'job_title' => Input::get('job_title'),
                            'approval_file' => Input::get('approval_file'),
                            'comments' => Input::get('comments'),
                            'request_date' => date('Y-m-d'),
                            'staff_id' => $user->data()->id,
                        ));
                        $successMessage = 'Request Created Successful';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
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
                    <div class="col-md-offset-1 col-md-8">
                            <div class="head clearfix">
                                <div class="isw-ok"></div>
                                <h1>Add Request</h1>
                            </div>
                            <div class="block-fluid">
                                <form id="validation" enctype="multipart/form-data" method="post">

                                    <div class="row-form clearfix">
                                        <div class="col-md-3">Full Name:</div>
                                        <div class="col-md-9">
                                            <input value="" class="validate[required]" type="text" name="name" id="name" />
                                        </div>
                                    </div>
                                    <div class="row-form clearfix">
                                        <div class="col-md-3">Employee ID NUmber:</div>
                                        <div class="col-md-9">
                                            <input value="" class="validate[required]" type="text" name="employee_id" id="employee_id" />
                                        </div>
                                    </div>

                                    <div class="row-form clearfix">
                                        <div class="col-md-3">Department</div>
                                        <div class="col-md-9">
                                            <select name="department" style="width: 100%;" required>
                                                <option value="">Select Department</option>
                                                <?php foreach ($override->getData('department') as $department){?>
                                                    <option value="<?=$department['id']?>"><?=$department['name']?></option>
                                                <?php }?>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="row-form clearfix">
                                        <div class="col-md-3">Job Title:</div>
                                        <div class="col-md-9">
                                            <input value="" class="validate[required]" type="text" name="job_title" id="job_title" />
                                        </div>
                                    </div>

                                    <div class="row-form clearfix">
                                        <div class="col-md-5">Approval:</div>
                                        <div class="col-md-7">
                                            <input type="file" id="approval" name="approval"/>
                                        </div>
                                    </div>

                                    <div class="row-form clearfix">
                                        <div class="col-md-3">Comments:</div>
                                        <div class="col-md-9">
                                           <textarea name="textarea" placeholder="Reason for visit..."></textarea>
                                        </div>
                                    </div>

                                    <div class="footer tar">
                                        <input type="submit" name="add_request" value="Submit" class="btn btn-default">
                                    </div>

                                </form>
                            </div>

                </div>

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
