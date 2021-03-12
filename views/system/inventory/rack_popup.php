<div class="modal fade" id="rack_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #37474f;padding:10px;height:40px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #eceff1;margin-top:0px;">&times;</button>
                <span style="color: #eceff1;height: 100%;width: auto;float: left;font-size: 13px;font-weight: 700;position: relative;" id="list_title">재고관리 품목 리스트</span>
            </div>
            <div class="modal-body">
                <div id="rack_popup_grid">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" style="background-color: #37474f;color:#ffffff; border:0px;">선택</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function() {
        Init();
        getList();
    });
    function rackpopup_Init()
    {

    }
    function rackpopup_getList()
    {

    }
</script>