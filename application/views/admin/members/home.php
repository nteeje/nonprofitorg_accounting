<div class="container top" >

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </li>
        <li>--
            <a class="btn btn-info" href="<?php echo base_url(); ?>admin/members">Home</a>
        </li>
    </ul>
    
    

    <div class="row">

        <div class="span3">    
            <ul class="nav nav-list sidenav">
                <li class="nav-header" style="background-color: #E5E4E2">PLATINUM MEMBERS</li>
                <?php
                foreach ($members as $key => $value) {
                    if ($value->mmbr_grade == 'A') {
                        echo '<li><a href="#">' . $value->mmbr_name . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="span3">    
            <ul class="nav nav-list sidenav">
                <li class="nav-header" style="background-color: gold">GOLDEN MEMBERS</li>
                <?php
                foreach ($members as $key => $value) {
                    if ($value->mmbr_grade == 'B') {
                        echo '<li><a href="#">' . $value->mmbr_name . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="span3">    
            <ul class="nav nav-list sidenav">
                <li class="nav-header" style="background-color: silver">SILVER MEMBERS</li>
                <?php
                foreach ($members as $key => $value) {
                    if ($value->mmbr_grade == 'C') {
                        echo '<li><a href="#">' . $value->mmbr_name . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="span3">    
            <ul class="nav nav-list sidenav">
                <li class="nav-header" style="background-color: #CD7F32">BRONZE MEMBERS</li>
                    <?php
                    foreach ($members as $key => $value) {
                        if ($value->mmbr_grade == 'D') {
                            echo '<li><a href="#">' . $value->mmbr_name . '</a></li>';
                        }
                    }
                    ?>
            </ul>
        </div>
    </div>
    <!--    <div class="row">
            <div class="span11">
                <table class="table table-striped">
                    <thead><?php
    $cnA = 0;
    $cnB = 0;
    $cnC = 0;
    $cnD = 0;
    ?>
                        <tr><th colspan="4">MEMBER CLASSIFICATION</th></tr>
                        <tr>
                            <th style="background-color: #E5E4E2">PLATINUM-<?php echo $cnA; ?></th>
                            <th style="background-color: gold">GOLDEN-<?php echo $cnB; ?></th>
                            <th style="background-color: silver">SILVER-<?php echo $cnC; ?></th>
                            <th style="background-color: #CD7F32">BRONZE-<?php echo $cnD; ?></th>
                        </tr>
    
                    </thead>
                    <tbody>
                        //<?php
//                    foreach ($members as $key => $value) {
//                        echo '<tr>';
//                        if ($value->mmbr_grade == 'A') {
//                            $cnA++;
//                            echo '<td style="background-color: #E5E4E2">' . $value->mmbr_name . '</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
//                        } elseif ($value->mmbr_grade == 'B') {
//                            $cnB++;
//                            echo '<td>&nbsp;</td><td style="background-color: gold">' . $value->mmbr_name . '</td><td>&nbsp;</td><td>&nbsp;</td>';
//                        } elseif ($value->mmbr_grade == 'C') {
//                            $cnC++;
//                            echo '<td>&nbsp;</td><td>&nbsp;</td><td style="background-color: silver">' . $value->mmbr_name . '</td><td>&nbsp;</td>';
//                        } elseif ($value->mmbr_grade == 'D') {
//                            $cnD++;
//                            echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="background-color: #CD7F32">' . $value->mmbr_name . '</td>';
//                        }
//                        echo '</tr>';
//                    }
//                    
    ?>
    
                    </tbody>
                </table>
            </div>
        </div>-->


</div>