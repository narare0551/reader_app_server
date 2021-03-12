<?php
$detail_form_width = '1000';
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

    </div>

    <div class="detail-body" style="padding:20px;">
        <div class="form-horizontal">
            <div class="row" id="write_form">
<!--                <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_item_code" class="col-sm-3 control-label"-->
<!--                           id="label_item_code">품목코드</label>-->
<!--                    <input type="hidden" id="detail_form_idx">-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" class="form-control" id="detail_form_item_code" placeholder="" readonly>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_item_name" class="col-sm-3 control-label"-->
<!--                           id="label_item_name">품목명</label>-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" class="form-control" id="detail_form_item_name" placeholder="" readonly>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_item_division" class="col-sm-3 control-label" id="label_item_division">구분</label>-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" class="form-control" id="detail_form_item_division" placeholder=""-->
<!--                               readonly>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_item_standard" class="col-sm-3 control-label" id="label_item_standard">규격</label>-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" class="form-control" id="detail_form_item_standard" placeholder=""-->
<!--                               readonly>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_item_unit" class="col-sm-3 control-label"-->
<!--                           id="label_item_unit">단위</label>-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" class="form-control" id="detail_form_item_unit" placeholder="" readonly>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_stock" class="col-sm-3 control-label" id="label_stock">현재고</label>-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" style="text-align: right" class="form-control" id="detail_form_stock"-->
<!--                               placeholder="" readonly>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_safety_stock" class="col-sm-3 control-label" id="label_safety_stock">안전재고</label>-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" style="text-align: right" class="form-control"-->
<!--                               id="detail_form_safety_stock" placeholder="">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_change_stock" class="col-sm-3 control-label" id="label_change_stock">변경재고</label>-->
<!--                    <div class="col-sm-9">-->
<!--                        <input type="text" style="text-align: right" class="form-control"-->
<!--                               id="detail_form_change_stock"-->
<!--                               placeholder="">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-12">-->
<!--                <div class="form-group">-->
<!--                    <label for="detail_form_remark" class="col-sm-1 control-label">비고</label>-->
<!--                    <div class="col-sm-11">-->
<!--                        <textarea class="form-control" id="detail_form_remark" placeholder="비고" cols="5"></textarea>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
        <div class="row" style="margin-top: 80px">
            <div class="col-lg-12">
                <a  class="btn btn-default" data-toggle="modal" data-type="0" data-target="#pop_item" style="background-color: #37474f;color:#ffffff;">품목추가</i></a>
                <a href="javascript:removeItemRow();" id="btn_search" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">품목삭제</a>
                <div class="panel-body" style="height:410px;">
                    <div style="width:100%;overflow-x: scroll">
                        <div id="sub_grid" style="width:100%;height:410px;"></div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>