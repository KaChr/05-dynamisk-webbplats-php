<div class="container">

    <div class="row">
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $post->getTitle(); ?></h2>
                <p class="blog-post-meta"> <?php echo $post->getDate(); ?> <a href="/posts/author/<?php echo $post->getAuthorId(); ?>"><?php echo $post->getAuthor(); ?></a></p>
                <p><?php echo $post->getText(); ?></p>
                <div class="tags">
                    <span>Taggar:</span>
                    <?php foreach($post->getTagsAsArray() as $tag) : ?>
                        <a href="/tags/<?php echo 1 ?>"><span class="tag"><?php echo $tag; ?></span></a>
                    <?php endforeach; ?>
                </div>
            </div><!-- /.blog-post -->
        </div><!-- /.blog-main -->

        <?php include_once('layout.php'); ?>
    </div><!-- /.row -->

</div><!-- /.container -->