<!-- jQuery Core Js -->
<script src="<?= base_url('assets/bundles/libscripts.bundle.js') ?>"></script>
<!-- Lib Scripts Plugin Js (jquery.v3.2.1, Bootstrap4 js) -->
<script src="<?= base_url('assets/bundles/vendorscripts.bundle.js') ?>"></script>
<!-- slimscroll, waves Scripts Plugin Js -->

<script src="<?= base_url('assets/bundles/jvectormap.bundle.js') ?>"></script> <!-- JVectorMap Plugin Js -->
<script src="<?= base_url('assets/bundles/sparkline.bundle.js') ?>"></script> <!-- Sparkline Plugin Js -->
<script src="<?= base_url('assets/bundles/c3.bundle.js') ?>"></script>

<script src="<?= base_url('assets/bundles/mainscripts.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/pages/index.js') ?>"></script>
<script src="<?= base_url('assets/bundles/datatablescripts.bundle.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/pages/tables/jquery-datatable.js') ?>"></script>
<!-- Custom Js -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="<?= base_url('assets/js/pages/charts/c3.js') ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".inset-0").delay(5000).fadeOut(300);
});
</script>
<style>
/* Custom style to change the date input icon to white */
input[type="date"]::-webkit-calendar-picker-indicator {
    background-color: white;
    /* Set background color of the icon to white */
    color: white;
    /* Change the icon color to white */
}

/* Optional: Change input background color when focused */
input[type="date"]:focus {
    background-color: #f0f0f0;
    /* Light background on focus */
}
</style>
</body>

</html>