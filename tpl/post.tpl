<div class="col-lg-12 post">
    <div class="col-xs-2" align="right">
        <div class="profile post-profile" style="background-image:url('/assets/avatars/@[user_name].jpg');"></div>
    </div>
    <div class="col-xs-10" style="margin-top:15px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span>@[user_fullname]</span>
                    <span class="pull-right text-muted timestamp">@[post_timestamp]</span>
                </h3>
            </div>
            <div class="panel-body">
                @[post_body]
                <div class="post-ctrl">
                    <a href="/?delete_post=%s" class="btn btn-danger btn-delete">delete</a>
                </div>
                <div class="buttons-ctrl">
                    <a class="btn btn-success" href="javascript:void();" id="reply_post_@[post_id]" data-post-id="@[post_id]">reply</a>
                </div>
                <div data-comments-num="@[comment_count]" class="text-muted comment-count">@[comment_count] replies</div>
            </div>
        </div>
        <div id="comment_list_box_@[post_id]">@[comment_list]</div>
        <div class="col-lg-12 post" id="comment_box_@[post_id]">
            <div class="col-xs-2" align="right">
                <div class="profile post-profile" style="background-image:url('/assets/avatars/@[current_user_name].jpg');"></div>
            </div>
            <div class="col-xs-10" style="margin-top:15px;">
                <div class="panel panel-default">
                    <div class="panel-body" align="right">
                        <form action="" method="POST" class="comment-composer">
                            <input type="hidden" name="user_id" value="@[current_user_id]" />
                            <input type="hidden" name="post_id" value="@[post_id]" />
                            <input type="hidden" name="action" value="add_comment" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea class="form-control" name="body" id="comment_body" placeholder="add a comment"></textarea>
                                    <button class="btn btn-success btn-comment" name="submit">
                                        reply
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="post-ctrl">
                            <a href="/?delete_post=%s" class="btn btn-danger btn-delete">delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
