<!--   Core JS Files   -->
<script src="<?= APP_ROOT ?>/contents/assets/js/core/popper.min.js"></script>
<script src="<?= APP_ROOT ?>/contents/assets/js/core/bootstrap.min.js"></script>
<script src="<?= APP_ROOT ?>/contents/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?= APP_ROOT ?>/contents/assets/js/plugins/chartjs.min.js"></script>
<script src="<?= APP_ROOT ?>/contents/assets/js/plugins/Chart.extension.js"></script>

<script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= APP_ROOT ?>/contents/assets/js/soft-ui-dashboard.min.js?v=1.0.2"></script>