      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
          <a class="sidebar-brand footer_logo_container d-flex align-items-center justify-content-center" href="">
      <img src="<?= base_url('assets/img/dotsync_logo_dark.png') ?>" alt="" class="p-0 footer_logo">
    
     </a>
            <span>Copyright &copy; <?= date("Y") ?> - DotSync</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

      </div>
      <!-- End of Page Wrapper -->

      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>

     <!-- Logout Modal-->
     <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog rounded-x modal-dialog-centered" role="document">
          <div class="modal-content rounded-x">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary btn-sm rounded-x" type="button" data-dismiss="modal">Cancel</button>
              <a class="btn btn-primary btn-sm rounded-x" href="<?= base_url('auth/logout') ?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Bootstrap core JavaScript-->
      <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
      <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- Core plugin JavaScript-->
      <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

      <!-- Custom scripts for all pages-->
      <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

      <!-- Page level plugins -->
      <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

      <!-- Page level custom scripts -->
      <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

      </body>

      </html>