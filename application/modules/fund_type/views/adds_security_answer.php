<section class="content">
    <div class="container">
        <h2>Add Fund</h2>
        <p><a href="<?php echo base_url('fund_type/index'); ?>">Fund</a></p>
        <?php echo form_open('fund_type/update_security_answer', ['id' => 'securityAnswerForm']); ?>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="phonenumber" class="form-control" placeholder="Phone Number" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="security_answer" class="form-control" placeholder="Security Answer"
                        required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Update Security Answer</button>
            </div>
        </div>

        <?php echo form_close(); ?>



    </div>
</section>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
<script>
$(document).ready(function () {
    $('#securityAnswerForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "<?php echo site_url('fund_type/update_security_answer'); ?>", // URL for the form submission
            type: "POST", // Method of submission
            data: formData, // Data to be sent to the server
            dataType: 'json', // Expecting JSON response
            success: function(response) {
                console.log("Response received:", response); // Debugging

                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message, // Display the success message
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the dashboard after success
                            window.location.href = "<?php echo site_url('dashboard'); ?>";
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message, // Display the error message
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText); // Debugging

                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
