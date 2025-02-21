<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card auth_form">
                    <div class="header">
                        <img class="logo" src="<?= base_url('assets/images/logo.svg') ?>" alt="">
                        <h5>Sign Up</h5>
                        <span>Register a new membership</span>
                    </div>

                    <?php echo form_open('auth/user_creation', ['id' => 'signupForm']); ?>
                    <div class="body">
                        <div class="input-group mb-3">
                            <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="phonenumber" class="form-control" placeholder="Phonenumber" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="password">
                                    <i class="zmdi zmdi-eye" id="togglePasswordIcon1"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                placeholder="Confirm Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="confirm_password">
                                    <i class="zmdi zmdi-eye" id="togglePasswordIcon2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                                <select name="user_type_id" class="form-control" required>
                                    <option value="" disabled selected>Select User Type</option>
                                    <option value="1">User</option>
                                    <option value="2">Admin</option>
                                </select>
                            </div>

                      
<!-- 

                        <div class="input-group mb-3">
                            <input type="text" name="userPhoneNumber" class="form-control" placeholder="Phone Number"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                            </div>
                        </div> -->

                        <div class="checkbox">
                            <input id="agree_terms" type="checkbox" name="agree_terms" required>
                            <label for="agree_terms">
                                I read and agree to the <a href="javascript:void(0);">terms of usage</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SIGN
                            UP</button>

                        <div class="signin_with mt-3">
                            <a class="link" href="<?= base_url('auth/login') ?>">You already have a membership?</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <div class="copyright text-center">
                    &copy;
                    <script>
                    document.write(new Date().getFullYear())
                    </script>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->

<script>
$(document).ready(function () {
    $("#signupForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: "<?= base_url('auth/user_creation'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Creating Admin...",
                    text: "Please wait while we process your request.",
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
                        window.location.href = "<?= base_url('auth/index'); ?>"; // Redirect after success
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message || "An error occurred. Please try again."
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
});
</script>

<script>
document.querySelectorAll(".toggle-password").forEach(item => {
    item.addEventListener("click", function() {
        let target = document.getElementById(this.getAttribute("data-target"));
        let icon = this.querySelector("i");

        if (target.type === "password") {
            target.type = "text";
            icon.classList.remove("zmdi-eye");
            icon.classList.add("zmdi-eye-off");
        } else {
            target.type = "password";
            icon.classList.remove("zmdi-eye-off");
            icon.classList.add("zmdi-eye");
        }
    });
});
</script>