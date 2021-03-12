<div class="static-sidebar-wrapper sidebar-midnightblue" >
    <div class="static-sidebar" style="height:100%;overflow-y: auto;">
        <div class="sidebar">
            <div class="widget stay-on-collapse" id="widget-welcomebox">
                <div class="widget-body welcome-box tabular">
                    <div class="tabular-row">
                        <div class="tabular-cell welcome-avatar">
                            <a href="#"><img src="../../assets/demo/avatar/avatar_02.png" class="avatar"></a>
                        </div>
                        <div class="tabular-cell welcome-options">
                            <span class="welcome-text">개발팀</span>
                            <a href="" class="name"><?=getAuth('login_name')?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget stay-on-collapse" id="widget-sidebar">
                <nav role="navigation" class="widget-body">
                    <ul class="acc-menu" id="menu_form">
                        <?php echo getMenuListHtml(); ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>