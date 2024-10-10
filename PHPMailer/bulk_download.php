<?php
$title = "Bulk Download - Users and Extensions";
$button = "true";
include_once "inc/header.php";
include_once "inc/sidebar.php";
include_once "inc/navbar.php";
// include_once "report.inc.php";


if ($_SERVER['REMOTE_ADDR'] == "103.164.240.115" || $_SERVER['REMOTE_ADDR'] == "103.110.172.6"
) {
    $fetchUsersAndExts = mysqli_query($app->connect(), "SELECT user.sms as sms_number,ext.extension,ext.password, user.username, ext.outbound_caller_id_number, ext.emp_name, user.user_pass FROM v_extensions ext JOIN v_extension_users ext_user ON ext.extension_uuid = ext_user.extension_uuid JOIN v_users user ON user.user_uuid = ext_user.user_uuid WHERE ext.domain_uuid='" . $_SESSION['domain_change'] . "' AND user.user_enabled = 'true';");
    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header p-3" style="background:#3A5BA0 ;color:white;">
                    <h3 style="display:inline;"> Bulk Download</h3>
                    <div class="btn-showcase mb-0 float-end" style="display:inline;">
                    <?php include_once "inc/domain_selector.php" ?>
                        <?php 
                        if (!empty($_GET['start_stamp_begin']) && !empty($_GET['start_stamp_end'])) { ?>
                            <button class="btn-sm btn-light" onclick="document.getElementById('frm_export').submit();"><i class="fa fa-download"></i> Download CSV</button>
                        <?php } ?>
                    </div>
                </div>

                <div class="card-body pb-3 pt-3">

                <?php
                
                ?>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Web Login</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Extension Login</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Both</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                


                <div class="alert alert-primary mt-2 mb-0 shadow" style="">
        <div class="row">
            <div class="col-lg-10" style="display:flex;align-items:center;justify-content:left;">
            Web Login - Means Only Web-Login Credentials Will Be Displayed, They Can Only Login With unifiedpbx.uvcpbx.in Domain
            </div>
            <div class="col-lg-2" style="display:flex;align-items:center;justify-content:center;">
                <button onclick="downloadTableAsCSV('web_login', 'Web Login Credentials - <?php echo $_SESSION['domain_change_name'] ?>.csv')" class="btn alert-primary shadow" style="border:2px solid black;">Download</button>
            </div>
        </div>
  </div> 


                <table class="table mt-0" id="web_login">
                            <thead>
                                <th>Employee Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>SMS Number</th>
                                <th>Caller ID</th>
                                <th>Login URL</th>
                            </thead>
                            <tbody>
                                <?php 
                                    while($row = mysqli_fetch_assoc($fetchUsersAndExts)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row['emp_name']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $app->decrypt($row['user_pass']); ?></td>
                                            <td><?php echo $row['sms_number']; ?></td>
                                            <td><?php echo $row['outbound_caller_id_number']; ?></td>
                                            <td>unifiedpbx.uvcpbx.in</td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                    </table>

  </div>
  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
  <?php
                                // print_r($fetchUsersAndExts);
                                
                            ?>

  <div class="alert alert-primary mt-2 mb-0 shadow" style="">
        <div class="row">
            <div class="col-lg-10"  style="display:flex;align-items:center;justify-content:left;">
                Extension Login - Means Only Extension-Login Credentials Will Be Displayed, They Can Only Login With <?php echo $_SESSION['domain_change_name'] ?> Domain in Their Soft-Phone (xLite, ZoIPer, etc)
            </div>
            <div class="col-lg-2" style="display:flex;align-items:center;justify-content:center;">
                <button onclick="downloadTableAsCSV('extension_login', 'Extension Login Credentials - <?php echo $_SESSION['domain_change_name'] ?>.csv')" class="btn alert-primary shadow" style="border:2px solid black;">Download</button>
            </div>
        </div>
  </div> 

<table class="table mt-0" id="extension_login">
                            <thead>
                                <th>Employee Name</th>
                                <th>Extension</th>
                                <th>Password</th>
                                <th>SMS Number</th>
                                <th>Caller ID</th>
                                <th>Domain</th>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($fetchUsersAndExts as $user){
                                        ?>
                                        <tr>
                                        <td><?php echo $user['emp_name']; ?></td>
                                        <td><?php echo $user['extension']; ?></td>
                                        <td><?php echo $user['password']; ?></td>
                                        <td><?php echo $user['sms_number']; ?></td>
                                        <td><?php echo $user['outbound_caller_id_number']; ?></td>
                                        <td><?php echo $_SESSION['domain_change_name']; ?></td>
                                    </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                    </table>
  </div>
  <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
  
  <div class="alert alert-primary mt-2 mb-0 shadow" style="">
        <div class="row">
            <div class="col-lg-10"  style="display:flex;align-items:center;justify-content:left;">
            Both - Means Extension and User Credentials Both Will Be Displayed, They Can Login With unifiedpbx.uvcpbx.in (Web Login) / <?php echo $_SESSION['domain_change_name'] ?> (Softphone) Domain
            </div>
            <div class="col-lg-2" style="display:flex;align-items:center;justify-content:center;">
                <button onclick="downloadTableAsCSV('extension_and_users', 'Users and Extensions Credentials - <?php echo $_SESSION['domain_change_name'] ?>.csv')" class="btn alert-primary shadow" style="border:2px solid black;">Download</button>
            </div>
        </div>
  </div> 


<div class="table-responsive">
<table class="table mt-0" id="extension_and_users">
                            <thead>
                                <th>Employee Name</th>
                                <th>Username</th>
                                <th>Web Password</th>
                                <th>Extension</th>
                                <th>Extension Password</th>
                                
                                <th>SMS Number</th>
                                <th>Caller ID</th>
                                <th>Login URL</th>
                                <th>Extension Domain</th>
                               
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($fetchUsersAndExts as $user){
                                        ?>
                                        <tr>
                                        <td><?php echo $user['emp_name']; ?></td>
                                        <td><?php echo $user['username']; ?></td>
                                        <td><?php echo $app->decrypt($user['user_pass']); ?></td>
                                        <td><?php echo $user['extension']; ?></td>
                                        <td><?php echo $user['password']; ?></td>
                                        <td><?php echo $user['sms_number']; ?></td>
                                        <td><?php echo $user['outbound_caller_id_number']; ?></td>
                                        <td>unifiedpbx.uvcpbx.in</td>
                                        <td><?php echo $_SESSION['domain_change_name']; ?></td>
                                        
                                    </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                    </table>
                                </div>

  </div>
</div>

                    

                </div>
            </div>
        </div>
    </div>

   

<?php } else {
    ?>
<div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-danger p-3" style="color:white;">
                    <h3 style="display:inline;">Access Denied</h3>
                </div>

                <div class="card-body pb-3 pt-3">

                    

                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script>
function downloadTableAsCSV(tableId, filename) {
  const table = document.getElementById(tableId);

  // Create an empty CSV string
  let csv = '';

  // Loop through each row in the table
  for (let i = 0; i < table.rows.length; i++) {
    const row = table.rows[i];

    // Loop through each cell in the row
    for (let j = 0; j < row.cells.length; j++) {
      const cell = row.cells[j];

      // Add the cell value to the CSV string
      csv += cell.innerText.trim();

      // Add a comma after each cell value, except for the last one in the row
      if (j < row.cells.length - 1) {
        csv += ',';
      }
    }

    // Add a new line character after each row
    csv += '\n';
  }

  // Create a download link element
  const link = document.createElement('a');
  link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
  link.download = filename;

  // Simulate a click on the link to trigger the download
  link.click();
}

    </script>
<?php
include_once "inc/footer.php";
mysqli_close($app->connect());
?>
