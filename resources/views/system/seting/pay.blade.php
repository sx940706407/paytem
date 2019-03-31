@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 支付通道 <small>v 2.0</small></div>
                        <p class="page-header-description"></p>
                    </div>
                </div>

            </div>


            <div class="row-content am-cf">
                <div class="row am-cf">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12 widget-margin-bottom-lg">
                    <div class="am-btn-group">
                        <button onclick="javascript:window.location.reload();" class="am-btn am-btn-default"><i class="am-icon-spinner am-icon-pulse"></i>　数据刷新</button>
                        <div class="am-dropdown" data-am-dropdown="">
                        <button class="am-btn am-btn-default am-dropdown-toggle" data-am-dropdown-toggle=""> <span class="am-icon-caret-down"></span></button>
                        <ul class="am-dropdown-content">
                        <li><a class="am-animation-scale-up" href="javascript:$('#zjtd').modal();"><i class="am-icon-angle-double-right" aria-hidden="true"></i>　增加通道</a></li>
                        </ul>
                        </div>
                    </div>
                    <hr>
                        <div class="widget am-cf widget-body-lg">

                            <div class="widget-body  am-fr">
                                <div class="am-scrollable-horizontal ">
                                    <table width="100%" class="am-table am-table-compact am-text-nowrap am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th>编号</th>
                                                <th>图标</th>
                                                <th>通道名称</th>
                                                <th>通道代码</th>
                                                <th>接口UID</th>
                                                <th>接口账号</th>
                                                <th>接口KEY</th>
                                                <th>费率</th>
                                                <th>说明</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr class="gradeX ">
                                                <td class="am-text-middle">1</td>
                                                <td class="am-text-middle"><img width="50px;" class="tpl-table-line-img" src="/static/images/yinlian.png"></td>
                                                <td class="am-text-middle">银联</td>
                                                <td class="am-text-middle">yinlian</td>
                                                <td class="am-text-middle">777290058156667</td>
                                                <td class="am-text-middle">证书验证(请勿更改此值)</td>
                                                <td class="am-text-middle">000000</td>
                                                <td class="am-text-middle">0.02</td>
                                                <td class="am-text-middle">不可用于涉黄赌毒，菠菜，诱导等擦边违法用途</td>
                                                <td class="am-text-middle"><a class="am-badge am-badge-success am-radius">开启</a></td>
                                                <td class="am-text-middle">
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="bj(this)" val="3"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="3"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX ">
                                                <td class="am-text-middle">2</td>
                                                <td class="am-text-middle"><img width="50px;" class="tpl-table-line-img" src="/static/images/weixin.Png"></td>
                                                <td class="am-text-middle">微信</td>
                                                <td class="am-text-middle">weixin</td>
                                                <td class="am-text-middle">1900009851</td>
                                                <td class="am-text-middle">wx426b3015555a46be</td>
                                                <td class="am-text-middle">8934e7d15453e97507ef794cf7b0519d</td>
                                                <td class="am-text-middle">0.02</td>
                                                <td class="am-text-middle">不可用于涉黄赌毒，菠菜，诱导等擦边违法用途</td>
                                                <td class="am-text-middle"><a class="am-badge am-badge-success am-radius">开启</a></td>
                                                <td class="am-text-middle">
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="bj(this)" val="2"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="2"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX ">
                                                <td class="am-text-middle">3</td>
                                                <td class="am-text-middle"><img width="50px;" class="tpl-table-line-img" src="/static/images/zhifubao.Png"></td>
                                                <td class="am-text-middle">支付宝</td>
                                                <td class="am-text-middle">alipay</td>
                                                <td class="am-text-middle">2088912717947470</td>
                                                <td class="am-text-middle">2088912717947470</td>
                                                <td class="am-text-middle">dgsdssom3ulrpyxbkzx6tgrt729c7ygx</td>
                                                <td class="am-text-middle">0.02</td>
                                                <td class="am-text-middle">不可用于涉黄赌毒，菠菜，诱导等擦边违法用途</td>
                                                <td class="am-text-middle"><a class="am-badge am-badge-success am-radius">开启</a></td>
                                                <td class="am-text-middle">
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="bj(this)" val="1"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="1"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                                                            <!-- more data -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                                      <ul data-am-widget="pagination" class="am-pagination am-pagination-default am-no-layout">
                                          <li class="tpl-table-black-operation">
                                            <a href="zftd.php">首页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=1" class="">上一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=1" class="">下一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=1" class="">末页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a class="">共 3条记录 / 1页</a>
                                          </li>
                                      </ul>
                    </div>
                </div>
            </div>
            
@endsection


@section('js')
   
@endsection