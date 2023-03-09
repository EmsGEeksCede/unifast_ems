<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body">
        <div class="text-center">
          <img class="img-fluid " src="../assets/uploads/em.png" width="70%" height="70%">
        </div>
        <hr class="my-3">
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
          <div class="row justify-content-center">
            <!-- <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div> -->
            <!-- /.col -->
            <div class="col-6">
              <button type="submit" class="btn btn-primary btn-block btn-wave">LOGIN</button>
            </div>
            <!-- /.col -->
          </div>
          <hr class="my-4">
          <p class="text-center mb-0">Don't have an account? <a href="signup.php" class="link-info">Sign Up</a></p>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

  <style>
    .link-info {
      transition: all 150ms;
    }

    .link-info:hover {
      color: darkslateblue;
    }
  </style>

  <!-- /.login-box -->
  <script>
    $(document).ready(function() {
      $('#login-form').submit(function(e) {
        e.preventDefault()
        start_load()
        if ($(this).find('.alert-danger').length > 0)
          $(this).find('.alert-danger').remove();
        $.ajax({
          url: '../admin/ajax.php?action=login3',
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