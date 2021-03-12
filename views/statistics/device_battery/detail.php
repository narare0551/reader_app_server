<?php
$detail_form_width = '1200';
?>
<style>
    #detail_form.active {
        transform: translateX(-<?=$detail_form_width?>px);
        -ms-transform: translateX(-<?=$detail_form_width?>px);
        -o-transform: translateX(-<?=$detail_form_width?>px);
        -webkit-transform: translateX(-<?=$detail_form_width?>px);
    }
</style>
<div id="detail_form"
     style="top:149px;height:728px;position: fixed;width: <?= $detail_form_width ?>px;border: 1px solid #e0e0e0;border-right: 0 !important;padding: 0;border-bottom-left-radius: 2px;right: -<?= $detail_form_width ?>px;z-index: 1240;background: #fff;-webkit-transition: transform 0.15s ease;-o-transition: transform 0.15s ease;transition: transform 0.15s ease;">
    <!--    <div class="detail-options-icon"><i class="fa fa-spin fa-fw fa-smile-o"></i></div>-->
    <div id="detail_arrow_icon" style="width:42px;height:37px;padding:10px;display: inline-block;position: absolute;left: -42px;font-size: 13px;border: 1px solid #e0e0e0;border-right: 0 !important;letter-spacing: normal;
text-transform: none;background: #fafafa;border-top-left-radius: 2px;border-bottom-left-radius: 2px;cursor: pointer;line-height: 16px;top: -1px;">
        <i class="fa fa-arrow-left"></i></div>
    <div id="detail_form_title"
         style="height:36px;padding:10px;font-weight: bold;padding: 10px;font-size: 11px;text-transform: uppercase;letter-spacing: 2px;color: #607d8b;background: #fafafa;border-bottom: 1px solid #eeeeee;">
        품목 관리 상세정보
    </div>

    <div class="detail-body" style="padding:20px;">
        <div class="form-horizontal">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_order_code" id="label_order_code" class="col-sm-2 control-label">발주코드</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="detail_form_idx">
                            <input type="text" class="form-control" id="detail_form_order_code" placeholder="자동생성됩니다." readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_reg_user_id" id="label_reg_user_id" class="col-sm-2 control-label">작성자</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="detail_form_reg_user_id" placeholder="작성자" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label style="white-space:nowrap;" for="detail_form_delivery_dt" id="label_delivery_dt" class="col-sm-2 control-label">납품예정일자</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control facnroll-datepicker" style="width: 100%" id="detail_form_delivery_dt" placeholder="납품예정일자">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_order_dt" id="label_order_dt" class="col-sm-2 control-label">발주일자</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="detail_form_order_dt" placeholder="발주일자" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_company_code" id="label_company_code" class="col-sm-2 control-label">거래처</label>
                        <div class="col-sm-10">
                            <select name="status" id="detail_form_company_code" class="form-control">
                                <!--                                <option value="EA">EA</option>-->
                                <!--                                <option value="Kg">Kg</option>-->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_order_status" id="label_order_status" class="col-sm-2 control-label">발주상태</label>
                        <div class="col-sm-10">
                            <select name="status" id="detail_form_order_status" class="form-control">
                                                                <option value="N">발주신청</option>
                                                                <option value="Y">발주완료</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label for="detail_form_order_remark" id="label_order_remark" class="col-sm-1 control-label">비고</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" id="detail_form_order_remark" placeholder="비고" style="resize: none;"></textarea>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <label for="btn_collection" id="label_btn_collection" class="col-sm-1 control-label"></label>
                <div class="text-left col-sm-11" style="" id="btn_collection">
<!--                    <a href="javascript:" class="btn btn-default" style="background-color: #37474f;color:#ffffff;"><i class="fa fa-plus"></i></a>-->
<!--                    <a href="javascript:;" class="btn btn-default" style="background-color: #37474f;color:#ffffff;"><i class="fa fa-minus"></i></a>-->
                    <a  class="btn btn-default" data-toggle="modal" data-type="0" data-target="#pop_item" style="background-color: #37474f;color:#ffffff;">품목추가</i></a>
                    <a class="btn btn-default" onclick="removeItemRow()" style="background-color: #37474f;color:#ffffff;">품목제거</i></a>

                </div>
            </div>
            <div class="row" style="margin-top:0px;">

                <label for="grid1" id="label_grid" class="col-sm-1 control-label"></label>
                <div class="col-sm-11">
                    <div style="width:100%; overflow-x: scroll; text-align: center">
                        <div id="grid1" style="width:1060px;height:250px;"></div>
                    </div>
                </div>


            </div>


        </div>

    </div>
</div>