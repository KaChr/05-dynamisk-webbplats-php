<div class="container">
    <form method="POST" action="/dashboard/tags/<?php echo $tag['tag_id']; ?>/update">
        <input name="tag_name" value="<?php echo $tag['tag_name']; ?>" type="text" />
        <button type="submit">Spara ändringar</button>
    <form>
    <div>
      <button href="/dashboard/tags" title="Avbryt">Avbryt</button>
    </div>
</div>