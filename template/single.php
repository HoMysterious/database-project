<?php
include "common/header.php";
?>
    <div class="jumbotron">
        <div class="container">
            <h1 class="title"><?php echo $_BLOG_SETTINGS->blog_title; ?></h1>
            <h3><?php echo $_BLOG_SETTINGS->description; ?></h3>
        </div>
    </div>

    <div class="wrapper">
        <div class="container">
            <div class="col-lg-9">
                <section class="post">
                    <?php $post = $PARAMETERS['OBJECT']; ?>
                    <div class="title-wrap clearfix">
                        <i class="glyphicon glyphicon-edit"></i>
                        <h2 class="post-title"><?php echo $post->title; ?></h2>
                    </div>
                    <div class="info">
                <span class="time"><i
                        class="glyphicon glyphicon-time"></i><?php $date = new farhadi\IntlDateTime(strtotime($post->date), 'Asia/Tehran', 'persian', 'fa');
                    echo $date->format('E dd LLL yyyy'); ?></span>
                        <a href="#comments"><span class="comment"><i
                                    class="glyphicon glyphicon-comment"></i><?php echo $post->comment_count; ?>
                                کامنت</span></a>
                    </div>
                    <article>
                        <?php echo $post->content; ?>
                    </article>
                </section>
                <section id="comments">
                    <div class="list">
                        <?php
                        $db->load_comments($post->id);
                        $comment = $db->next_comment();
                        if (!$comment) : echo '<h3>هنوز دیدگاهی وجود ندارد.</h3>';
                        else : do { ?>
                            <div class="comment-header clearfix">
                                <div class="sender"><i class="glyphicon glyphicon-user"></i>
                                    نویسنده: <?php echo $comment->author; ?></div>
                                <div
                                    class="date"><i
                                        class="glyphicon glyphicon-time"></i> <?php $date = new \farhadi\IntlDateTime(strtotime($comment->date), 'Asia/Tehran', 'persian', 'fa');
                                    echo $date->format('E dd LLL yyyy'); ?>
                                </div>
                            </div>
                            <div class="comment-body"><?php echo $comment->content; ?></div>
                        <?php } while ($comment = $db->next_comment()); endif; ?>
                    </div>
                    <h2>یک کامنت بنویسید</h2>
                    <form class="form-horizontal" role="form" method="post" action="<?php url(); ?>/comment.php">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">نام:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="نام خود را وارد کنید.">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">ایمیل:</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="ایمیل خود را وارد کنید. (مثل ho.mysterious@gmail.com)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">متن:</label>
                            <div class="col-sm-10">
                                <textarea name="content" id="content" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>

                        <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
                    </form>
                </section>
            </div>

            <div class="col-lg-3">
                <section>
                    <h2>لینک‌ها</h2>
                    <div class="body">
                        <?php
                        $db->load_links();
                        $link = $db->next_link();
                        if (!$link) : echo '<h3>لینکی وجود ندارد</h3>';
                        else : ?>
                            <div class="list-group">
                                <?php do { ?>
                                    <a class="list-group-item"
                                       href="<?php echo $link->address; ?>"><?php echo $link->display_name; ?></a>
                                <?php } while ($link = $db->next_link()); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
                <section>
                    <h2>برچسب‌ها</h2>
                    <div class="body">
                        <?php
                        $db->load_tags();
                        $tag = $db->next_tag();
                        if (!$tag) : echo '<h3>برچسبی وجود ندارد</h3>';
                        else : ?>
                            <div class="list-group">
                                <?php do { ?>
                                    <a class="list-group-item"
                                       href="<?php url(); ?>/tag/<?php echo $tag->name; ?>"><span
                                            class="badge"><?php echo $tag->posts_count; ?></span><?php echo $tag->title; ?>
                                    </a>
                                <?php } while ($tag = $db->next_tag()); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
                <section>
                    <h2>نویسندگان</h2>
                    <div class="body">
                        <?php
                        $db->load_authors();
                        $author = $db->next_author();
                        if (!$author) : echo '<h3>نویسنده‌ای وجود ندارد</h3>';
                        else : ?>
                            <div class="list-group">
                                <?php do { ?>
                                    <a class="list-group-item"
                                       href="<?php url(); ?>/author/<?php echo $author->username; ?>"><span
                                            class="badge"><?php echo $author->posts_count; ?></span><?php echo $author->username; ?>
                                    </a>
                                <?php } while ($author = $db->next_author()); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php include "common/footer.php"; ?>