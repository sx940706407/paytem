        <header>
            <!-- logo -->
            <div class="am-fl tpl-header-logo">
                <a href="javascript:;"><img src="{{asset('images/logo.png')}} " alt=""></a>
            </div>
            <!-- 右侧内容 -->
            <div class="tpl-header-fluid">
                <!-- 侧边切换 -->
                <div class="am-fl tpl-header-switch-button am-icon-list">
                    <span>

                </span>
                </div>
                <!-- 其它功能-->
                <div class="am-fr tpl-header-navbar">
                    <ul>
                        <!-- 欢迎语 -->
                <li class="am-dropdown" data-am-dropdown="">
                    <a class="am-dropdown-toggle" data-am-dropdown-toggle="" href="javascript:;">
                        <span class="am-icon-shield"></span> 超级管理员 <span class="am-icon-caret-down"></span>
                    </a>
                    <ul class="am-dropdown-content" style="background-color:#424b4f">
                        <li><a href="javascript:$('#head_tjgl').modal();" style="padding:0px 56px;"><span class="am-icon-key"></span> 修改密码</a></li>
                        <li><a href="gllb.php" style="padding:0px 56px;"><span class="am-icon-server"></span> 管理列表</a></li>
                    </ul>
                </li>
                        <!-- 新邮件 -->
                        <li class="am-dropdown tpl-dropdown" data-am-dropdown="">
                            <a href="javascript:;" class="am-dropdown-toggle tpl-dropdown-toggle" data-am-dropdown-toggle="">
                                <i class="am-icon-volume-up"></i>
                                <span class="am-badge am-badge-success am-round item-feed-badge">1</span>
                            </a>
                            <!-- 弹出列表 -->
                            <ul class="am-dropdown-content tpl-dropdown-content">
                                <li class="tpl-dropdown-menu-messages">
                                    <a href="javascript:;" class="tpl-dropdown-menu-messages-item am-cf">
                                        <div class="menu-messages-ico">
                                            <img src="{{asset('images/logoa.png')}}" alt="">
                                        </div>
                                        <div class="menu-messages-time">
                                            刚刚
                                        </div>
                                        <div class="menu-messages-content">
                                            <div class="am-text-truncate"> 系统有新版本可更新。 </div>
                                            <div class="menu-messages-content-time">2018-07-09 17:08:57</div>
                                        </div>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>

                        <!-- 新提示 -->
                        <li class="am-dropdown" data-am-dropdown="">
                            <a href="javascript:;" class="am-dropdown-toggle" data-am-dropdown-toggle="">
                                <i class="am-icon-bell"></i>
                                                            </a>

                            <!-- 弹出列表 -->
                            <ul class="am-dropdown-content tpl-dropdown-content">
                                
                                    <li class="tpl-dropdown-menu-notifications"><a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf"><div class="tpl-dropdown-menu-notifications-title"><center><i class="am-icon-check-square-o"></i><span>　暂无事务!</span></center></div></a></li>                                
                            </ul>
                        </li>

                        <!-- 退出 -->
                        <li class="am-text-sm">
                            <a href="javascript:window.location.href='index.php?action=out';">
                                <span class="am-icon-sign-out"></span> 退出
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </header>