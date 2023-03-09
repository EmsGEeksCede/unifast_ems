<?php include('../admin/db_connect.php') ?>
<div class="col-lg-12">
  <br>
  <br>
  <div class="row">
    <?php include 'view_attendee.php'; ?>
  </div>
</div>
<style>
  .item-img {
    height: 13rem;
    overflow: hidden;
  }
</style>
<!-- <script>
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
</script> -->