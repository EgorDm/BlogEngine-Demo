<?php include_once 'header.php'?>

<div class="container">
    <div style="margin-top: 50px"></div>
    <?php if(isset($_GET['action'])) { if($_GET['action']== 1) { ?>
        <div class="alert alert-success" role="alert">Logged in succesfully!</div>
    <?php } else if($_GET['action']== 2) { ?>
        <div class="alert alert-success" role="alert">Logged out succesfully!</div>
    <?php } else if($_GET['action']== 3) { ?>
        <div class="alert alert-success" role="alert">Post deleted succesfully.</div>
    <?php } else if($_GET['action']== 4) { ?>
        <div class="alert alert-danger" role="alert">Deleting or Editing another users post is disabled in the demo version. For obvious reasons of course.</div>
    <?php }} ?>
    <div class="jumbotron">
        <h1>This website demonstrates the features and the use of the BlogEngine.</h1>
        <p>
            <a class="btn btn-primary btn-l" href="https://github.com/EgorDm/BlogEngine" role="button">Clone the Github repo</a>
            <a class="btn btn-primary btn-link" href="https://github.com/EgorDm/BlogEngine/archive/master.zip" role="button">Download .zip</a>
        </p>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-8">
                <?php
                $post_list = $bea->get_post_row(5);
                if($isloggedin) {
                    $can_delete = $bea->user->has_permission($_SESSION['user_id'], 'perm_deletepost');
                    $can_edit = $bea->user->has_permission($_SESSION['user_id'], 'perm_editpost');
                }
                foreach ($post_list as $row) {
                ?>
                <div class="post">
                    <?php if($isloggedin && ($can_delete || $can_edit)) { ?>
                    <div class="btn-group post-action">
                        <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <?php if($can_edit) { ?><li><a href="action.php?action=editpost&post=<?php echo $row['post_id']; ?>">Edit</a></li><?php } ?>
                            <?php if($can_edit) { ?><li><a href="action.php?action=deletepost&post=<?php echo $row['post_id']; ?>">Delete</a></li><?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                    <h2 class="headline"><a href="action.php?action=viewpost&post=<?php echo $row['post_id']; ?>"><?php echo $row['post_title']; ?></a></h2>
                    <p class="headline-meta">by <?php echo $bea->user->get_username($row['post_owner']) . ' on ' . date_format(date_create($row['post_date']), 'd F Y'); ?></p>
                    <div class="post-content">
                        <p>
                            <?php echo $row['post_cont']; ?>
                        </p>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php include 'widgets.php' ?>
        </div>
    </div>
</div>


<script src="js/bootstrap.min.js"></script>
</body>
</html>