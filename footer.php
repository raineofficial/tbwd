<!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.buttons.min.js"></script>
    <script src="js/dataTables.select.min.js"></script>
    
    <script>
					$(document).ready(function() {
						var table = $('#accounts').DataTable();

						$('#accounts tbody').on('click', 'tr', function () {
							var data = table.row( this ).data();
							alert( 'You clicked on '+data[0]+'\'s row' );
						} );
					} );
	</script>

</body>

</html>