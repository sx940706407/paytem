@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 添加商户 <small>v 2.0</small></div>
                        <p class="page-header-description"></p>
                    </div>
                </div>

            </div>

<div class="row-content am-cf">
                <div class="row  am-cf">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-10">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加商户</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">

                                <form class="am-form tpl-form-line-form">
                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">商户名称：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="shmc" placeholder="由16位字母或与数字组成">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">商户密码：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="shmm" placeholder="初始密码只能数字或字母（不超过12位数）">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">商户手机：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="shsj" placeholder="11位数手机号码">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">商户邮箱：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="shyx" placeholder="如：dev@codeo.cn">
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">联系ＱＱ：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="lxqq" placeholder="联系QQ或者微信">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">商户性别：</label>
                                        <div class="am-u-sm-9">
                                            <select id="shxb" data-am-selected="" required="" style="display: none;">
                                            <option value="男">男</option>
                                            <option value="女">女</option>
                                            </select><div class="am-selected am-dropdown " id="am-selected-thabk" data-am-dropdown="">  <button type="button" class="am-selected-btn am-btn am-dropdown-toggle am-btn-default">    <span class="am-selected-status am-fl">男</span>    <i class="am-selected-icon am-icon-caret-down"></i>  </button>  <div class="am-selected-content am-dropdown-content">    <h2 class="am-selected-header"><span class="am-icon-chevron-left">返回</span></h2>       <ul class="am-selected-list">                     <li class="am-checked" data-index="0" data-group="0" data-value="男">         <span class="am-selected-text">男</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="1" data-group="0" data-value="女">         <span class="am-selected-text">女</span>         <i class="am-icon-check"></i></li>            </ul>    <div class="am-selected-hint">必选</div>  </div></div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">联系地址：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="lxdz" placeholder="现居住地联系地址">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">上级代理：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="sjdl" placeholder="留空为没有上级代理" value="">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">接入网址：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="wzwz" placeholder="商户接入网站的URL">
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">网站名称：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="wzmc" placeholder="商户接入网站的名称（4个中文字符）">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">网站类型：</label>
                                        <div class="am-u-sm-9">
                                            <select id="wzlx" data-am-selected="" required="" style="display: none;">
                                                <option value="综合社区">综合社区</option>
                                                <option value="网上购物">网上购物</option>
                                                <option value="游戏充值">游戏充值</option>
                                                <option value="其他类型">其他类型</option>
                                            </select><div class="am-selected am-dropdown " id="am-selected-xmrfx" data-am-dropdown="">  <button type="button" class="am-selected-btn am-btn am-dropdown-toggle am-btn-default">    <span class="am-selected-status am-fl">综合社区</span>    <i class="am-selected-icon am-icon-caret-down"></i>  </button>  <div class="am-selected-content am-dropdown-content">    <h2 class="am-selected-header"><span class="am-icon-chevron-left">返回</span></h2>       <ul class="am-selected-list">                     <li class="am-checked" data-index="0" data-group="0" data-value="综合社区">         <span class="am-selected-text">综合社区</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="1" data-group="0" data-value="网上购物">         <span class="am-selected-text">网上购物</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="2" data-group="0" data-value="游戏充值">         <span class="am-selected-text">游戏充值</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="3" data-group="0" data-value="其他类型">         <span class="am-selected-text">其他类型</span>         <i class="am-icon-check"></i></li>            </ul>    <div class="am-selected-hint">必选</div>  </div></div>
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">提现银行：</label>
                                        <div class="am-u-sm-9">
                                            <select id="txyh" data-am-selected="" required="" style="display: none;">
                                            <option value="支付宝">支付宝</option>
                                            <option value="财付通">财付通</option>
                                            <option value="建设银行">建设银行</option>
                                            <option value="工商银行">工商银行</option>
                                            <option value="邮政储蓄">邮政储蓄</option>
                                            <option value="浦发银行">浦发银行</option>
                                            <option value="农业银行">农业银行</option>
                                            <option value="广发银行">广发银行</option>
                                            </select><div class="am-selected am-dropdown " id="am-selected-ym5kz" data-am-dropdown="">  <button type="button" class="am-selected-btn am-btn am-dropdown-toggle am-btn-default">    <span class="am-selected-status am-fl">支付宝</span>    <i class="am-selected-icon am-icon-caret-down"></i>  </button>  <div class="am-selected-content am-dropdown-content">    <h2 class="am-selected-header"><span class="am-icon-chevron-left">返回</span></h2>       <ul class="am-selected-list">                     <li class="am-checked" data-index="0" data-group="0" data-value="支付宝">         <span class="am-selected-text">支付宝</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="1" data-group="0" data-value="财付通">         <span class="am-selected-text">财付通</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="2" data-group="0" data-value="建设银行">         <span class="am-selected-text">建设银行</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="3" data-group="0" data-value="工商银行">         <span class="am-selected-text">工商银行</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="4" data-group="0" data-value="邮政储蓄">         <span class="am-selected-text">邮政储蓄</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="5" data-group="0" data-value="浦发银行">         <span class="am-selected-text">浦发银行</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="6" data-group="0" data-value="农业银行">         <span class="am-selected-text">农业银行</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="7" data-group="0" data-value="广发银行">         <span class="am-selected-text">广发银行</span>         <i class="am-icon-check"></i></li>            </ul>    <div class="am-selected-hint">必选</div>  </div></div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">提现账号：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="txzh" placeholder="输入不超过21为字符的账号">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">户籍地址：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="hjdz" placeholder="身份证上的户籍地址">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">真实姓名：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="zsxm" placeholder="身份证上的真实姓名">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">身份号码：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="sfhm" placeholder="身份证上的身份号码">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                        <div class="am-form-group">
                                        <label for="user-weibo" class="am-u-sm-3 am-form-label">身份正面：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <div class="am-form-group am-form-file">
                                                <button type="button" class="am-btn am-btn-danger am-btn-sm"><i class="am-icon-cloud-upload"></i> <span id="z-list">添加身份证正面图片</span></button>
                                                <input id="sfzm" type="file" multiple="">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                        <div class="am-form-group">
                                        <label for="user-weibo" class="am-u-sm-3 am-form-label">身份反面：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <div class="am-form-group am-form-file">
                                                <button type="button" class="am-btn am-btn-danger am-btn-sm"><i class="am-icon-cloud-upload"></i> <span id="f-list">添加身份证反面图片</span></button>
                                                <input id="sffm" type="file" multiple="">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">身份地址：<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="sfdz" placeholder="身份证上的地址">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="am-u-md-6">
                                    <div class="am-form-group">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">商户类型：</label>
                                        <div class="am-u-sm-9">
                                            <select id="shlx" data-am-selected="" required="" style="display: none;">
                                            <option value="gr">个人</option>
                                            <option value="qy">企业</option>
                                            </select><div class="am-selected am-dropdown " id="am-selected-hr0ox" data-am-dropdown="">  <button type="button" class="am-selected-btn am-btn am-dropdown-toggle am-btn-default">    <span class="am-selected-status am-fl">个人</span>    <i class="am-selected-icon am-icon-caret-down"></i>  </button>  <div class="am-selected-content am-dropdown-content">    <h2 class="am-selected-header"><span class="am-icon-chevron-left">返回</span></h2>       <ul class="am-selected-list">                     <li class="am-checked" data-index="0" data-group="0" data-value="gr">         <span class="am-selected-text">个人</span>         <i class="am-icon-check"></i></li>                                 <li class="" data-index="1" data-group="0" data-value="qy">         <span class="am-selected-text">企业</span>         <i class="am-icon-check"></i></li>            </ul>    <div class="am-selected-hint">必选</div>  </div></div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="am-form-group">
                                       <div class="am-u-sm-9 am-u-sm-push-3">
                                            <button onclick="javascript:tjxj();" type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success ">添加商户（同时会实名与开通API权限）</button>
                                        </div>
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