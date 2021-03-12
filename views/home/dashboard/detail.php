


<div class="row">
    <div class="col-xl-12 col-lg-12">
        <!-- project card -->
        <div class="card d-block">
            <div class="card-body">
                <div class="dropdown card-widgets">
                    <a href="#" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
                        <i class="dripicons-menu"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="dripicons-plus"></i>새 글작성
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="dripicons-document-edit"></i>수정하기
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item text-danger">
                            <i class="dripicons-document-delete"></i>삭제하기
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="dripicons-cross"></i>닫기
                        </a>
                    </div> <!-- end dropdown menu-->
                    <a href="javascript:closeDetail()" class="" data-toggle="">
                        <i class="dripicons-cross"></i>
                    </a>
                </div> <!-- end dropdown-->

                <div class="clearfix"></div>

                <!--                <h3 class="mt-3">Administrator</h3>-->
                <form id="detail_form">
                    <div class="row">
                        <div class="col-12">
                            <!-- assignee -->
                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">제목</p>
                            <div class="media">
                                <!--                            <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle mr-2" height="24">-->
                                <div class="media-body">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control required" style="border-top-right-radius: 3px;border-bottom-right-radius: 3px;" placeholder="Title" id="detail_title" value="Title1234567890" />
                                            <input type="hidden" id="detail_idx" value="" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <!-- end assignee -->
                        </div> <!-- end col -->
                        <div class="col-6">
                            <!-- assignee -->
                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">작성자</p>
                            <div class="media">
                                <!--                            <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle mr-2" height="24">-->
                                <div class="media-body">
                                    <form>
                                        <div class="input-group"">
                                            <input type="text" class="form-control dropdown-toggle" style="border-top-right-radius: 3px;border-bottom-right-radius: 3px;" placeholder="작성자" id="detail_user_name" value="관리자" />
                                            <input type="hidden" id="detail_reg_userid" value="관리자" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end assignee -->
                        </div> <!-- end col -->

                        <div class="col-6">
                            <!-- assignee -->
                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">등록일시</p>
                            <div class="media">
                                <!--                            <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle mr-2" height="24">-->
                                <div class="media-body">
                                    <form>
                                        <div class="input-group"">
                                            <input type="text" class="form-control dropdown-toggle" placeholder="Datetime" id="detail_reg_dttm" value="2020-11-08 09:00:00" />
                                            <div class="input-group-append">
                                                <div class="btn" style="background-color: #67b8c7;color:#ffffff;border-bottom-right-radius: 3px;border-top-right-radius: 3px;" type="submit">
                                                    <i class="dripicons-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end assignee -->
                        </div> <!-- end col -->

                        <div class="col-12">
                            <!-- assignee -->
                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">내용</p>
                            <div class="media">
                                <!--                            <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle mr-2" height="24">-->
                                <div class="media-body">
                                    <div class="border rounded mt-0">
                                        <form action="#" class="comment-area-box">
                                            <textarea rows="3" class="form-control border-0 resize-none"  style="height:380px;" placeholder="Content" id="detail_content"></textarea>
                                            <div class="p-2 bg-light d-flex justify-content-between align-items-center">
    <!--                                            <div>-->
    <!--                                                <a href="#" class="btn btn-sm px-1 btn-light"><i class="mdi mdi-upload"></i></a>-->
    <!--                                                <a href="#" class="btn btn-sm px-1 btn-light"><i class="mdi mdi-at"></i></a>-->
    <!--                                            </div>-->
                                                <div style="width:100%;text-align: right;">
                                                    <div type="submit" class="btn btn-sm " style="color:#ffffff;background-color: <?=Theme_Config::$btn_bg_color?>;"><i class="uil uil-message"></i>저장</div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end assignee -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </form>
                <!-- end sub tasks/checklists -->

            </div> <!-- end card-body-->

        </div> <!-- end card-->
    </div> <!-- end col -->

</div>