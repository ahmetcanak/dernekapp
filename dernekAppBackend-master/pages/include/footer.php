<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                © <script>document.write(new Date().getFullYear())</script> E&B Software <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by <b>Okan İrtiş</b>.</span>
            </div>
        </div>
    </div>
</footer>

</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
<div data-simplebar class="h-100">
<div class="rightbar-title px-3 py-4">
    <a href="javascript:void(0);" class="right-bar-toggle float-right">
        <i class="mdi mdi-close noti-icon"></i>
    </a>
    <h5 class="m-0">Ayarlar</h5>
</div>

<!-- Settings -->
<hr class="mt-0" />
<h6 class="text-center">Tasarım Seçin</h6>

<div class="p-4">
    <div class="mb-2">
        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
    </div>
    <div class="custom-control custom-switch mb-3">
        <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
        <label class="custom-control-label" for="light-mode-switch">Light Mod</label>
    </div>

    <div class="mb-2">
        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
    </div>
    <div class="custom-control custom-switch mb-3">
        <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css"
            data-appStyle="assets/css/app-dark.min.css" />
        <label class="custom-control-label" for="dark-mode-switch">Karanlık Mod</label>
    </div>

</div>

</div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>

<!-- PAGE SCRIPTS -->
<?php foreach($footer_scripts as $script){ ?>
  <script src="<?php echo $script; ?>"></script>
<?php } ?>

<script src="assets/js/app.js"></script>

</body>

</html>
