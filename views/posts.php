<div class="container">

    <div class="row">
        <div class="col-sm-8 blog-main">
        <?php if (isset($posts) && !empty($posts)): ?>
            <?php foreach($posts as $post): ?>
                <?php if(isset($message)): ?>
                    <em>
                        <?php
                            $tagName = $post->tag_name ?? '';
                            echo $message . " " .  $tagName
                        ?>
                    </em>
                    <hr>
                <?php endif;?>
                <div class="blog-post">
                    <h2 class="blog-post-title">
                        <a href="/post/<?php echo $post->getNumber(); ?>">
                            <?php echo $post->getTitle(); ?>
                        </a>
                    </h2>
                    <div>
                        <a href="/dashboard/post/<?php echo $post->getNumber(); ?>/edit">
                            Redigera detta inlägg
                        </a>
                    </div>
                    <span><strong>Kategori</strong>: <em><?php echo $post->getType(); ?></em></span>
                    <p class="blog-post-meta"> <?php echo $post->getDate(); ?> <a href="/posts/author/<?php echo $post->getAuthorId(); ?>"><?php echo $post->getAuthor(); ?></a></p>
                    <p><?php echo $post->getText() ?></p>
                    <?php if(!isset($message)): ?>
                        <div class="tags">
                            <span>Taggar:</span>
                            <?php foreach($tags as $tag) : ?>
                                <?php foreach($post->getTagsAsArray() as $postTag): ?>
                                    <?php if($tag['tag_name'] === $postTag): ?>
                                        <a href="/tags/<?php echo $tag['tag_id'] ?>"><span class="tag"><?php echo $tag['tag_name']; ?></span></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div><!-- /.blog-post -->
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Inga inlägg ännu. :'(</p>
        <?php endif; ?>
        </div><!-- /.blog-main -->

        <?php include_once('layout.php'); ?>

    </div><!-- /.row -->
</div><!-- /.container -->