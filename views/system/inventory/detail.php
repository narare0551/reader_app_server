<?php
$detail_form_width = '650';
?>
<style>
    #detail_form.active {
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
        <div class="form-horizontal col-md-12">
            <div class="row" id="write_form">
            </div>
            <div class="row" style="margin-top:25px;">
                <div class="col-md-6" style="height:30px;">
                    <div class="form-group">
                        <label for="detail_form_item_code" class="col-sm-4 control-label" id="label_item_code">총 수량</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control " style="text-align:right;" id="detail_form_item_code" placeholder="총 수량" value="" readonly="" onkeyup="commapoint_format(this, 0, 'int')">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-right">
<!--                    <a data-toggle="modal" href="#rack_popup" id="btn_search" class="btn btn-default" style="background-color: #37474f;color:#ffffff;"><i class="fa fa-plus"></i></a>-->
                    <a href="javascript:addRow()" class="btn btn-default" style="background-color: #37474f;color:#ffffff;"><i class="fa fa-plus"></i></a>
                    <a href="javascript:deleteRow()" class="btn btn-default" style="background-color: #37474f;color:#ffffff;"><i class="fa fa-minus"></i></a>
                </div>
                <div class="col-md-12">
                    <div class="panel-body" style="height:339px;">
                        <div style="width:100%;overflow-x: scroll">
                            <div id="rack_grid" style="width:100%;height:420px;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>