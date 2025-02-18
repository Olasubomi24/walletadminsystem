<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card auth_form">
                    <div class="header">
                        <img class="logo" src="<?= base_url('assets/images/logo.svg') ?>" alt="">
                        <h5>Log in</h5>
                    </div>
                    <form id="loginForm">
                        <div class="body">
                            <div class="input-group mb-3">
                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text toggle-password" data-target="password">
                                        <i class="zmdi zmdi-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="checkbox">
                                <input id="remember_me" type="checkbox" name="remember_me">
                                <label for="remember_me">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SIGN IN</button>
                            <div class="signin_with mt-3">
                                <a class="link" href="<?= base_url('auth/forgot_password') ?>">Forgot Password?</a>
                                <br>
                                <a class="link" href="<?= base_url('auth/signup') ?>">Don't have an account? Sign up</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="copyright text-center">
                    &copy; <script>document.write(new Date().getFullYear())</script>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="<?= base_url('assets/images/signin.svg') ?>" alt="Sign In" />
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: "<?= base_url('auth/login'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function (xhr) {
                // Set the X-Requested-With header to identify AJAX requests
                xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

                Swal.fire({
                    title: "Logging in...",
                    text: "Please wait while we verify your credentials.",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                Swal.close();
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Login Successful!",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect || "<?= base_url('dashboard'); ?>";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed!",
                        text: response.message || "Invalid credentials, please try again."
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Something went wrong. Please try again."
                });
                console.error("AJAX Error:", status, error, xhr.responseText);
            }
        });
    });

    $(".toggle-password").on("click", function () {
        let target = $("#" + $(this).attr("data-target"));
        let icon = $(this).find("i");
        target.attr("type", target.attr("type") === "password" ? "text" : "password");
        icon.toggleClass("zmdi-eye zmdi-eye-off");
    });
});
</script>