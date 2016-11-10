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
                <?php
                $post = $db->next_row();
                if (!$post) : ?>
                    <h3>Not posts added yet.</h3>
                <?php else : do { ?>
                    <section class="post">
                        <div class="title-wrap clearfix">
                            <i class="glyphicon glyphicon-edit"></i>
                            <h2 class="post-title"><a class="link" href="<?php url();
                                echo '/' . $post->id; ?>"><?php echo $post->title; ?></a></h2>
                        </div>
                        <div class="info">
                    <span class="time"><i
                            class="glyphicon glyphicon-time"></i><?php $date = new farhadi\IntlDateTime(strtotime($post->date), 'Asia/Tehran', 'persian', 'fa');
                        echo $date->format('E dd LLL yyyy'); ?></span>
                    <span class="comment"><i class="glyphicon glyphicon-comment"></i><?php echo $post->comment_count; ?>
                        کامنت</span>
                        </div>
                        <article>
                            <?php echo $post->content; ?>
                        </article>
                    </section>
                <?php } while ($post = $db->next_row()); endif; ?>
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
        <div class="container">
            <?php
            $page = intval($PARAMETERS['page']);
            $back = $page > 1;
            $count = $db->get_count();

            $front = ($count - ($page * $_BLOG_SETTINGS->posts_per_page)) > $page;
            ?>
            <?php if ($back || $front) { ?>
                <nav>
                    <ul class="pager">
                        <?php if($back) { ?><li><a href="<?php echo $PARAMETERS['curl'] . '?page=' . ($page - 1); ?>">قبلی</a></li><?php } ?>
                        <?php if($front) { ?><li><a href="<?php echo $PARAMETERS['curl'] . '?page=' . ($page + 1); ?>">بعدی</a></li><?php } ?>
                    </ul>
                </nav>
            <?php } ?>
        </div>
    </div>

<?php include "common/footer.php"; ?>