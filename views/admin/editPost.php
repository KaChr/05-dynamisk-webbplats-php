<div class="container">
    <form id="postForm" action="/update/post" method="POST" enctype="multipart/form-data" onsubmit="return save()">
        <input type="hidden" name="id" value="<?php echo $post->getNumber() ?>">
        <input type="hidden" name="author" value="<?php echo json_decode($_COOKIE['user'])->user_id ?>">
        <div class="form-group">
            <input id="title" name="title" value="<?php echo $post->getTitle() ?>" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label for="type">Kategori</label>
            <select name="type" class="form-control">
                <option value="Fundering">Fundering</option>
                <option value="Livsstil">Livsstil</option>
                <option value="Mat">Mat</option>
                <option value="Uppfinning">Uppfinning</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tags[]">Taggar</label>
            <select name="tags[]" multiple class="form-control">
                <?php foreach($tags as $tag): ?>
                    <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <textarea id="summernote" name="text">
                <?php echo $post->getText() ?>
            </textarea>
        </div>

        <a class="btn btn-secondary" href="/post/<?php echo $post->getNumber() ?>" title="Avbryt">Avbryt</a>
        <button class="btn btn-primary" type="submit">Spara ändringar</button>
    <form>
</div>

<script>
    function save() {
        debugger;
        $('textarea[name="text"]') = $('#summernote').summernote('code');
    }
</script>