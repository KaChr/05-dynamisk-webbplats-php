<div class="container">

    <div class="row">
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $post->getTitle(); ?></h2>
                <p class="blog-post-meta"> <?php echo $post->getDate(); ?> <a href="#"><?php echo $post->getAuthor(); ?></a></p>
                <p class="tags"><?php echo $post->getTags(); ?></p>
                <p><?php echo $post->getText(); ?></p>
            </div><!-- /.blog-post -->
        </div><!-- /.blog-main -->
    </div><!-- /.row -->
    
</div><!-- /.container -->