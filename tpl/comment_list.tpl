
<div class="col-lg-12 post" id="comment_@[comment_id]">
    <div class="col-xs-2" align="right">
        <div class="profile post-profile" style="background-image:url('/assets/avatars/@[user_name].jpg');"></div>
    </div>
    <div class="col-xs-10" style="margin-top:15px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span>@[user_fullname]</span>
                    <span class="pull-right text-muted timestamp">@[comment_timestamp]</span>
                </h3>
            </div>
            <div class="panel-body">
                @[comment_body]
                <div class="post-ctrl">
                    <a href="/?delete_post=%s" class="btn btn-danger btn-delete">delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
