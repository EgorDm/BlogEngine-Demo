<div class="col-md-4">
    <?php if(!$isloggedin) { ?>
    <div class="post">
        <div class="widget-title">
            <span class="glyphicon glyphicon-user"></span>
            <h2>Admin panel</h2>
        </div>
        <p>You can use the admin features by logging in with these credentials or registering your own account. You can your own post! Note: Not all features are functional in the demo version.</p>
        <dl class="dl-horizontal">
            <dt>Username:</dt>
            <dd>beadmin</dd>
            <dt>Password:</dt>
            <dd>safepassword</dd>
        </dl>
    </div>
    <?php } else { ?>
        <div class="post">
            <div class="widget-title">
                <span class="glyphicon glyphicon-file"></span>
                <h2>Create new post</h2>
            </div>
            <p>You can create your own post to share your thoughts about the BlogEngine or just something for everyone to see.</p>
            <p>
                <a class="btn btn-primary btn-l" href="action.php?action=newpost" role="button">Create new post</a>
            </p>
        </div>
    <?php }?>
    <div class="post">
        <div class="widget-title">
            <span class="glyphicon glyphicon-download"></span>
            <h2>Download Demo</h2>
        </div>
        <p>You can download this demo website to use it for your own website or check how it works.</p>
        <p>
            <a class="btn btn-primary btn-l" href="https://github.com/EgorDm/BlogEngine" role="button">Clone the Github repo</a>
            <a class="btn btn-primary btn-link" href="https://github.com/EgorDm/BlogEngine/archive/master.zip" role="button">Download .zip</a>
        </p>
    </div>
</div>