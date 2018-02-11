<div class="container">

    <div class="row">
        <div class="col-sm-8 blog-main">
        <?php if (isset($posts) && !empty($posts)): ?>
            <?php foreach($posts as $post): ?>
                <div class="blog-post">
                    <h2 class="blog-post-title">
                        <a href="/post/<?php echo $post->getNumber(); ?>">
                            <?php echo $post->getTitle(); ?>
                        </a>
                        <a href="/update/post">
                            <i class="fa fa-pen"></i>
                        </a>
                    </h2>
                    <span><?php echo $post->getType(); ?></span>
                    <p class="blog-post-meta"> <?php echo $post->getDate(); ?> <a href="/posts/author/<?php echo $post->getAuthor(); ?>"><?php echo $post->getAuthor(); ?></a></p>
                    <p><?php echo $post->getText() ?></p>
                    <div class="tags">
                    <span>Taggar:</span>
                    <?php foreach($post->getTagsAsArray() as $tag) : ?>
                        <span class="tag"><?php echo $tag; ?></span>
                    <?php endforeach; ?>
                    </div>
                </div><!-- /.blog-post -->
            <?php endforeach; ?>
        <?php else: ?>
            <p>Inga inlägg ännu. :'(</p>
        <?php endif; ?>
        </div><!-- /.blog-main -->

        <?php include_once('layout.php'); ?>

    </div><!-- /.row -->
</div><!-- /.container -->