<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>">
                <?php echo ucfirst($this->uri->segment(2)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Updating <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>


    <?php
    //flash messages
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'updated') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> journal updated with success.';
            echo '</div>';
        } else {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
    }
    ?>

    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');
   $options = array('' => "Select");
    foreach ($ledgertypes as $key => $value) {
        $options[$value->id] = $value->value;
    }
    //var_dump($options);die;
    $accoptions = array('' => "Select");
    foreach ($accounts as $key => $acc) {
        $accoptions[$acc->mmbr_nic] = $acc->mmbr_account_id . '-' . $acc->mmbr_name;
    }
    $opside = array('' => "Select",1 => 'Debit Side', 2 => 'Credit Side');
    //form validation
    echo validation_errors();

    echo form_open('admin/ledgers/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
<?php // echo $ledgers[0]['name'];  ?>
        <div class="control-group">
            <label for="inputError" class="control-label">Account ID</label>
            <div class="controls">
                <?php
                echo form_dropdown('account_id', $accoptions, $ledgers[0]['member'], 'class="span3" id="account_id"');
                ?>                
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Account Type</label>
            <div class="controls">
                <?php
                echo form_dropdown('group_id', $options, $ledgers[0]['group_id'], 'class="span3"');
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Open Balance Type</label>
            <div class="controls">
               
                <?php
                echo form_dropdown('op_balance_dc', $opside, $ledgers[0]['op_balance_dc'], 'class="span3"');
                ?>
 <input type="text" name="hdnAccount" id="hdnAccount" />
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Open Balance</label>
            <div class="controls">
                <input type="text" id="open_balance" name="open_balance" value="<?php echo $ledgers[0]['op_balance']; ?>" >             

            </div>
        </div>
        
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Cancel</button>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
<script>
    $(document).ready(function () {
        $("#account_id").on("change", function () {
            //alert($("#account_id option:selected").text());
            $("#hdnAccount").val($("#account_id").find(":selected").text());
        });
    });
</script>