        <!-- 侧边导航栏 -->
        <div class="left-sidebar">
            <!-- 用户信息 -->
            <div class="tpl-sidebar-user-panel">
                <div class="tpl-user-panel-slide-toggleable">
                    <span class="user-panel-logged-in-text">
              <i class="am-icon-circle-o am-text-success tpl-user-panel-status-icon"></i>
              超级管理员
          </span>
                </div>
            </div>

            <!-- 菜单 -->
            <ul class="sidebar-nav">
                <li class="sidebar-nav-heading"><i class="am-icon-cog am-icon-spin"></i> 功能导航<span class="sidebar-nav-heading-info"> 核心</span></li>
                <li class="sidebar-nav-link">
                    <a href="/system/index" id="jhindex" class="active">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 首页
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" class="sidebar-nav-sub-title" id="jhhxpz">
                        <i class="am-icon-sliders sidebar-nav-link-logo"></i> 核心配置
                        <span class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
                    </a>
                    <ul class="sidebar-nav sidebar-nav-sub" id="jhhxpzlb">
                        <li class="sidebar-nav-link">
                            <a href="/system/set/core" id="jhxtpz">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 系统配置
                            </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/set/pay" id="jhzftd">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 支付通道
                            </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/set/email" id="jhyxsz">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 邮箱设置
                            </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/set/sms" id="jhdxsz">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 短信设置
                            </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/set/blackPay" id="jhddsz">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 掉单设置
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" class="sidebar-nav-sub-title" id="jhxgjl">
                        <i class="am-icon-wpforms sidebar-nav-link-logo"></i> 相关记录
                        <span class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico "></span>
                    </a>
                    <ul id="jhxgjllb" class="sidebar-nav sidebar-nav-sub" style="display: block;">
                        <li class="sidebar-nav-link">
                            <a href="/system/related/order" id="jhddjl">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 订单记录
                            </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/related/js" id="jhjsjl">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 结算记录
                            </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/related/black" id="jhhdjl">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 黑单记录
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-nav-link">
                    <a href="javascript:;" class="sidebar-nav-sub-title" id="jhshgn">
                        <i class="am-icon-user sidebar-nav-link-logo"></i> 商户功能
                        <span class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
                    </a>
                    <ul id="jhshgnlb" class="sidebar-nav sidebar-nav-sub" style="display: block;">
                        <li class="sidebar-nav-link">
                            <a href="/system/shop/add" id="jhtjsh">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 添加商户
                            </a>
                        </li>
                        
                        <li class="sidebar-nav-link">
                            <a href="/system/shop/manager" id="jhshgl">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 商户管理
                            </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/shop/js" id="jhshjs">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 商户结算
                                                        </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/shop/realName" id="jhsmrz">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 实名认证
                                                        </a>
                        </li>

                        <li class="sidebar-nav-link">
                            <a href="/system/shop/api" id="jhjksh">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 接口审核
                                                        </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-nav-heading"><i class="am-icon-cog am-icon-spin"></i> 安全相关<span class="sidebar-nav-heading-info"> 敏感</span></li>
{{--                 <li class="sidebar-nav-link">
                    <a href="gllb.php" id="jhgllb">
                        <i class="am-icon-user-secret sidebar-nav-link-logo"></i> 管理列表
                    </a>
                </li> --}}
                <li class="sidebar-nav-heading"><i class="am-icon-cog am-icon-spin"></i> 站务其他<span class="sidebar-nav-heading-info"> 通知</span></li>
                <li class="sidebar-nav-link">
                    <a href="/system/other/notiy" id="jhwzgg">
                        <i class="am-icon-volume-up sidebar-nav-link-logo"></i> 网站公告
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/system/other/message" id="jhznxx">
                        <i class="am-icon-envelope-square sidebar-nav-link-logo"></i> 站内消息
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/system/other/quesstion" id="jhwtfk">
                        <i class="am-icon-envelope-square sidebar-nav-link-logo"></i> 问题反馈
                                            </a>
                </li>

            </ul>
        </div>