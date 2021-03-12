<?php
$detail_form_width = '1000';
?>
<style>
    #detail_form.active{
        transform: translateX(-<?=$detail_form_width?>px);
        -ms-transform: translateX(-<?=$detail_form_width?>px);
        -o-transform: translateX(-<?=$detail_form_width?>px);
        -webkit-transform: translateX(-<?=$detail_form_width?>px);
    }
</style>
<div id="detail_form" style="top:149px;height:728px;position: fixed;width: <?=$detail_form_width?>px;border: 1px solid #e0e0e0;border-right: 0 !important;padding: 0;border-bottom-left-radius: 2px;right: -<?=$detail_form_width?>px;z-index: 1240;background: #fff;-webkit-transition: transform 0.15s ease;-o-transition: transform 0.15s ease;transition: transform 0.15s ease;">
    <!--    <div class="detail-options-icon"><i class="fa fa-spin fa-fw fa-smile-o"></i></div>-->
    <div id="detail_arrow_icon" style="width:42px;height:37px;padding:10px;display: inline-block;position: absolute;left: -42px;font-size: 13px;border: 1px solid #e0e0e0;border-right: 0 !important;letter-spacing: normal;
text-transform: none;background: #fafafa;border-top-left-radius: 2px;border-bottom-left-radius: 2px;cursor: pointer;line-height: 16px;top: -1px;"><i class="fa fa-arrow-left"></i></div>
    <div id="detail_form_title" style="height:36px;padding:10px;font-weight: bold;padding: 10px;font-size: 11px;text-transform: uppercase;letter-spacing: 2px;color: #607d8b;background: #fafafa;border-bottom: 1px solid #eeeeee;">Setup Menu Detail</div>

    <div class="detail-body" style="padding:20px;">
        <div class="form-horizontal">
            <div class="row" id="write_form">
<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="detail_form_user_id" class="col-sm-2 control-label" id="label_user_id">ID</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input type="hidden" class="form-control" id="detail_form_idx">-->
<!--                            <input type="text" class="form-control required" id="detail_form_user_id" placeholder="ID">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="detail_form_user_pw" class="col-sm-2 control-label" id="label_user_pw">Password</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input type="password" class="form-control required" id="detail_form_user_pw" placeholder="Password">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="detail_form_name" class="col-sm-2 control-label" id="label_name">사용자명</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input type="text" class="form-control required" id="detail_form_name" placeholder="사용자명">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="detail_form_status" class="col-sm-2 control-label" id="label_status">접속권한</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <select name="status" id="detail_form_status" class="form-control">-->
<!--                                <option value="Y">Y</option>-->
<!--                                <option value="N">N</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-12">-->
<!--                    <div class="form-group">-->
<!--                        <label for="detail_form_remark" class="col-sm-1 control-label" id="label_remark">비고</label>-->
<!--                        <div class="col-sm-11">-->
<!--                            <textarea class="form-control" id="detail_form_remark" placeholder="비고"></textarea>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>

        </div>

    </div>
</div>