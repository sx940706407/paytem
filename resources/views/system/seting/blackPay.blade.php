@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 掉单设置 <small>v 2.0</small></div>
                        <p class="page-header-description"></p>
                    </div>
                </div>

            </div>          
<div class="row-content am-cf">
                <div class="row am-cf">
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">掉单规则</font></font></div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form">
                                    <div class="am-form-group">
                                        <label for="user-intro" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">掉单开关：</font></font></label>
                                        <div class="am-u-sm-9">
                                            <div class="tpl-switch">
                                                <input type="checkbox" id="ddstatus" onclick="qiehuan(this)" value="" class="ios-switch bigswitch tpl-switch-btn">
                                                <div class="tpl-switch-btn-view">
                                                    <div>
                                                    </div>
                                                </div>
                                            </div>
                                            <small><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">俗称“黑单”：当商户提交订单并付款时不记录该订单，金额归平台所有！(慎重)</font></font></small>
                                        </div>
                                    </div>
                                    <div class="am-form-group" id="qhddkssj" hidden="">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">开始时间：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="ddkssj" placeholder="掉单时间段开始时间（开始掉单）" value="1">
                                        </div>
                                    </div>
                                    <div class="am-form-group" id="qhddjssj" hidden="">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">结束时间：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="ddjssj" placeholder="掉单时间段结束时间（超过不掉单）" value="23">
                                        </div>
                                    </div>
                                    <div class="am-form-group" id="qhddsksje" hidden="">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">起始金额：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="ddsksje" placeholder="最低从此金额开始掉单" value="1">
                                        </div>
                                    </div>
                                    <div class="am-form-group" id="qhddsjsje" hidden="">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">结束金额：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="ddsjsje" placeholder="最高达到此金额时不掉单" value="50">
                                        </div>
                                    </div>
                                    <div class="am-form-group" id="qhddbfbjl" hidden="">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">掉单几率：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="ddbfbjl" placeholder="输入1-100的整数几率（百分比）" value="90">
                                        </div>
                                    </div>
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="button" onclick="xgddgz()" class="am-btn am-btn-primary tpl-btn-bg-color-success ">保存设置</button>
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