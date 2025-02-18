<section class="content">
    <div class="container">
        <h2>Add Fund</h2>

        <?php echo form_open('fund_admin_wallet/add_fund', ['id' => 'fundForm']); ?>

        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                        readonly required>
                </div>
            </div>

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

            <div class="col-md-4">
                <div class="form-group">
                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Amount" readonly
                        required>
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
    $("#phone").on("blur", function() {
        let phone = $(this).val();

        $.ajax({
            url: "<?= base_url('fund_admin_wallet/get_user_details') ?>",
            type: "POST",
            data: {
                phone: phone
            },
            dataType: "json",
            success: function(response) {
                console.log("Server Response:", response); // Debugging

                if (response.status === 'success') {
                    $("#username").val(response.user.username);
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                Swal.fire("Error!", "Something went wrong", "error");
            }
        });
    });


    $("#fundname").on("change", function() {
        let fund_id = $(this).val();
        $.post("<?= base_url('fund_admin_wallet/get_fund_details') ?>", {
            id: fund_id
        }, function(response) {
            if (response.status === 'success') {
                $("#amount").val(response.fund.amount);
            }
        }, 'json');
    });

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
                $.post("<?= base_url('fund_admin_wallet/add_fund') ?>", formData, function(
                    response) {
                    Swal.fire(response.message, '', response.status === 'success' ?
                        'success' : 'error');
                }, 'json');
            }
        });
    });
});
</script>