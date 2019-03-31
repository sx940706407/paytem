@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 短信设置 <small>v 2.0</small></div>
                        <p class="page-header-description"></p>
                    </div>
                </div>

            </div>
 <div class="row-content am-cf">
                <div class="row am-cf">
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">阿里云短信</font></font></div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form">
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">接口ＩＤ：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="smsid" placeholder="accessKeyId" value="LTAIIGm74G6bDnrT">
                                        </div>
                                    </div> 
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">接口密匙：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="smskey" placeholder="accessKeySecret" value="zI8rKkAGAjcL5Lp3DnYJoKdr97gKSA">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">短信签名：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="smsqm" placeholder="签名名称" value="CO聚合平台">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">短信模板：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="smsmb" placeholder="模板代码" value="SMS_123668451">
                                        </div>
                                    </div>
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="button" onclick="xgyx()" class="am-btn am-btn-primary tpl-btn-bg-color-success ">保存设置</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
            
@endsection


@section('js')
   
@endsection