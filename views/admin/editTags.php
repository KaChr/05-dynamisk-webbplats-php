<div class="container">
    <form id="tagsForm" action="/dashboard/tags/create" method="POST">
        <input type="hidden" name="author" value="<?php echo json_decode($_COOKIE['user'])->user_id ?>">

        <ul>
            <?php if(count($tags) > 0): ?>
            <?php foreach($tags as $tag): ?>
                <li>
                  <a href="/dashboard/tags/<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></a>
                  <a href="/dashboard/tags/<?php echo $tag['tag_id']; ?>/delete"> X </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div>
          <p>Skapa en ny tagg nedan</p>
          <label for="tag_name">Namnge din tagg</label>
          <input type="text" name="tag_name" />
          <button class="btn btn-primary" type="submit">Spara</button>
        </div>
            <?php else: ?>
              <div>
                <p>Du har inga taggar :'(. Skapa en ny nedan</p>
                <label for="tag_name">Namnge din tagg</label>
                <input type="text" name="tag_name" />
                <button class="btn btn-primary" type="submit">Spara</button>
              </div>
            <?php endif; ?>
    <form>
    <a class="btn btn-secondary" href="/dashboard" title="Avbryt">Tillbaka till dashboard</a>
</div>