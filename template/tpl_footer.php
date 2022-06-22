		<!-- /.content-wrapper -->
		<footer class="main-footer">
		    <strong>Bài tập lớn PHP - Nhóm 8.
		        <div class="float-right d-none d-sm-inline-block">
		            <b>Version</b> 1.0
		        </div>
		</footer>


		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
		    <!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
		</div>
		<!-- ./wrapper -->

		<!-- jQuery UI 1.11.4 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
		    integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
		    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<!-- AdminLTE App -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"
		    integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg=="
		    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<!-- Bootstrap 4 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"
		    integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg=="
		    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script type="text/javascript">
/** add active class and stay opened when selected */
var url = window.location;

// for sidebar menu entirely but not cover treeview
$('.sidebar ul.nav-sidebar a').filter(function() {
    return this.href == url && !this.href.includes("#");
}).addClass('active');

// for treeview
$('.sidebar ul.nav-treeview a').filter(function() {
    return this.href == url && !this.href.includes("#");
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
		</script>
		</body>

		</html>