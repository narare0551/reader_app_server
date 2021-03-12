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
        품목 관리 상세정보
    </div>

    <div class="detail-body" style="padding:20px;">
        <div class="form-horizontal">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_item_code" id="label_item_code" class="col-sm-2 control-label">품목코드</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="detail_form_idx">
                            <input type="text" class="form-control duplicate required" id="detail_form_item_code" placeholder="품목코드" maxlength="25">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_item_name" id="label_item_name" class="col-sm-2 control-label">품목명</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="detail_form_item_name" placeholder="품목명" maxlength="25">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_item_standard" id="label_item_standard" class="col-sm-2 control-label">규격</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="detail_form_item_standard" placeholder="규격" maxlength="255">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_item_unit" id="label_item_unit" class="col-sm-2 control-label">단위</label>
                        <div class="col-sm-10">
                            <select name="status" id="detail_form_item_unit" class="form-control">
<!--                                <option value="EA">EA</option>-->
<!--                                <option value="Kg">Kg</option>-->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_item_division" id="label_item_division" class="col-sm-2 control-label">구분</label>
                        <div class="col-sm-10">
                            <select name="status" id="detail_form_item_division" class="form-control">
<!--                                <option value="완제품">완제품</option>-->
<!--                                <option value="반제품">반제품</option>-->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_item_use_yn" id="label_item_use_yn" class="col-sm-2 control-label">사용여부</label>
                        <div class="col-sm-10">
                            <select name="status" id="detail_form_item_use_yn" class="form-control">
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="detail_form_item_remark" id="label_item_remark" class="col-sm-1 control-label">비고</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" id="detail_form_item_remark" placeholder="비고" style="resize: none;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="file" id="detail_form_fileupload" style="display: none">
                        <label style="white-space:nowrap;"
                               class="col-sm-1 control-label">품목이미지</label>
                        <div class="col-sm-11">
                            <div class="input-group">
                                <input type="text" id="fileupload" placeholder="이미지파일" class="form-control" readonly
                                       onclick="$('#detail_form_fileupload').click();">
                                <div class="input-group-btn">
                                    <button type="button" onclick="$('#detail_form_fileupload').click();"
                                            class="btn btn-info"><i class="fa fa-folder"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:-20px;padding:10px;width:100%;text-align: left;">
                <div class="col-sm-1"></div>
                <div id="upload_file" class="col-sm-11">
                    파일명 : <a href="/assets/demo/stockphoto/blog_05.jpg" download id="upload_file_name">imgfile...</a>
                    <label id="upload_file_size" for="#close">100KB</label>
                    <a href="javascript:deleteImage();" id="close" style="color: #000; font-weight: bold" class="">&nbspX</a>
                </div>
            </div>
            <div class="row" style="margin-top:-20px;padding:10px;width:100%;text-align: left;">
            <div class="col-sm-1"></div>
                <div class="col-sm-11">
                    <img src="/assets/demo/stockphoto/blog_05.jpg" style="margin:auto;max-width: 100%;" id="item_image"
                         height="160px;">
                </div>
            </div>

        </div>

    </div>
</div>