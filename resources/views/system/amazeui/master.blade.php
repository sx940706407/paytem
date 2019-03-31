<html lang="en" class="js cssanimations">

<head>
        @include('system/amazeui/css')

        @yield('css')

        <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body data-type="index" class="theme-black" style="">
    <script src="{{ asset('vendor/assets/js/theme.js') }}"></script>
    <div class="am-g tpl-g">

        @include('system/amazeui/header')
        <!-- 风格切换 -->
        <div class="tpl-skiner">
            <div class="tpl-skiner-toggle am-icon-cog">
            </div>
            <div class="tpl-skiner-content">
                <div class="tpl-skiner-content-title">
                    选择主题
                </div>
                <div class="tpl-skiner-content-bar">
                    <span class="skiner-color skiner-white" data-color="theme-white"></span>
                    <span class="skiner-color skiner-black" data-color="theme-black"></span>
                </div>
            </div>
        </div>
    
    @include('system/amazeui/sidebar')

                <!-----修改密码----->
                <div id="head_tjgl" class="am-modal am-modal-no-btn" tabindex="-1">
                 <div class="am-modal-dialog">
                  <div class="am-modal-hd">修改密码
                   <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close="">×</a>
                  </div>
                  <div class="am-modal-bd">
                        <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed am-no-layout">
                <div class="am-g">
                 <div class="am-u-md-8 am-u-sm-centered">
                  <form class="am-form">
                    <fieldset class="am-form-set">
                       <input type="password" value="" id="head_tjgl_ypass" placeholder="原密码"><br>
                       <input type="password" value="" id="head_tjgl_xpass" placeholder="新密码"><br>
                       <input type="password" value="" id="head_tjgl_qrpass" placeholder="确认密码"><br>
                   </fieldset>
                   <button onclick="head_tjgl(this)" value="admin" type="button" class="am-btn am-btn-primary am-btn-block">确认修改</button>
                  </form>
                 </div>
                </div>
                    </div>
                 </div>
                </div>
                <!-----修改密码----->


                <script>
    function head_tjgl(obj){//修改密码
        $.ajax({
            url:'gllb.php',
            data:{
                ypass:$('#head_tjgl_ypass').val(),
                xpass:$('#head_tjgl_xpass').val(),
                qrpass:$('#head_tjgl_qrpass').val(),
                user:$(obj).val(),
                action:'xiugaimima',
            },
            dataType:'JSON',
            type:'POST',
            success:function(data){
                $('#ts').modal();
                $('#te').html(data.te);
                if(data.ok){
                    $('#head_tjgl').modal('close');
                    setTimeout(function(){
                        window.location.href="index.php?action=out";//注销
                    },1000);
                }
            },
            error:function(){
                $('#ts').modal();
                $('#te').html("获取数据错误");
            },
        })
    }
    </script>        <!-- 内容区域 -->



        <div class="tpl-content-wrapper">
                @yield('content')
        </div>


    </div>
    
    @include('system/amazeui/js')


@yield('js')



</body>


</html>