<!--   Core JS Files   -->
<script src="/contents/assets/js/core/popper.min.js"></script>
<script src="/contents/assets/js/core/bootstrap.min.js"></script>
<script src="/contents/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="/contents/assets/js/plugins/chartjs.min.js"></script>
<script src="/contents/assets/js/plugins/Chart.extension.js"></script>

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
<!--<script async defer src="https://buttons.github.io/buttons.js"></script>-->
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/contents/assets/js/soft-ui-dashboard.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script src="/contents/assets/js/dataTables.bootstrap5.min.js"></script>