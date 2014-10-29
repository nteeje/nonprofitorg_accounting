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
    if ($journals[0]['cr_amount'] = $entrytypes)
        $options = array('' => "Select");
    foreach ($entrytypes as $key => $value) {
        $options[$value->id] = $value->name;
    }
    //var_dump($options);die;
    $accoptions = array('' => "Select");
    foreach ($accounts as $key => $acc) {
        $accoptions[$acc->mmbr_nic] = $acc->mmbr_account_id . '-' . $acc->mmbr_name;
    }
    //form validation
    echo validation_errors();

    echo form_open('admin/journals/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>

        <?php // echo $journals[0]['name'];  ?>
        <div class="control-group">
            <label for="inputError" class="control-label">Account ID</label>
            <div class="controls">
                <?php
                echo form_dropdown('account_id', $accoptions, $journals[0]['account_id'], 'class="span3"');
                ?>                
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Account Type</label>
            <div class="controls">
                <?php
                echo form_dropdown('entry_type', $options, $journals[0]['entry_type'], 'class="span3"');
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Reference #</label>
            <div class="controls">
                <input type="text" id="entry_reference" name="entry_reference" value="<?php echo $journals[0]['entry_reference']; ?>" >             
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Amount</label>
            <div class="controls">
                <input type="text" id="entry_amount" name="entry_amount" value="<?php echo $journals[0]['dr_amount']; ?>" >             
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">
                <textarea rows="5" id="entry_description" name="entry_description" ><?php echo $journals[0]['entry_description']; ?></textarea>            
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Cancel</button>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
