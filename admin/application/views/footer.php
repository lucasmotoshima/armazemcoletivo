	</div>
</div>
		<footer>
		  <div class="pull-right">
		    ARMAZEMCOLETIVO by <a href="http://www.vbsbs.com.br"><small> VB Serviços</small></a>
		  </div>
		    <!-- jQuery -->
		    <script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
		    <!-- Bootstrap -->
		    <script src="<?=base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js')?>"></script>
		    <!-- FastClick -->
		    <script src="<?=base_url('assets/vendors/fastclick/lib/fastclick.js')?>"></script>
		    <!-- NProgress -->
		    <script src="<?=base_url('assets/vendors/nprogress/nprogress.js')?>"></script>
		    <!-- Chart.js -->
		    <script src="<?=base_url('assets/vendors/Chart.js/dist/Chart.min.js')?>"></script>
		    <!-- bootstrap-progressbar -->
		    <script src="<?=base_url('assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')?>"></script>
		    <!-- iCheck -->
		    <script src="<?=base_url('assets/vendors/iCheck/icheck.min.js')?>"></script>
		    <!-- Skycons -->
		    <script src="<?=base_url('assets/vendors/skycons/skycons.js')?>"></script>
		    <!-- Flot -->
		    <script src="<?=base_url('assets/vendors/Flot/jquery.flot.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/Flot/jquery.flot.pie.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/Flot/jquery.flot.time.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/Flot/jquery.flot.stack.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/Flot/jquery.flot.resize.js')?>"></script>
		    <!-- Flot plugins -->
		    <script src="<?=base_url('assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/flot-spline/js/jquery.flot.spline.min.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/flot.curvedlines/curvedLines.js')?>"></script>
		    <!-- DateJS -->
		    <script src="<?=base_url('assets/vendors/DateJS/build/date.js')?>"></script>
		    <!-- JQVMap -->
		    <script src="<?=base_url('assets/vendors/jqvmap/dist/jquery.vmap.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/jqvmap/dist/maps/jquery.vmap.world.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')?>"></script>
		    <!-- bootstrap-daterangepicker -->
		    <script src="<?=base_url('assets/vendors/moment/min/moment.min.js')?>"></script>
		    <script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')?>"></script>
		    <!-- bootstrap-datetimepicker -->    
		    <script src="<?=base_url('assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')?>"></script>
		    
		    <!-- Ion.RangeSlider -->
		    <script src="<?=base_url('assets/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js')?>"></script>
		    
		    <!-- jquery.inputmask -->
		    <!--script src="<?=base_url('assets/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')?>"></script-->
		
		    <!-- Custom Theme Scripts -->
		    <script src="<?=base_url('assets/build/js/custom.js')?>"></script>
			<script type="text/javascript">
				function alerta(title,msg){
					new PNotify({
			              title: title,
			              text: msg,
			              type: 'info',
			              styling: 'bootstrap3'
			          });
				}
		
				function limpaModal()
				{
			       	$('.modal-title').html('');
			       	$('.modal-body').html('');
				}
				
			</script>
			<div class="clearfix"></div>
		</footer>
		<!-- /footer content -->
	</body>
</div><!--main_container-->

</html>