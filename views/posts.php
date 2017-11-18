<div class="container">

    <div class="row">
        <div class="col-sm-8 blog-main">
        <?php foreach($posts as $post): ?> 
            <div class="blog-post">
                <h2 class="blog-post-title">
                    <a href="/post/<?php echo $post->getNumber(); ?>">
                        <?php echo $post->getTitle(); ?>
                    </a>
                </h2>
                <span><?php echo $post->getType(); ?></span>
                <p class="blog-post-meta"> <?php echo $post->getDate(); ?> <a href="#"><?php echo $post->getAuthor(); ?></a></p>
                <p><?php echo $post->getText() ?></p>
                <div class="tags">
                <span>Taggar:</span>
                <?php foreach($post->getTagsAsArray() as $tag) : ?>
                    <span class="tag"><?php echo $tag; ?></span>
                <?php endforeach; ?>
                </div>
            </div><!-- /.blog-post -->
            <?php endforeach; ?>
        </div><!-- /.blog-main -->

        <?php include_once('layout.php'); ?>

    </div><!-- /.row -->
</div><!-- /.container -->