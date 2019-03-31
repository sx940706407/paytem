@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 订单记录 <small>v 2.0</small></div>
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
                                                <th>用户名</th>
                                                <th>订单号</th>
                                                <th>处理时间</th>
                                                <th>支付通道</th>
                                                <th>金额</th>
                                                <th>所得金额</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="102">1</td>
                                                <td>cotest</td>
                                                <td>COPAY20180623191836M</td>
                                                <td>2018-06-23 19:18:36</td>
                                                <td>微信</td>
                                                <td>1.000</td>
                                                <td>0.940</td>
                                                <td><a class="am-badge am-badge-danger am-radius">失败</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="102"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="sc(this)" val="102"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="101">2</td>
                                                <td>cotest</td>
                                                <td>COPAY20180623191807M</td>
                                                <td>2018-06-23 19:18:07</td>
                                                <td>微信</td>
                                                <td>1.000</td>
                                                <td>0.940</td>
                                                <td><a class="am-badge am-badge-danger am-radius">失败</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="101"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="sc(this)" val="101"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="100">3</td>
                                                <td>cotest</td>
                                                <td>COPAY20180623191759M</td>
                                                <td>2018-06-23 19:17:59</td>
                                                <td>微信</td>
                                                <td>1.000</td>
                                                <td>0.940</td>
                                                <td><a class="am-badge am-badge-danger am-radius">失败</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="100"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="sc(this)" val="100"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="99">4</td>
                                                <td>cotest</td>
                                                <td>COPAY20180623191644M</td>
                                                <td>2018-06-23 19:16:44</td>
                                                <td>微信</td>
                                                <td>1.000</td>
                                                <td>0.940</td>
                                                <td><a class="am-badge am-badge-danger am-radius">失败</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="99"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="sc(this)" val="99"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="98">5</td>
                                                <td>cotest</td>
                                                <td>COPAY20180623191442M</td>
                                                <td>2018-06-23 19:14:42</td>
                                                <td>微信</td>
                                                <td>1.000</td>
                                                <td>0.940</td>
                                                <td><a class="am-badge am-badge-danger am-radius">失败</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="98"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="sc(this)" val="98"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="97">6</td>
                                                <td>cotest</td>
                                                <td>COPAY20180622103607M</td>
                                                <td>2018-06-22 10:36:07</td>
                                                <td>微信</td>
                                                <td>1.000</td>
                                                <td>0.940</td>
                                                <td><a class="am-badge am-badge-danger am-radius">失败</a></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="97"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="sc(this)" val="97"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
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
                                            <a href="ddjl.php">首页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=1" class="">上一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=2" class="">下一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=17" class="">末页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a class="">共 101条记录 / 17页</a>
                                          </li>
                                      </ul>
                    </div>
                </div>
            </div>
                  
@endsection


@section('js')
   
@endsection