<?php include('admin/db_connect.php') ?>
<div class="col-lg-12">
  <div class="row">
    <div class="col-md-12 mb-4">
      <br>
      <div class="input-group">
        <input type="search" id="filter" class="form-control form-control-lg" placeholder=" Type Event Information here">
        <div class="input-group-append">
          <button type="button" id="search" class="btn btn-lg btn-default">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
      <hr>
      <div class="col-md-12 py-2">
        <div class="row">
          <?php
          $events = $conn->query("SELECT * FROM tbl_events where id in (SELECT event_id from assigned_registrar where user_id = {$_SESSION['login_id']}) and unix_timestamp(datetime_start) <= '" . strtotime(date('Y-m-d H:i')) . "' order by unix_timestamp(datetime_end) desc");

          // $events = $conn->query("SELECT * FROM tbl_events where id in (SELECT event_id from assigned_registrar where user_id = {$_SESSION['login_id']}) and '" . strtotime(date('datetime_start')) . "' <  unix_timestamp(datetime_end) ");

          while ($row = $events->fetch_assoc()) :
            $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
            unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
            $desc = strtr(html_entity_decode($row['description']), $trans);
            // $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
          ?>
            <a class="event-item text-dark" href="./index.php?page=manage_attendance&c=<?php echo md5($row['id']) ?>" data-id='<?php echo $row['id'] ?>'>
              <div class="card card-widget widget-user mx-1 my-1" style="width: 15rem;">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                  <h3 class="widget-user-username"><b><?php echo ucwords($row['event']) ?></b></h3>
                  <h5 class=""><i><?php echo ucwords($row['venue']) ?></i></h5>
                </div>
                <div class="card-footer">
                  <div class="d-block py-1 px-1 w-100">
                    <p class="truncate"><?php echo strip_tags($desc) ?></p>
                  </div>
                  <?php if (strtotime($row['datetime_start']) > time()) :  ?>
                    <span class="badge badge-info">Pending</span>
                  <?php elseif ((strtotime($row['datetime_start']) < time()) && (strtotime($row['datetime_end']) > time())) : ?>
                    <span class="badge badge-success">On-Going</span>
                  <?php elseif (strtotime($row['datetime_end']) <= time()) : ?>
                    <span class="badge badge-danger">Close</span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .item-img {
    height: 13rem;
    overflow: hidden;
  }
</style>
<script>
  $('.event-item').hover(function() {
    $(this).find('.card').addClass('border border-info')
  })
  $('.event-item').mouseleave(function() {
    $(this).find('.card').removeClass('border border-info')
  })

  function _search() {
    var _f = $('#filter').val()
    _f = _f.toLowerCase();
    $('.event-item').each(function() {
      var txt = $(this).text().toLowerCase()
      if (txt.includes(_f) == true) {
        $(this).toggle(true)

      } else {
        $(this).toggle(false)

      }
    })
  }
  $('#search').click(function() {
    _search()
  })
  $('#filter').on('keypress', function(e) {
    if (e.which == 13) {
      _search()
      return false;
    }
  })
  $('#filter').on('search', function() {
    _search()
  });
</script>