<section class="content">
    <div class="container">
        <h2>Fund User</h2>

        <?php echo form_open('fund_admin_wallet/add_user_fund', ['id' => 'fundForm']); ?>

        <div class="row clearfix">
            <!-- Admin Phone (Hidden) -->
            <input type="hidden" id="admin_phone" name="admin_phone" value="<?php echo htmlspecialchars(empty($_SESSION['phonenumber']) ? '' : $_SESSION['phonenumber'], ENT_QUOTES, 'UTF-8'); ?>">

            <!-- Admin Username (Visible & Readonly) -->
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" id="admin_username" name="admin_username" class="form-control" placeholder="Admin Username" readonly required>
                </div>
            </div>

            <!-- User Phone -->
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" id="user_phone" name="user_phone" class="form-control" placeholder="User Phone Number" required>
                </div>
            </div>

            <!-- User Username -->
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" id="user_username" name="user_username" class="form-control" placeholder="User Username" readonly required>
                </div>
            </div>

            <!-- Description -->
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" id="description" name="description" class="form-control" placeholder="Description" required>
                </div>
            </div>

            <!-- Fund Type -->
            <div class="col-md-4">
                <div class="form-group">
                    <select id="fundname" name="fund_id" class="form-control">
                        <option value="">Select Fund</option>
                        <?php foreach ($fund_types as $fund): ?>
                        <option value="<?= $fund['id'] ?>"><?= $fund['fundname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Amount -->
            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Amount" readonly required>
                </div>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Add Fund</button>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Auto-fetch Admin Username based on session phone number
    let adminPhone = $("#admin_phone").val();
    if (adminPhone) {
        $.ajax({
            url: "<?= base_url('fund_admin_wallet/get_user_details') ?>",
            type: "POST",
            data: { phone: adminPhone },
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    $("#admin_username").val(response.user.username);
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            }
        });
    }

    // Fetch User Username
    $("#user_phone").on("blur", function() {
        let phone = $(this).val();
        $.ajax({
            url: "<?= base_url('fund_admin_wallet/get_user_details') ?>",
            type: "POST",
            data: { phone: phone },
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    $("#user_username").val(response.user.username);
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            }
        });
    });

    // Fetch Fund Amount
    $("#fundname").on("change", function() {
        let fund_id = $(this).val();
        $.post("<?= base_url('fund_admin_wallet/get_fund_details') ?>", { id: fund_id }, function(response) {
            if (response.status === 'success') {
                $("#amount").val(response.fund.amount);
            }
        }, 'json');
    });

    // Submit Form with Security Check
    $("#fundForm").submit(function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Security Check',
            input: 'text',
            inputLabel: 'Enter Security Answer',
            inputPlaceholder: 'Your security answer',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = $(this).serialize() + "&security_answer=" + result.value;

                $.post("<?= base_url('fund_admin_wallet/add_user_fund') ?>", formData, function(response) {
                    Swal.fire({
                        title: response.message,
                        icon: response.status === 'success' ? 'success' : 'error'
                    }).then(() => {
                        if (response.status === 'success') {
                            window.location.href = "<?= base_url('fund_admin_wallet/index') ?>";
                        }
                    });
                }, 'json');
            }
        });
    });
});
</script>
