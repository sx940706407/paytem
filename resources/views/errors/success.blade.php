@if (Session::has('success'))

<script src="{{asset('vendor/AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/layer.js')}}"></script>


<script type="text/javascript">
        layer.msg('{{Session::get('success')}}');
</script>

@endif
