<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- <div class="login-logo">
      <a href="#"><b>UniFAST Event Management Portal</b></a>
    </div> -->
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body">
        <div class="text-center">
          <img class="img-fluid " src="assets/uploads/UnifastLogo.png" width="40%" height="40%">
        </div>
        <div class="form-group">
          <h4 class="text-dark text-center">Event Management System</h4>
        </div>
        <form action="" id="login-form">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" autofocus required placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas bi-person"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password" class="form-control" name="password" required placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="bi bi-eye-slash" id="togglePassword"></span>
                <!-- <span class="fas fa-lock"></span> -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <!--- <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div> --->
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#login-form').submit(function(e) {
        e.preventDefault()
        start_load()
        if ($(this).find('.alert-danger').length > 0)
          $(this).find('.alert-danger').remove();
        $.ajax({
          url: 'admin/ajax.php?action=login2',
          method: 'POST',
          data: $(this).serialize(),
          error: err => {
            console.log(err)
            end_load();

          },
          success: function(resp) {
            if (resp == 1) {
              location.href = 'index.php?page=home';
            } else {
              $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
              end_load();
            }
          }
        })
      })
    })

    // script for password visibility
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener('click', function(e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye / eye slash icon
      this.classList.toggle('bi-eye');
    });
  </script>
  <?php include 'footer.php' ?>

</body>

</html>