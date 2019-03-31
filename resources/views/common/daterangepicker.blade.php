<link rel="stylesheet" href="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">

<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}">


<script src="{{ asset('bower_components/moment/moment.js') }}"></script>

<script src="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<script type="text/javascript">
    //Date range picker
    $('#reservation1').daterangepicker({
        // autoUpdateInput:false,

        "timePicker" : true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "autoApply" : true,
        ranges: {
            '最近1小时': [moment().subtract('hours',1), moment()], 
            '今日': [moment().startOf('day'), moment()], 
            '昨日': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')], 
           '7天': [moment().subtract(7, 'days'), moment()],
           '30天': [moment().subtract(30, 'days'), moment()],
           '这个月': [moment().startOf('month'), moment().endOf('month')],
           '上个月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },

      "autoApply" : true,
      opens: 'center',
      locale : {
        applyLabel: '确定',
        cancelLabel: '取消',
        fromLabel: '起始时间',
        toLabel: '结束时间',
        customRangeLabel: '自定义',
        daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
           '七月', '八月', '九月', '十月', '十一月', '十二月'],
        format : 'YYYY-MM-DD HH:mm:ss'
      }
    });
</script>
