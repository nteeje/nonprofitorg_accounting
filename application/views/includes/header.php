<!DOCTYPE html> 
<html lang="en-US">
    <head>
        <title>scid</title>
        <meta charset="utf-8">
        <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">
            var baseurl = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand">SCID Treasurer</a>
                    <ul class="nav">                                        
                        <li <?php
                        if ($this->uri->segment(2) == 'members') {
                            echo 'class="active"';
                        }
                        ?>>
                            <a href="<?php echo base_url(); ?>admin/members">Members</a>
                        </li>
                        
                        <li <?php
                        if ($this->uri->segment(2) == 'ledgers') {
                            echo 'class="active"';
                        }
                        ?>>
                            <a href="<?php echo base_url(); ?>admin/ledgers">Ledgers</a>
                        </li>
                        <li <?php
                        if ($this->uri->segment(2) == 'journals') {
                            echo 'class="active"';
                        }
                        ?>>
                            <a href="<?php echo base_url(); ?>admin/journals">Journal</a>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li <?php
                                if ($this->uri->segment(3) == 'reports') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/reports/">Home</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(3) == 'gl') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/reports/gl">General Ledger</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(3) == 'gl') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/reports/trialbalnce">Trial Balance</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(3) == 'cashaccount') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/reports/cashaccount">Cash Book</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(3) == 'cashaccount') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/reports/creditaccount">Credit Summery</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(3) == 'cashaccount') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/reports/sharesaccount">Shares Summery</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(3) == 'cashaccount') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/reports/sharesaccount">Member Payments</a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <li>
                                    <a href="<?php echo base_url(); ?>">GL POST</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/systems/backupLJs">Regular Backup</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/systems/getBackupDB">Database Backup</a>
                                </li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reference <b class="caret"></b></a>
                            <ul class="dropdown-menu">


                                <li>
                                    <a href="<?php echo base_url(); ?>">Entry Types</a>
                                </li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">User <b class="caret"></b></a>
                            <ul class="dropdown-menu">    
                                <li>
                                    <a href="<?php echo base_url(); ?>">Authentication</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>">Reset Password</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>">Register User</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/logout">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>	
