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
    <div id="detail_form_title" style="height:36px;padding:10px;font-weight: bold;padding: 10px;font-size: 11px;text-transform: uppercase;letter-spacing: 2px;color: #607d8b;background: #fafafa;border-bottom: 1px solid #eeeeee;">거래처 관리 상세정보</div>

    <div class="detail-body" style="padding:20px;">
        <div class="form-horizontal">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_category" class="col-sm-2 control-label" id="label_category">구분</label>
                        <div class="col-sm-9">
<!--                            <input type="text" class="form-control" id="detail_category" placeholder="disabled">-->
                            <select class="form-control" id="detail_form_category">
<!--                                <option value="입고처">입고처</option>-->
<!--                                <option value="출고처">출고처</option>-->
<!--                                <option value="입고+출고처">입고+출고처</option>-->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="detail_form_idx">
                        <label for="detail_form_company_code" class="col-sm-3 control-label" id="label_company_code">거래처코드</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control required duplicate" id="detail_form_company_code" placeholder="거래처코드">
<!--                            <input type="text" class="form-control required" id="detail_form_company_code" placeholder="거래처코드">-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_company_name" class="col-sm-2 control-label" id="label_company_name">거래처명</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control required" id="detail_form_company_name" placeholder="거래처명">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_tel" class="col-sm-3 control-label">대표연락처</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="detail_form_tel" placeholder="대표연락처">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_fax" class="col-sm-2 control-label">FAX</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="detail_form_fax" placeholder="FAX">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_email" class="col-sm-3 control-label">이메일</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="detail_form_email" placeholder="이메일">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_address" class="col-sm-2 control-label">주소</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="detail_form_address" placeholder="주소" style="cursor:pointer" onclick="showZipCode('write_2_zipcode','detail_form_address'); $('#detail_form_address_detail').focus()" readonly>
                                <div class="input-group-btn">
                                    <button type="button" onclick="showZipCode('write_2_zipcode','detail_form_address')"
                                            class="btn btn-info"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_address_detail" class="col-sm-3 control-label">세부주소</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="detail_form_address_detail" placeholder="세부주소">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_form_use_yn" class="col-sm-2 control-label">거래여부</label>
                        <div class="col-sm-9">
                            <!--                            <input type="text" class="form-control" id="detail_category" placeholder="disabled">-->
                            <select class="form-control" id="detail_form_use_yn">
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="detail_form_remark" class="col-sm-1 control-label">비고</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" id="detail_form_remark" placeholder="비고" cols="5"></textarea>
                        </div>
                    </div>
                </div>

<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="Field4" class="col-sm-2 control-label">Field4</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input type="text" class="form-control error" id="Field4" placeholder="error">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="Field5" class="col-sm-2 control-label">Field5</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input type="text" class="form-control readonly" readonly id="Field5" placeholder="readonly">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="Field6" class="col-sm-2 control-label">Field6</label>-->
<!--                        <div class="col-sm-10"><select name="selector1" id="Field6" class="form-control">-->
<!--                                <option>Lorem ipsum dolor sit amet.</option>-->
<!--                                <option>Dolore, ab unde modi est!</option>-->
<!--                                <option>Illum, fuga minus sit eaque.</option>-->
<!--                                <option>Consequatur ducimus maiores voluptatum minima.</option>-->
<!--                            </select></div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>

        </div>
    </div>
</div>