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
            <a  href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
    </div>

    <div class="row">
        <div class="span12 columns">
            <div class="well">           
                <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');

                //save the columns names in a array that we will use as filter         
                $options_ledgers = array();
                foreach ($ledgers as $array) {
                    foreach ($array as $key => $value) {
                        $options_ledgers[$key] = $key;
                    }
                    break;
                }

                echo form_open('admin/ledgers', $attributes);

                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected, 'placeholder="Type Member Account ID"');

                echo form_label('Order by:', 'order');
                echo form_dropdown('order', $options_ledgers, $order, 'class="span2"');

                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

                echo form_submit($data_submit);

                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">NIC #</th>
                        <th class="yellow header headerSortDown">Ledger ID</th>
                        <th class="yellow header headerSortDown">Ledger Type</th>
                        <th class="yellow header headerSortDown">Open Balance</th>
                        <th class="yellow header headerSortDown">Op.Balnce Type</th>
                        <th class="yellow header headerSortDown">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($ledgers as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['member'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['group_id'] . '</td>';
                        echo '<td>' . $row['op_balance'] . '</td>';
                        echo '<td>' . $row['op_balance_dc'] . '</td>'; 
                        echo '<td class="crud-actions">
                  <a href="' . site_url("admin") . '/ledgers/update/' . $row['id'] . '" class="btn btn-info">view & edit</a>  
                 
                </td>';
                        echo '</tr>';
                    }
                    ?>      
                </tbody>
            </table>

            <?php echo '<div class="pagination">' . $this->pagination->create_links() . '</div>'; ?>

        </div>
    </div>
</div>