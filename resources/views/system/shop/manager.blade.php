@extends('system/amazeui/master')

@section('css')

@endsection

@section('content')
<div class="container-fluid am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                        <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 商户管理 <small>v 2.0</small></div>
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
                                                <th>实名认证</th>
                                                <th>认证类型</th>
                                                <th>API权限</th>
                                                <th>上级</th>
                                                <th>账户余额</th>
                                                <th>账户状态</th>
                                                <th>注册时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10011">1</td>
                                                <td>aaaaa123</td>
                                                <td><a onclick="cksm(this)" val="aaaaa123" class="am-badge am-badge-success am-radius">已实名</a></td>
                                                <td>个人</td>
                                                <td><a onclick="xgapi(this)" val="aaaaa123" class="am-badge am-badge-success am-radius">已开通</a></td>
                                                <td>coagent</td>
                                                <td>81111111011219.780</td>
                                                <td>正常</td>
                                                <td>2018-04-20 13:03:23</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="xg(this)" val="aaaaa123"><a href="javascript:void(0)" class="tpl-table-black-operation-success">
                                                            <i class="am-icon-pencil"></i> 修改
                                                        </a></span>
                                                        <span><a target="_blank" href="?action=mianban&amp;user=aaaaa123" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 面板
                                                        </a></span>
                                                        <span onclick="sc(this)" val="aaaaa123"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10010">2</td>
                                                <td>1234561</td>
                                                <td><a onclick="cksm(this)" val="1234561" class="am-badge am-badge-success am-radius">已实名</a></td>
                                                <td>个人</td>
                                                <td><a onclick="xgapi(this)" val="1234561" class="am-badge am-badge-success am-radius">已开通</a></td>
                                                <td>1</td>
                                                <td>0.000</td>
                                                <td>正常</td>
                                                <td>2018-04-14 01:25:47</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="xg(this)" val="1234561"><a href="javascript:void(0)" class="tpl-table-black-operation-success">
                                                            <i class="am-icon-pencil"></i> 修改
                                                        </a></span>
                                                        <span><a target="_blank" href="?action=mianban&amp;user=1234561" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 面板
                                                        </a></span>
                                                        <span onclick="sc(this)" val="1234561"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10009">3</td>
                                                <td>2670267072</td>
                                                <td><a onclick="cksm(this)" val="2670267072" class="am-badge am-badge-success am-radius">已实名</a></td>
                                                <td>个人</td>
                                                <td><a onclick="xgapi(this)" val="2670267072" class="am-badge am-badge-success am-radius">已开通</a></td>
                                                <td>lyaaa</td>
                                                <td>0.000</td>
                                                <td>正常</td>
                                                <td>2018-04-12 11:06:44</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="xg(this)" val="2670267072"><a href="javascript:void(0)" class="tpl-table-black-operation-success">
                                                            <i class="am-icon-pencil"></i> 修改
                                                        </a></span>
                                                        <span><a target="_blank" href="?action=mianban&amp;user=2670267072" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 面板
                                                        </a></span>
                                                        <span onclick="sc(this)" val="2670267072"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10008">4</td>
                                                <td>654321</td>
                                                <td><a onclick="cksm(this)" val="654321" class="am-badge am-badge-success am-radius">已实名</a></td>
                                                <td>个人</td>
                                                <td><a onclick="xgapi(this)" val="654321" class="am-badge am-badge-success am-radius">已开通</a></td>
                                                <td>654321</td>
                                                <td>0.000</td>
                                                <td>正常</td>
                                                <td>2018-04-12 10:45:27</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="xg(this)" val="654321"><a href="javascript:void(0)" class="tpl-table-black-operation-success">
                                                            <i class="am-icon-pencil"></i> 修改
                                                        </a></span>
                                                        <span><a target="_blank" href="?action=mianban&amp;user=654321" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 面板
                                                        </a></span>
                                                        <span onclick="sc(this)" val="654321"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10007">5</td>
                                                <td>wxn12345678</td>
                                                <td><a onclick="cksm(this)" val="wxn12345678" class="am-badge am-badge-success am-radius">已实名</a></td>
                                                <td>个人</td>
                                                <td><a onclick="xgapi(this)" val="wxn12345678" class="am-badge am-badge-success am-radius">已开通</a></td>
                                                <td>456789</td>
                                                <td>0.000</td>
                                                <td>正常</td>
                                                <td>2018-04-12 10:44:05</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="xg(this)" val="wxn12345678"><a href="javascript:void(0)" class="tpl-table-black-operation-success">
                                                            <i class="am-icon-pencil"></i> 修改
                                                        </a></span>
                                                        <span><a target="_blank" href="?action=mianban&amp;user=wxn12345678" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 面板
                                                        </a></span>
                                                        <span onclick="sc(this)" val="wxn12345678"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-exclamation-triangle"></i> 删除
                                                        </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                                
                                            <tr class="gradeX">
                                                <td><input type="checkbox" class="a" name="x" value="10006">6</td>
                                                <td>19920908612</td>
                                                <td><a onclick="cksm(this)" val="19920908612" class="am-badge am-badge-success am-radius">已实名</a></td>
                                                <td>个人</td>
                                                <td><a onclick="xgapi(this)" val="19920908612" class="am-badge am-badge-success am-radius">已开通</a></td>
                                                <td>541546</td>
                                                <td>0.000</td>
                                                <td>正常</td>
                                                <td>2018-04-12 10:40:27</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <span onclick="xg(this)" val="19920908612"><a href="javascript:void(0)" class="tpl-table-black-operation-success">
                                                            <i class="am-icon-pencil"></i> 修改
                                                        </a></span>
                                                        <span><a target="_blank" href="?action=mianban&amp;user=19920908612" class="tpl-table-black-operation-info">
                                                            <i class="am-icon-eye"></i> 面板
                                                        </a></span>
                                                        <span onclick="sc(this)" val="19920908612"><a href="javascript:void(0)" class="tpl-table-black-operation-del">
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
                                            <a href="shgl.php">首页</a>
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