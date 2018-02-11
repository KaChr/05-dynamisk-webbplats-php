<div class="col-sm-3 offset-sm-1 blog-sidebar">
    <form class="navbar-form" role="search" action="/posts/search" method="post">
        <div class="input-group">
            <input class="form-control" type="text" name="search" placeholder="Sök">
            <div class="input-group-btn">
                <button class="btn btn-primary" type="submit">Sök</button>
            </div>
        </div>
    </form>

    <div class="sidebar-module sidebar-module-inset">
        <h4>Om</h4>
        <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
    </div>

    <div class="sidebar-module">
        <h4>Arkiv</h4>
        <ol class="list-unstyled">
            <li><a href="/type/Fundering">Fundering</a></li>
            <li><a href="/type/Livsstil">Livsstil</a></li>
            <li><a href="/type/Mat">Mat</a></li>
            <li><a href="/type/Uppfinning">Uppfinning</a></li>
        </ol>
    </div>
    <div class="sidebar-module">
        <h4>Taggar</h4>
        <ol class="list-unstyled">
            <?php foreach ($tags as $tag): ?>
                <li><a href="/tags/<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div><!-- /.blog-sidebar -->