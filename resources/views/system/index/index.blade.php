@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 系统管理首页 <small>v 2.0</small></div>
                        <p class="page-header-description">HT新版聚合支付系统</p>
                    </div>
                    <div class="am-u-lg-3 tpl-index-settings-button">
                        <button onclick="javascript:window.location.reload();" type="button" class="page-header-button"><i class="am-icon-refresh am-icon-spin"></i> 刷新数据</button>
                    </div>
                </div>

            </div>
<div class="row-content am-cf">
                <div class="row  am-cf">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                        <div class="widget widget-primary am-cf">
                            <div class="widget-statistic-header">
                                平台订单总数
                            </div>
                            <div class="widget-statistic-body">
                                <div class="widget-statistic-value">
                                    <i class="am-icon-bookmark"></i> 共 101 份订单
                                </div>
                                <span class="widget-statistic-icon am-icon-credit-card-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                        <div class="widget widget-primary am-cf" style="background-color:#6cd06c;border:0px">
                            <div class="widget-statistic-header">
							<br>
                            </div>
                            <div class="widget-statistic-body">
                                <div class="widget-statistic-value">
								<center>订单数据统计</center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                        <div class="widget widget-purple am-cf">
                            <div class="widget-statistic-header">
                                平台订单总额
                            </div>
                            <div class="widget-statistic-body">
                                <div class="widget-statistic-value">
                                    <i class="am-icon-money"></i> ￥ 200.000 元
                                </div>
                                <span class="widget-statistic-icon am-icon-support"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row  am-cf">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                        <div class="widget widget-primary am-cf">
                            <div class="widget-statistic-header">
                                今日订单总数
                            </div>
                            <div class="widget-statistic-body">
                                <div class="widget-statistic-value">
                                     0 份
                                </div>
                                <span class="widget-statistic-icon am-icon-check-circle"></span>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                        <div class="widget widget-primary am-cf">
                            <div class="widget-statistic-header">
                                今日成功订单
                            </div>
                            <div class="widget-statistic-body">
                                <div class="widget-statistic-value">
                                     0 份
                                </div>
                                <span class="widget-statistic-icon am-icon-check-circle"></span>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                        <div class="widget widget-purple am-cf">
                            <div class="widget-statistic-header">
                                今日成功金额
                            </div>
                            <div class="widget-statistic-body">
                                <div class="widget-statistic-value">
                                     0.00 元
                                </div>
                                <span class="widget-statistic-icon am-icon-check-circle"></span>
                            </div>
                        </div>
                    </div>
                </div>

				
                <div class="row am-cf">

                    <div class="am-u-sm-12 am-u-md-4">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">订单支付比例分析</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body widget-body-md am-fr">

                                <div class="am-progress-title">支付成功<span class="am-fr am-progress-title-more">2.97%</span></div>
                                <div class="am-progress">
                                    <div class="am-progress-bar" style="width: 2.97%"></div>
                                </div>
                                <div class="am-progress-title">支付等待<span class="am-fr am-progress-title-more">0%</span></div>
                                <div class="am-progress">
                                    <div class="am-progress-bar  am-progress-bar-warning" style="width: 0%"></div>
                                </div>
                                <div class="am-progress-title">支付失败<span class="am-fr am-progress-title-more">97.03%</span></div>
                                <div class="am-progress">
                                    <div class="am-progress-bar am-progress-bar-danger" style="width: 97.03%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="am-u-sm-12 am-u-md-8">
                        <div class="tpl-user-card am-text-center widget-body-lg" style="min-height:258px">
                            <div class="tpl-user-card-title">
                                尊敬的超级管理员
                            </div>
                            <div class="achievement-subheading">
                                欢迎使用2018年新版聚合支付系统；
                            </div>
                            <div class="achievement-description">
                                <b>系统版本：</b><strong>v2.0</strong>
                                <b>更新时间：</b><strong>2018-02-08</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection


@section('js')
   
@endsection