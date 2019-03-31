<script src="{{asset('vendor/AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="{{asset('vendor/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('vendor/AdminLTE/bower_components/fastclick/lib/fastclick.js')}}"></script>

{{-- <script>
	$('[data-toggle="push-menu"]').attr('expandOnHover',true);
</script> --}}

{{-- <script>
	$(function(){
		if ($(window).width() <= 700 ) {
			$('body').removeClass('sidebar-collapse');
		} 
	})
</script> --}}

<script src="{{asset('vendor/AdminLTE/dist/js/adminlte.min.js')}}"></script>
{{-- <script src="{{asset('vendor/AdminLTE/dist/js/demo.js')}}"></script> https://adminlte.io/docs/2.4/js-push-menu   --}}

<script src="{{asset('vendor/layer.js')}}"></script>

<script src="{{asset('vendor/AdminLTE/plugins/pace/pace.min.js')}}"></script>
<script>
	
	$(document).ajaxStart(function() { Pace.restart(); }); 
</script>