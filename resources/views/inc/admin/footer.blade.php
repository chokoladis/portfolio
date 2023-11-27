    </div>
    <!-- /.content-wrapper -->

    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('/dist/js/adminlte.js') }}"></script>

  @vite(['resources/js/app.js'])
  @stack('scripts')
  @include('inc.modal.response')
  <!-- поменять проверку на ? -->
  @if (Route::current()->getName() == 'admin.works')
    @include('inc.modal.work_create')
    @include('inc.modal.work_edit')
  @endif    
  @if (Route::current()->getName() == 'admin.menu')
    @include('inc.modal.menu_add')
    @include('inc.modal.menu_edit')
  @endif
</body>
</html>
