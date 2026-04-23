<?php $pager->setSurroundCount(2); ?>
<div class="pagination">
  <?php if ($pager->hasPreviousPage()): ?>
    <a href="<?= $pager->getPreviousPageURI() ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
    </a>
  <?php else: ?>
    <span class="disabled">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
    </span>
  <?php endif; ?>

  <?php foreach ($pager->links() as $link): ?>
    <?php if ($link['active']): ?>
      <span class="active"><?= $link['title'] ?></span>
    <?php else: ?>
      <a href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
    <?php endif; ?>
  <?php endforeach; ?>

  <?php if ($pager->hasNextPage()): ?>
    <a href="<?= $pager->getNextPageURI() ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
  <?php else: ?>
    <span class="disabled">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </span>
  <?php endif; ?>
</div>
