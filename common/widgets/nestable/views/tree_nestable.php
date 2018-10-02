
    <ol class="dd-list">
      <?php foreach ($level as $item): ?>
          <?= $this->render('_tree_nestable_item', compact('item', 'id')); ?>
      <?php endforeach; ?>
    </ol>  

