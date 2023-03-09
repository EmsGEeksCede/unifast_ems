<?php include('db_connect.php') ?>
<!-- Info boxes -->
<?php if ($_SESSION['login_type'] == 1) : ?>
  <div class="row">

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-friends"></i></span>
        <div class="info-box-content">
          <!-- <a href="./index.php?page=staff_list"> -->
            <span class="info-box-text">Staff Account</span></a>
          <span class="info-box-number">
            <?php echo $conn->query("SELECT * FROM tbl_user_accounts where type != 3")->num_rows; ?>
          </span>
        </div>
      </div>
    </div>


    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
          <!-- <a href="./index.php?page=attendees_list"> -->
            <span class="info-box-text">Attendees Account</span></a>
          <span class="info-box-number">
            <?php echo $conn->query("SELECT * FROM tbl_user_accounts where type = 3")->num_rows; ?>
          </span>
        </div>
      </div>
    </div>


    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-alt"></i></span>

        <div class="info-box-content">
          <!-- <a href="./index.php?page=event_list"> -->
            <span class="info-box-text">Total Events</span></a>
          <span class="info-box-number">
            <?php echo $conn->query("SELECT * FROM tbl_events")->num_rows; ?>
          </span>
        </div>
      </div>
    </div>


    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-calendar-week"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pending Events</span>
          <span class="info-box-number"><?php echo $conn->query("SELECT * FROM tbl_events where unix_timestamp(datetime_start) > '" . strtotime(date('Y-m-d H:i')) . "' ")->num_rows; ?></span>
        </div>
      </div>
    </div>


    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-day"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">On-Going Events</span>
          <span class="info-box-number"><?php echo $conn->query("SELECT * FROM tbl_events where '" . strtotime(date('Y-m-d H:i')) . "' between unix_timestamp(datetime_start) and unix_timestamp(datetime_end) ")->num_rows; ?></span>
        </div>
      </div>
    </div>


    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-check"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Finished Events</span>
          <span class="info-box-number"><?php echo $conn->query("SELECT * FROM tbl_events where unix_timestamp(datetime_end) <= '" . strtotime(date('Y-m-d H:i')) . "' ")->num_rows; ?></span>
        </div>
      </div>
    </div>

  </div>

<?php else : ?>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        Welcome <?php echo $_SESSION['login_name'] ?>!
      </div>
    </div>
  </div>

<?php endif; ?>