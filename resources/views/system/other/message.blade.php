@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 站内消息 <small>v 2.0</small></div>
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
                        <li><a class="am-animation-scale-up" href="javascript:$('#fsxx').modal();"><i class="am-icon-angle-double-right" aria-hidden="true"></i>　发送消息</a></li>
                        </ul>
                        </div>
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
                                                <th>消息标题</th>
                                                <th>消息内容</th>
                                                <th>发送时间</th>
                                                <th>接收用户</th>
                                                <th>查看</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="15">1</td>
                                                <td>结算成功</td>
                                                <td>尊敬的商户，你的提现申请已经处理,注意查账！</td>
                                                <td>2018-07-02 16:28:01</td>
                                                <td>aaaaa123</td>
                                                <td><span class="am-badge am-badge-warning">未查看</span></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="15"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="14">2</td>
                                                <td>结算成功</td>
                                                <td>尊敬的商户，你的提现申请已经处理,注意查账！</td>
                                                <td>2018-06-12 11:53:28</td>
                                                <td>aaaaa123[代付]</td>
                                                <td><span class="am-badge am-badge-warning">未查看</span></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="14"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="13">3</td>
                                                <td>结算成功</td>
                                                <td>尊敬的商户，你的提现申请已经处理,注意查账！</td>
                                                <td>2018-05-19 22:15:22</td>
                                                <td>aaaaa123</td>
                                                <td><span class="am-badge am-badge-secondary">已查看</span></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="13"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="12">4</td>
                                                <td>结算成功</td>
                                                <td>尊敬的商户，你的提现申请已经处理,注意查账！</td>
                                                <td>2018-05-19 22:14:08</td>
                                                <td>aaaaa123[代付]</td>
                                                <td><span class="am-badge am-badge-warning">未查看</span></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="12"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="11">5</td>
                                                <td>结算成功</td>
                                                <td>尊敬的商户，你的提现申请已经处理,注意查账！</td>
                                                <td>2018-05-19 22:14:08</td>
                                                <td>aaaaa123[代付]</td>
                                                <td><span class="am-badge am-badge-warning">未查看</span></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="11"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10">6</td>
                                                <td>结算成功</td>
                                                <td>尊敬的商户，你的提现申请已经处理,注意查账！</td>
                                                <td>2018-05-19 22:13:52</td>
                                                <td>aaaaa123[代付]</td>
                                                <td><span class="am-badge am-badge-warning">未查看</span></td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="sc(this)" val="10"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
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
                                            <a href="znxx.php">首页</a>
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
                                            <a class="">共 12条记录 / 2页</a>
                                          </li>
                                      </ul>
                    </div>
                </div>
            </div>
            
@endsection


@section('js')
   
@endsection