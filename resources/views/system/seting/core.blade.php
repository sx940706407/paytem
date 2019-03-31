@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 系统配置 <small>v 2.0</small></div>
                        <p class="page-header-description"></p>
                    </div>
                </div>

            </div>
<div class="row-content am-cf">
                <div class="row am-cf">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-6">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">基本配置</font></font></div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form">
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">网站名称：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="sitename" placeholder="如：CO聚合支付" value="V2演示站点 - CO云支付 | 新版聚合支付">
                                        </div>
                                    </div> 
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">网站URL：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="siteurl" placeholder="如：http://www.codeo.cn 最后不带/" value="http://v2.paytem.cn">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">网站邮箱：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="sitemail" placeholder="如：dev@codeo.cn" value="admin@paytem.cn">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">公司名称：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="sitecom" placeholder="如：天亿网络科技有限公司" value="天亿网络科技有限公司">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系电话：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="sitephone" placeholder="网站联系电话（帮助中心/首页）" value="(020)-12345678">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系ＱＱ：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="siteqq" placeholder="网站联系QQ（帮助中心）" value="15130727">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系微信：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="siteweixin" placeholder="网站联系微信（帮助中心）" value="weixinhao">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">备案编号：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="sitebeian" placeholder="网站的备案号" value="粤A88888">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-intro" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">网站开关：</font></font></label>
                                        <div class="am-u-sm-9">
                                            <div class="tpl-switch">
                                                <input type="checkbox" id="sitestatus" value="" class="ios-switch bigswitch tpl-switch-btn" checked="">
                                                <div class="tpl-switch-btn-view">
                                                    <div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="button" onclick="xgjbpz()" class="am-btn am-btn-primary tpl-btn-bg-color-success ">保存设置</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-6">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">核心配置</font></font></div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form">
                                    <div class="am-form-group">
                                        <label for="user-intro" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">注册开关：</font></font></label>
                                        <div class="am-u-sm-9">
                                            <div class="tpl-switch">
                                                <input type="checkbox" onclick="javascript:if(this.checked){$('#zcfs').show();}else{$('#zcfs').hide();};" id="regstatus" value="" class="ios-switch bigswitch tpl-switch-btn">
                                                <div class="tpl-switch-btn-view">
                                                    <div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="am-form-group" id="zcfs" hidden="">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">注册方式：</label>
                                        <div class="am-u-sm-9">
                                            <select id="regfs" data-am-selected="" style="display: none;">
                                            <option value="ptzc">普通注册</option>
                                            <option value="yxzc">邮箱验证</option>
                                            <option value="sjzc" selected="selected">手机验证</option>
                                            </select><div class="am-selected am-dropdown " id="am-selected-qe0id" data-am-dropdown="">  <button type="button" class="am-selected-btn am-btn am-dropdown-toggle am-btn-default">    <span class="am-selected-status am-fl">手机验证</span>    <i class="am-selected-icon am-icon-caret-down"></i>  </button>  <div class="am-selected-content am-dropdown-content">    <h2 class="am-selected-header"><span class="am-icon-chevron-left">返回</span></h2>       <ul class="am-selected-list">                     <li class="" data-index="0" data-group="0" data-value="ptzc">         <span class="am-selected-text">普通注册</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="1" data-group="0" data-value="yxzc">         <span class="am-selected-text">邮箱验证</span>         <i class="am-icon-check"></i></li>                                 <li class="am-checked" data-index="2" data-group="0" data-value="sjzc">         <span class="am-selected-text">手机验证</span>         <i class="am-icon-check"></i></li>            </ul>    <div class="am-selected-hint"></div>  </div></div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-intro" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">接口开关：</font></font></label>
                                        <div class="am-u-sm-9">
                                            <div class="tpl-switch">
                                                <input type="checkbox" id="apistatus" value="" class="ios-switch bigswitch tpl-switch-btn" checked="">
                                                <div class="tpl-switch-btn-view">
                                                    <div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单名称：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="ptddmc" placeholder="提交到上级平台的订单名称（只能汉子或者字母）" value="CO云支付订单">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单时效：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="ddyxq" placeholder="订单的有效时间（单位为分钟），如：10" value="10">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">金额上限：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="zgje" placeholder="每笔订单最高提交的金额，如：10000.00（保留两位小数）" value="10000.000">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">金额下限：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="zdje" placeholder="每笔订单最低提交的金额，如：1.00（保留两位小数）" value="1.000">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">最低提现：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="zdtxje" placeholder="最低多少金额才能提现（只能输入整数）" value="10.000">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">提现费率：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="txsxf" placeholder="提现的手续费率（金额的百分比）" value="0.010">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">保底提现：</font></font><span class="tpl-form-line-small-title"><font style="vertical-align: inherit;"></font></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="txbdsxf" placeholder="如果手续费不超过此金额则以此金额为手续费(留空不设置)" value="3.000">
                                        </div>
                                    </div>
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="button" onclick="xghxpz()" class="am-btn am-btn-primary tpl-btn-bg-color-success ">保存设置</button>
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