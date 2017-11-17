<div class="container">

<?php if (isset($_COOKIE['User'])): ?>

<!-- visa formen med värdena -->
<form method="POST" action="/updatePost">
    <input name="title" value="<?php echo $post->getTitle(); ?>" type="text" />
    <input name="author" value="<?php echo $post->getAuthor(); ?>" type="text" />
    <textarea name="text"><?php echo $post->getText(); ?></textarea>

    <a href="/posts" title="Avbryt">Avbryt</a>
    <button type="submit">Uppdatera</button>
</form>

<?php else: ?>

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
    
<?php endif; ?>

</div><!-- /.container -->