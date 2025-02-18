<section class="content">
    <div class="container">
        <h2>Edit Fund</h2>
        <p><a href="<?php echo base_url('fund_type/index'); ?>">Back to Fund List</a></p>
        <?php echo form_open('fund_type/update_fund', ['id' => 'editFundForm']); ?>
        <input type="hidden" name="id" value="<?php echo $fund['id']; ?>">
        <div class="row clearfix">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fund Name</label>
                    <input type="text" name="fundname" class="form-control" placeholder="Fund Name" value="<?php echo set_value('fundname', $fund['fundname']); ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" step="0.1" name="amount" class="form-control" placeholder="Amount" value="<?php echo set_value('amount', $fund['amount']); ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Inserted By</label>
                    <input type="text" name="insert_by" class="form-control" placeholder="Insert By" value="<?= empty($_SESSION['user_name']) ? '' : $_SESSION['user_name']; ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="0" <?php echo ($fund['status'] === '0') ? 'selected' : ''; ?>>Active</option>
                        <option value="1" <?php echo ($fund['status'] === '1') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success mt-2">Update Fund</button>
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
    $('#editFundForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        let formData = $(this).serialize(); // Serialize form data
        $.ajax({
            url: "<?php echo base_url('fund_type/update_fund'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Response received:", response); // Debugging
                if (response.status === 'success') {
                    Swal.fire("Success!", response.message, "success")
                        .then(() => window.location.href = "<?php echo base_url('fund_type/index'); ?>");
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                Swal.fire("Error!", "An unexpected error occurred.", "error");
            }
        });
    });
});
</script>