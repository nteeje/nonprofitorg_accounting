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

    
    <div class="row" id="credit">
        <div class="span4 offset3"><h1>Credit Information</h1></div>
        <div class="span3" style="padding: 15px">

            <input id="txtCreditSearch" name="txtCreditSearch" type="text" placeholder="Type Name,NIC or ID" class="search-query">

        </div>
        <div class="span1" style="padding: 15px">
            <a class="btn btn-info" href="#shares">Shares</a>
        </div>


    </div>
    <div class="row">
        <div class="span12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr><th>ID #</th><th>Name</th><th>NIC</th><th>Address</th><th>Reports</th></tr>      
                </thead>
                <tbody>
                    <tr id="" style="background-color: #F0F8FF"></tr>
                    <?php
                    foreach ($membersCredit as $value) {
                        echo '<tr id="creditInfo">'
                        . '<td>' . $value->mmbr_account_id . '</td>'
                        . '<td>' . $value->mmbr_name . '</td>'
                        . '<td>' . $value->mmbr_nic . '</td>'
                        . '<td>' . $value->mmbr_address . '</td>'
                        . '<td><a href="' . base_url() . 'admin/reports/creditInfo/' . $value->ledger . '" class="btn btn-small btn-warning">Credit</a></td>'
                        . '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" id="shares"><div class="span4 offset3"><h1>Shares Information</h1></div>
        <div class="span3" style="padding: 15px">
            <input id="txtShareSearch" name="txtShareSearch" type="text" placeholder="Type Name,NIC or ID.." class="search-query">
        </div>
        <div class="span1" style="padding: 15px">
            <a class="btn btn-warning" href="#credit">Shares</a>
        </div>
    </div>
    <div class="row" >
        <div class="span12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr><th>ID #</th><th>Name</th><th>NIC</th><th>Address</th><th>Reports</th></tr>      
                </thead>
                <tbody>
                    <?php
                    foreach ($membersShares as $Shares) {
                        echo '<tr id="sharesInfo">'
                        . '<td>' . $Shares->mmbr_account_id . '</td>'
                        . '<td>' . $Shares->mmbr_name . '</td>'
                        . '<td>' . $Shares->mmbr_nic . '</td>'
                        . '<td>' . $Shares->mmbr_address . '</td>'
                        . '<td><a href="' . base_url() . 'admin/reports/shareInfo/' . $Shares->ledger . '" class="btn btn-small btn-info">Shares</a></td>'
                        . '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#txtCreditSearch').on("keyup", function () {
            $.ajax({
                url: baseurl + "admin/reports/searchCredit",
                type: "POST",
                datatype: "json",
                data: {keyword: $('#txtCreditSearch').val()},
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
                        editableCol += '<td><a href="creditInfo/' + data[x]['ledger'] + '" class="btn btn-small btn-warning">Credit</a></td>';
                        '</tr>';
                        rowindexCompo++;
                    }
                    $('#creditInfo').before(editableCol);
                }
            });//end AJAX POST

        });
        
        $('#txtShareSearch').on("keyup", function () {
            $.ajax({
                url: baseurl + "admin/reports/searchShare",
                type: "POST",
                datatype: "json",
                data: {keyword: $('#txtShareSearch').val()},
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