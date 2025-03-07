<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/admin/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/admin/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/admin/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/admin/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/admin/vendors/flag-icon-css/css/flag-icons.min.css">
    <link rel="stylesheet" href="/admin/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="/admin/css/bonus.css">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/admin/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/admin/images/favicon.png" />


    <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
    

  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <?= loadPartial($folder ,'sidebar') ?>
      <!-- message -->
      <?= loadPartial($folder ,'message') ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <?= loadPartial($folder ,'nav') ?>
        <!-- partial -->
        <div class="main-panel justify-content-between">
          <div class="content-wrapper">
            <?php loadViewFolder($folder ,$name, $data) ?>
          </div>
          <?= loadPartial($folder ,'footer') ?>
        </div>
        
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="/admin/js/bonus.js"></script>
    <!-- plugins:js -->
    <script src="/admin/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/admin/vendors/chart.js/chart.umd.js"></script>
    <!-- <script src="/admin/vendors/progressbar.js/progressbar.min.js"></script> -->
    <script src="/admin/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="/admin/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/admin/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="/admin/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/admin/js/off-canvas.js"></script>
    <script src="/admin/js/misc.js"></script>
    <script src="/admin/js/settings.js"></script>
    <script src="/admin/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/admin/js/proBanner.js"></script>
    <script src="/admin/js/dashboard.js"></script>
    <!-- End custom js for this page -->
    
    <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote/lang/summernote-vi-VN.min.js"></script>



    <!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script> -->
  </body>
</html>