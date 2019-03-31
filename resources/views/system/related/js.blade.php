@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 结算记录 <small>v 2.0</small></div>
                        <p class="page-header-description"></p>
                    </div>
                </div>

            </div>       
<div class="row-content am-cf">
                <div class="row am-cf">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12 widget-margin-bottom-lg">
                    <div class="am-btn-group">
                        <button onclick="javascript:window.location.reload();" class="am-btn am-btn-default"><i class="am-icon-spinner am-icon-pulse"></i>　数据刷新</button>
                    </div>
                        <button onclick="plsc()" type="button" class="am-btn am-btn-default"><i class="am-icon-trash"></i> 批量删除</button>
                    <hr>
                        <div class="widget am-cf widget-body-lg">

                            <div class="widget-body  am-fr">
                                <div class="am-scrollable-horizontal ">
                                    <table width="100%" class="am-table am-table-compact am-text-nowrap am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th><label class="am-checkbox-inline"><input type="checkbox" name="all" id="all"></label>编号</th>
                                                <th>申请用户</th>
                                                <th>提现金额</th>
                                                <th>手续费</th>
                                                <th>实际金额</th>
                                                <th>收款姓名</th>
                                                <th>收款银行</th>
                                                <th>收款账号</th>
                                                <th>申请时间</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="11">1</td>
                                                <td>aaaaa123</td>
                                                <td>100000.000</td>
                                                <td>1000.000</td>
                                                <td>99000.000</td>
                                                <td>需要需</td>
                                                <td>支付宝</td>
                                                <td>13816696262</td>
                                                <td>2018-07-02 16:27:52</td>
                                                <td><a class="am-badge am-badge-success am-radius">已结算</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="11"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10">2</td>
                                                <td>aaaaa123[代付]</td>
                                                <td>100.000</td>
                                                <td>3.000</td>
                                                <td>97.000</td>
                                                <td>王二</td>
                                                <td>交通银行XX支行XX分行</td>
                                                <td>6210355030100376992</td>
                                                <td>2018-05-21 11:42:36</td>
                                                <td><a class="am-badge am-badge-success am-radius">已结算</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="10"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="9">3</td>
                                                <td>aaaaa123</td>
                                                <td>100.000</td>
                                                <td>3.000</td>
                                                <td>97.000</td>
                                                <td>需要需</td>
                                                <td>支付宝</td>
                                                <td>13816696262</td>
                                                <td>2018-05-19 22:15:17</td>
                                                <td><a class="am-badge am-badge-success am-radius">已结算</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="9"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="8">4</td>
                                                <td>aaaaa123[代付]</td>
                                                <td>520.870</td>
                                                <td>5.209</td>
                                                <td>515.661</td>
                                                <td>郭小红</td>
                                                <td>建设银行XX支行XX分行</td>
                                                <td>6217211107001880000</td>
                                                <td>2018-05-19 22:12:46</td>
                                                <td><a class="am-badge am-badge-success am-radius">已结算</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="8"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="7">5</td>
                                                <td>aaaaa123[代付]</td>
                                                <td>118.320</td>
                                                <td>3.000</td>
                                                <td>115.320</td>
                                                <td>孙小明</td>
                                                <td>人民银行XX支行XX分行</td>
                                                <td>6212262201023557228</td>
                                                <td>2018-05-19 22:12:46</td>
                                                <td><a class="am-badge am-badge-success am-radius">已结算</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="7"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="6">6</td>
                                                <td>aaaaa123[代付]</td>
                                                <td>120.880</td>
                                                <td>3.000</td>
                                                <td>117.880</td>
                                                <td>李小黑</td>
                                                <td>浦发银行XX支行XX分行</td>
                                                <td>6217751010003320000</td>
                                                <td>2018-05-19 22:12:46</td>
                                                <td><a class="am-badge am-badge-success am-radius">已结算</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="6"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
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
                                            <a href="jsjl.php">首页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=1" class="">上一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=2" class="">下一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=2" class="">末页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a class="">共 11条记录 / 2页</a>
                                          </li>
                                      </ul>
                    </div>
                </div>
            </div>
                
@endsection


@section('js')
   
@endsection