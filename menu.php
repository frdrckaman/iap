
<div class="menu">                

            <div class="breadLine">            
                <div class="arrow"></div>
                <div class="adminControl active">
                    Hi, <?=$user->data()->firstname?>
                </div>
            </div>

            <div class="admin">
                <div class="image">
                    <img src="img/usr.png" height="60px" width="60px" />                
                </div>
                <ul class="control">                
                    <li><span class="glyphicon glyphicon-comment"></span> <a href="#">Messages</a> <a href="#" class="caption red">0</a></li>
                    <li><span class="glyphicon glyphicon-cog"></span> <a href="#">Settings</a></li>
                    <li><span class="glyphicon glyphicon-share-alt"></span> <a href="logout.php">Logout</a></li>
                </ul>
                <div class="info">
                    <span>Welcom back! Your last visit: <?=$user->data()->last_login?></span>
                </div>
            </div>

            <ul class="navigation">            
                <li class="active">
                    <a href="dashboard.php">
                        <span class="isw-grid"></span><span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="dashboard.php">
                        <span class="isw-grid"></span><span class="text">My Computer</span>
                    </a>
                </li>

                <li class="openable">
                    <a href="request.php">
                        <span class="isw-list"></span><span class="text">Computer Requests</span>
                    </a>
                    <ul>
                        <li>
                            <a href="request.php">
                                <span class="glyphicon glyphicon-th"></span><span class="text">Add Request</span>
                            </a>                  
                        </li>
                        <li>
                            <a href="#">
                                <span class="glyphicon glyphicon-th"></span><span class="text">My Request</span>
                            </a>
                        </li>
                        <li>
                            <a href="request_list.php">
                                <span class="glyphicon glyphicon-th-large"></span><span class="text">Request List</span>
                            </a>                  
                        </li>
                    </ul>                
                </li>
                <li class="openable">
                    <a href="#"><span class="isw-tag"></span><span class="text">Admin</span></a>
                    <ul>
                        <li>
                            <a href="add.php?id=1">
                                <span class="glyphicon glyphicon-list"></span><span class="text">Add Department</span>
                            </a>
                        </li>
                        <li>
                            <a href="info.php?id=1">
                                <span class="glyphicon glyphicon-list"></span><span class="text">Department</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <div class="dr"><span></span></div>

            <div class="widget-fluid">
                <div id="menuDatepicker"></div>
            </div>

            <div class="dr"><span></span></div>

            <div class="widget">

                <div class="input-group">
                    <input id="appendedInputButton" class="form-control" type="text">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="button">Search</button>
                    </div>
                </div>           

            </div>

            <div class="dr"><span></span></div>

            <div class="widget-fluid">

                <div class="wBlock clearfix">
                    <div class="dSpace">
                        <h3>Total Requests</h3>
                        <span class="number">0</span>
                        <span>0<b>Pending</b></span>
                        <span>0<b>Approved</b></span>
                        <span>0 <b>Declined</b></span>

                    </div>
                    <div class="rSpace">
                        <h3>Today</h3>
                        <span>0<b>Pending</b></span>
                        <span>0<b>Approved</b></span>
                        <span>0<b>Declined</b></span>

                    </div>
                </div>

            </div>

        </div>