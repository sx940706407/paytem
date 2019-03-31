@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 网站公告 <small>v 2.0</small></div>
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
                        <li><a class="am-animation-scale-up" href="javascript:$('#fbgg').modal();"><i class="am-icon-angle-double-right" aria-hidden="true"></i>　发布公告</a></li>
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
                                                <th>公告标题</th>
                                                <th>公告内容</th>
                                                <th>发布时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="8">1</td>
                                                <td>CO聚合支付公告列表显示（一）</td>
                                                <td>CO聚合支付公告列表显示（一）</td>
                                                <td>2018-03-26 06:28:35</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="8"><a href="javascript:;" class="tpl-table-black-operation">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="bj(this)" val="8"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-check-square"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="8"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="7">2</td>
                                                <td>CO聚合支付公告列表显示（二）</td>
                                                <td>CO聚合支付公告列表显示（二）</td>
                                                <td>2018-02-01 11:47:36</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="7"><a href="javascript:;" class="tpl-table-black-operation">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="bj(this)" val="7"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-check-square"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="7"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="6">3</td>
                                                <td>CO聚合支付公告列表显示（三）</td>
                                                <td>CO聚合支付公告列表显示（三）</td>
                                                <td>2018-02-01 11:46:56</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="6"><a href="javascript:;" class="tpl-table-black-operation">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="bj(this)" val="6"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-check-square"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="6"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="5">4</td>
                                                <td>CO聚合支付公告列表显示（四）</td>
                                                <td>CO聚合支付公告列表显示（四）</td>
                                                <td>2018-02-01 11:46:43</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="5"><a href="javascript:;" class="tpl-table-black-operation">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="bj(this)" val="5"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-check-square"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="5"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="4">5</td>
                                                <td>CO聚合支付公告列表显示（五）</td>
                                                <td>CO聚合支付公告列表显示（五）</td>
                                                <td>2018-02-01 11:45:53</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="4"><a href="javascript:;" class="tpl-table-black-operation">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="bj(this)" val="4"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-check-square"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="4"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="3">6</td>
                                                <td>CO聚合支付公告列表显示（六）</td>
                                                <td>CO聚合支付公告列表显示（六）</td>
                                                <td>2018-02-01 11:44:42</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="ck(this)" val="3"><a href="javascript:;" class="tpl-table-black-operation">
                                                            <i class="am-icon-eye"></i> 查看
                                                        </a></span>
                                                        <span onclick="bj(this)" val="3"><a href="javascript:;" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-check-square"></i> 编辑
                                                        </a></span>
                                                        <span onclick="sc(this)" val="3"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
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
                                            <a href="wzgg.php">首页</a>
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
                                            <a class="">共 8条记录 / 2页</a>
                                          </li>
                                      </ul>
                    </div>
                </div>
            </div>
            
                       
@endsection


@section('js')
   
@endsection