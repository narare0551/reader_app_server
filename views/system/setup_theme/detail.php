<div class="panel panel-midnightblue">
    <div class="panel-heading" style="height:35px;">
        <span id="detail_title" style="color: #eceff1;height: 100%;width: auto;float: left;font-size: 13px;font-weight: 700;padding: 13px 0 13px;position: relative;margin: 0;line-height: 10px;">
            w2ui Grid Detail
        </span>
        <div style="color: #eceff1;height: 100%;width: auto;float: right;font-size: 13px;font-weight: 700;padding: 13px 0 13px;margin: 0;line-height: 10px;">
            <i class="fa fa-fw fa-close" onclick="closeDetail()"></i>
        </div>
    </div>
    <div class="panel-body" style="height:690px;overflow-y: auto;">

        <div action="" class="form-horizontal row-border" id="detail_form">
            <input type="hidden" id="idx" name="idx">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="user_id" id="label_user_id">사용자 ID</label>
                        <div class="col-sm-8">
                            <select class="form-control required" id="user_id">
                                <option value="">[선택]</option>
                                <option value="admin">admin</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="fix_header" id="label_fix_header">상단바 고정</label>
                        <div class="col-sm-8">
<!--                            <input class="bootstrap-switch" type="checkbox" checked data-size="small" data-on-color="primary" data-off-color="default" name="demo-fixedheader" data-on-text="I" data-off-text="O">-->
                            <div onclick="//changeFixTop()">
                                <input class="bootstrap-switch" checked id="fix_header" name="fix_header" type="checkbox" data-size="small" data-on-color="primary" data-off-color="default">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="box_layout" id="label_box_layout">박스형태로 보기</label>
                        <div class="col-sm-8">
                            <div onclick="//changeBoxLayout()">
                                <input class="bootstrap-switch" id="box_layout" name="box_layout" type="checkbox" data-size="small" data-on-color="primary" data-off-color="default">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="collapse_leftbar" id="label_collapse_leftbar">왼쪽메뉴 숨김</label>
                        <div class="col-sm-8">
                            <div onclick="//changeLeftbarShow()">
                                <input class="bootstrap-switch" id="collapse_leftbar" name="collapse_leftbar" type="checkbox" data-size="small" data-on-color="primary" data-off-color="default">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="collapse_rightbar" id="label_collapse_rightbar">오른쪽메뉴 숨김</label>
                        <div class="col-sm-8">
                            <div onclick="//changeRightHide()">
                                <input class="bootstrap-switch" checked id="collapse_rightbar" name="collapse_rightbar" type="checkbox" data-size="small" data-on-color="primary" data-off-color="default">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="header_colors" id="label_header_colors">상단바 색상</label>
                        <div class="col-sm-8">
                            <ul id="header_colors" class="panel-color-list" style="display: block;"  value="">
                                <li><span data-style="panel-default" onclick="select_color(this);$('#header_colors').val(changeTopColor('default'))"></span></li>
                                <li><span data-style="panel-black" onclick="select_color(this);$('#header_colors').val(changeTopColor('black'))"></span></li>
                                <li><span data-style="panel-primary" onclick="select_color(this);$('#header_colors').val(changeTopColor('primary'))"></span></li>
                                <li><span data-style="panel-grape" onclick="select_color(this);$('#header_colors').val(changeTopColor('grape'))"></span></li>
                                <li><span data-style="panel-green" onclick="select_color(this);$('#header_colors').val(changeTopColor('green'))"></span></li>
                                <li><span data-style="panel-alizarin" onclick="select_color(this);$('#header_colors').val(changeTopColor('alizarin'))"></span></li>
                                <li><span data-style="panel-danger" onclick="select_color(this);$('#header_colors').val(changeTopColor('danger'))"></span></li>
                                <li><span data-style="panel-primary" onclick="select_color(this);$('#header_colors').val(changeTopColor('primary'))"></span></li>
                                <li><span data-style="panel-midnightblue" onclick="select_color(this);$('#header_colors').val(changeTopColor('midnightblue'))"></span></li>
                                <li><span data-style="panel-indigo" onclick="select_color(this);$('#header_colors').val(changeTopColor('indigo'))"></span></li>
                                <li><span data-style="panel-info" onclick="select_color(this);$('#header_colors').val(changeTopColor('info'))"></span></li>
                                <li><span data-style="panel-midnightblue" onclick="select_color(this);$('#header_colors').val(changeTopColor('midnightblue'))"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sidebar_colors" id="label_sidebar_colors">왼쪽메뉴 색상</label>
                        <div class="col-sm-8">
                            <ul id="sidebar_colors" class="panel-color-list" style="display: block;" value="">
                                <li><span data-style="panel-default" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('default'))"></span></li>
                                <li><span data-style="panel-black" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('black'))"></span></li>
                                <li><span data-style="panel-primary" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('primary'))"></span></li>
<!--                                <li><span data-style="panel-grape" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('grape'))"></span></li>-->
                                <li><span data-style="panel-green" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('green'))"></span></li>
                                <li><span data-style="panel-alizarin" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('alizarin'))"></span></li>
<!--                                <li><span data-style="panel-danger" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('danger'))"></span></li>-->
                                <li><span data-style="panel-primary" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('primary'))"></span></li>
                                <li><span data-style="panel-midnightblue" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('midnightblue'))"></span></li>
                                <li><span data-style="panel-indigo" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('indigo'))"></span></li>
                                <li><span data-style="panel-info" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('info'))"></span></li>
                                <li><span data-style="panel-midnightblue" onclick="select_color(this);$('#sidebar_colors').val(changeLeftMenuColor('midnightblue'))"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-right">
                    <div class="btn btn-default btn-sm" style="float:right;margin:5px;" onclick="saveForm()">
                        <div style="width:50px;font-weight:bold;">
                            저장
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>