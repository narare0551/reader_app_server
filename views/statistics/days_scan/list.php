<div class="panel panel-midnightblue">
    <div class="panel-heading" style="height:35px;padding-right:0px;">
        <div style="float:left">
            <span style="color: #eceff1;height: 100%;width: auto;float: left;font-size: 13px;font-weight: 700;padding: 13px 0 13px;position: relative;margin: 0;line-height: 10px;" id="list_title">

            </span>
        </div>
        <!--        <div class="btn btn-default btn-sm" style="float:left;margin:5px;" onclick="location.reload();">-->
        <!--            <div style="width:20px;">-->
        <!--                <i class="fa fa-refresh"></i>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="btn btn-default btn-sm" style="float:left;margin:5px;" onclick="addRow();">-->
        <!--            <div style="width:20px;">-->
        <!--                <i class="fa fa-plus"></i>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="btn btn-default btn-sm" style="float:left;margin:5px;" onclick="removeRow();">-->
        <!--            <div style="width:20px;">-->
        <!--                <i class="fa fa-minus"></i>-->
        <!--            </div>-->
        <!--        </div>-->
        <!---->
<!--                <div class="btn btn-default btn-sm" style="float:right;margin:5px;" onclick="setPrint()">-->
<!--                    <div style="width:50px;font-weight:bold;">-->
<!--                        임시버튼-->
<!--                    </div>-->
<!--                </div>-->

    </div>
    <div class="panel-body" style="height:690px;">
        <div style="width:100%;overflow-x: scroll">
            <div id="grid" style="width:1598px;height:630px;">
                <div id="chartContainer" style="height:100%;width: 80%;margin:auto;"></div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="pop_item" style="">
        <div class="modal-dialog modal-top row" style="width:1000px; margin-top: 200px;">
            <div class="modal-content" style="width:1000px;">
                <div class="panel" style="width:1000px;">
                    <div class="panel-body" style="width:1000px; height: 500px;">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8" style="height:65px;padding-top:30px;">
                                <div class="text-right" style="" id="btn_collection"><a href="javascript:getPopupItemList()" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">검색</a></div>
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-midnightblue mb0" style="border-color:#cccccc;">
                                    <div class="panel-body p0" style="inline-height:42px;margin:0px;">
                                        <form action="" class="form-horizontal row-border" id="popup_search_form">

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="text-align: center;">

                            <div class="col-md-12 center-block">
                                <div style="width:100%;overflow-x: scroll;">
                                    <div id="grid2" style="width:100%;height:300px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center mt-1" style="margin-top: 5px">
                                <a onclick="setItem();" data-dismiss="modal" class="btn btn-default" style="background-color: #37474f;color:#ffffff;">선택</a>
                            </div>
                        </div>


                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div>
        </div>
    </div>

    <div id="print_div">
    </div>





</div>