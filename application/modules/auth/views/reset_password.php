<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card auth_form">
                    <div class="header">
                        <img class="logo" src="<?= base_url('assets/images/logo.svg') ?>" alt="">
                        <h5>Reset Password</h5>
                    </div>
                    <form id="resetPasswordForm">
                        <div class="body">
                            <!-- <input type="hidden" name="user_type_id" value="<?// = $this->session->userdata('user_type_id'); ?>"> -->
                            <div class="input-group mb-3">
                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text toggle-password" data-target="new_password">
                                        <i class="zmdi zmdi-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text toggle-password" data-target="confirm_password">
                                        <i class="zmdi zmdi-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">UPDATE PASSWORD</button>
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
    $("#resetPasswordForm").submit(function (event) {
        event.preventDefault();

        const newPassword = $("input[name='new_password']").val();
        const confirmPassword = $("input[name='confirm_password']").val();

        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Passwords do not match."
            });
            return;
        }

        $.ajax({
            url: "<?= base_url('auth/reset_password_update'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                Swal.fire({
                    title: "Updating Password...",
                    text: "Please wait while we update your password.",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                Swal.close();
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "<?= base_url('auth/index'); ?>";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message || "Failed to update password."
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