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
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>

    <?php
    //flash messages
    if (isset($flash_message)) {
        if ($flash_message == TRUE) {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> new journal created with success.';
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
    echo form_open('admin/journals/add', $attributes);
    ?>
    <fieldset>

        <div class="control-group">
            <label for="inputError" class="control-label">Account ID</label>
            <div class="controls">
                <input type="hidden" id="hdnAccount" name="hdnAccount"/>
                <?php
                echo form_dropdown('account_id', $accoptions, set_value('account_id'), 'class="span3" id="account_id"');
                ?>                
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Account Type</label>
            <div class="controls">
                <?php
                echo form_dropdown('entry_type', $options, set_value('entry_type'), 'class="span3"');
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Reference #</label>
            <div class="controls">
                <input type="text" id="entry_reference" name="entry_reference" value="<?php echo set_value('entry_reference'); ?>" >             

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Amount</label>
            <div class="controls">
                <input type="text" id="entry_amount" name="entry_amount" value="<?php echo set_value('entry_amount'); ?>" >             

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">
                <textarea rows="5" id="entry_description" name="entry_description" ><?php echo set_value('entry_description'); ?></textarea>             

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
           // $("#hdnAccount").val($("#account_id").find(":selected").val());
            //getMembers
            $.ajax({
                url: baseurl + "admin/journals/getMembers",
                type: "POST",
                datatype: "json",
                data: {member: $('#account_id').val()},
                error: function (xhr, textStatus, errorThrown) {
                    alert('Error: ' + xhr.responseText);
                },
                success: function (dat) {
                    var datas = jQuery.parseJSON(dat);
                    var data = datas['data'];
                    var rowindexCompo = 0;
                    var editableCol = '';
                    for (var x = 0; x < data.length; x++) {
                        editableCol += '<tr id="memberTbl">';
                        editableCol += '<td>' + data[x]['mmbr_account_id'] + '</td>';
                        editableCol += '<td>' + data[x]['mmbr_name'] + '</td>';
                        editableCol += '<td>' + data[x]['mmbr_nic'] + '</td>';
                        editableCol += '<td>' + data[x]['mmbr_address'] + '</td>';
                        editableCol += '<td><a href="shareInfo/' + data[x]['ledger'] + '" class="btn btn-small btn-info">Shares</a></td>';
                        '</tr>';
                        rowindexCompo++;
                    }
                    $('#sharesInfo').before(editableCol);
                }
            });//end AJAX POST
        });
    });
</script>