<div class="container top">

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
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2)); ?> 
        </h2>
    </div>

    <div class="row">
        <div class="span5">
            <div class="alert-info"></div>
        </div>
        <?php
        echo '<h3>' . $optled . '</h3><h4>' . $ledgermsg . '</h4><a class="btn btn-success" href="'.  base_url().'dboperation/csv/'.$filelg.'">Download '.$filelg.'</a>';
        ?>
    </div>
    <div class="row">
        <div class="span5">
            <div class="alert-info"></div>
        </div>
        <?php
        echo '<h3>' . $optcj . '</h3><h4>' . $cjournalmsg . '</h4><a class="btn btn-success" href="'.  base_url().'dboperation/csv/'.$filecj.'">Download '.$filecj.'</a>';
        ?>
    </div>
</div>