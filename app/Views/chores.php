<h2><?= $title ?></h2>
<?php if( !empty($dwarves)) : ?>
    <ul>
    <?php foreach ($dwarves as $dwarf) : ?>
        <li><a href="chores/assign/<?= $dwarf['id']?>"><?= $dwarf['name'] ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php else : ?>

    <h3>No Dwarves</h3>

    <p>Unable to find any dwarves for you.</p>
<?php endif ?>
