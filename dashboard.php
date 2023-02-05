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
                    <li><a href="#">Simple Admin</a> <span class="divider"></span></li>
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
                        <div class="col-md-12">
                            <div class="widgetButtons">
                                <div class="bb"><a href="request.php" class="tipb" title="Add"><span class="ibw-edit"></span></a></div>
                                <div class="bb">
                                    <a href="#" class="tipb" title="Upload"><span class="ibw-folder"></span></a>
                                    <div class="caption red">31</div>
                                </div>
                                <div class="bb"><a href="request.php" class="tipb" title="Add new"><span class="ibw-plus"></span></a></div>
                                <div class="bb"><a href="#" class="tipb" title="Add to favorite"><span class="ibw-favorite"></span></a></div>
                                <div class="bb">
                                    <a href="#" class="tipb" title="Send mail"><span class="ibw-mail"></span></a>
                                    <div class="caption green">31</div>
                                </div>
                                <div class="bb"><a href="#" class="tipb" title="Settings"><span class="ibw-settings"></span></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>Request</h1>
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
                                            <th width="10%">Requester Name</th>
                                            <th width="5%">Requester ID</th>
                                            <th width="10%">Status</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="dr"><span></span></div>
                </div>
            </div>
        </div>
    </body>
</html>
