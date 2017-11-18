<form method="POST" action="">
    <input placeholder="Skriv en titel" name="title" value="" type="text" />
    <input placeholder="Vem är du" name="author" value="" type="text" />
    <select name="type">
        <option value="Fundering">Fundering</option>
        <option value="Livsstil">Livsstil</option>
        <option value="Mat">Mat</option>
        <option value="Uppfinning">Uppfinning</option>
    </select>
    
    <select name="tags[]" multiple>
    <?php foreach($tags as $tag): ?>
        <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
    <?php endforeach; ?>
    </select>
    
    <textarea placeholder="Skriv text..." name="text">
        
    </textarea>

    <a href="/posts" title="Avbryt">Avbryt</a>
    <button type="submit">Lägg till post</button>
<form>