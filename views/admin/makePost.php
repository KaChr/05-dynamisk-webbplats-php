<div class="container">
    <form id="postForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return save()">
        <input type="hidden" name="author" value="<?php echo json_decode($_COOKIE['user'])->user_id ?>">
        <div class="form-group">
            <label for="title">Titel på inlägget</label>
            <input id="title" placeholder="Skriv en titel" name="title" value="" type="text" class="form-control" />
            <small id="titleHelp" class="form-text text-muted">Ge inlägget en passande titel</small>
        </div>

        <div class="form-group">
            <label for="type">Kategori</label>
            <select name="type" class="form-control">
                <option value="Fundering">Fundering</option>
                <option value="Livsstil">Livsstil</option>
                <option value="Mat">Mat</option>
                <option value="Uppfinning">Uppfinning</option>
            </select>
            <small id="typeHelp" class="form-text text-muted">Ge inlägget en passande kategori</small>
        </div>

        <div class="form-group">
            <label for="tags[]">Taggar</label>
            <select name="tags[]" multiple class="form-control">
                <?php foreach($tags as $tag): ?>
                    <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <small id="tagsHelp" class="form-text text-muted">Ge inlägget en eller flera passande taggar</small>
        </div>

        <div class="form-group">
            <textarea id="summernote" name="text"></textarea>
        </div>

        <a class="btn btn-secondary" href="/posts" title="Avbryt">Avbryt</a>
        <button class="btn btn-primary" type="submit">Lägg till post</button>
    <form>
</div>

<script>
    function save() {
        $('textarea[name="text"]') = $('#summernote').summernote('code');
    }
</script>