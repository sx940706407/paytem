@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 实名审核 <small>v 2.0</small></div>
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
                        <button onclick="pltg()" type="button" class="am-btn am-btn-default"><i class="am-icon-check-circle-o" aria-hidden="true"></i> 批量通过</button>
                        <button onclick="plbh()" type="button" class="am-btn am-btn-default"><i class="am-icon-ban" aria-hidden="true"></i> 批量驳回</button>
                    <hr>
                        <div class="widget am-cf widget-body-lg">

                            <div class="widget-body  am-fr">
                                <div class="am-scrollable-horizontal ">
                                    <table width="100%" class="am-table am-table-compact am-text-nowrap am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th><label class="am-checkbox-inline"><input type="checkbox" name="all" id="all"></label>编号</th>
                                                <th>用户名</th>
                                                <th>姓名</th>
                                                <th>户籍地址</th>
                                                <th>申请类型</th>
                                                <th>申请时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                                                    <!-- more data -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                                      <ul data-am-widget="pagination" class="am-pagination am-pagination-default am-no-layout">
                                          <li class="tpl-table-black-operation">
                                            <a href="smrz.php">首页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=1" class="">上一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=0" class="">下一页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a href="?page=0" class="">末页</a>
                                          </li>
                                          <li class="tpl-table-black-operation">
                                            <a class="">共 0条记录 / 0页</a>
                                          </li>
                                      </ul>
                    </div>
                </div>
            </div>
            
@endsection


@section('js')
   
@endsection