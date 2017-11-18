<div class="container">

<?php if (isset($_COOKIE['User'])): ?>

<!-- visa formen med värdena -->
<form method="POST" action="/update/post">
    <input name="id" type="hidden" value="<?php echo $post->getNumber(); ?>" />
    <input name="title" value="<?php echo $post->getTitle(); ?>" type="text" />
    <input name="author" value="<?php echo $post->getAuthor(); ?>" type="text" />
    <select name="tags[]" multiple>
    <?php foreach($tags as $tag): ?>
        <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
    <?php endforeach; ?>
    </select>
    <textarea name="text"><?php echo $post->getText(); ?></textarea>

    <a href="/posts" title="Avbryt">Avbryt</a>
    <button type="submit">Uppdatera</button>
</form>
<form method="POST" action="/delete/post">
    <input name="post_id" type="hidden" value="<?php echo $post->getNumber(); ?>" />
    <button type="submit">Radera</button>
</form>

<?php else: ?>

    <div class="row">
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $post->getTitle(); ?></h2>
                <p class="blog-post-meta"> <?php echo $post->getDate(); ?> <a href="#"><?php echo $post->getAuthor(); ?></a></p>
                <p><?php echo $post->getText(); ?></p>
            </div><!-- /.blog-post -->
        </div><!-- /.blog-main -->

        <?php include_once('layout.php'); ?>
    </div><!-- /.row -->

    
<?php endif; ?>

</div><!-- /.container -->