<div>
    <?= $pages[$currentPage - 1]; ?>
</div>

<div>
    <?php if ($currentPage > 1): ?>
        <a href="?id=<?= $_GET['id']; ?>&page=<?php echo $currentPage - 1; ?>">Précédent</a>
    <?php endif; ?>
    
    Page <?= $currentPage; ?> sur <?php echo $totalPages; ?>
    
    <?php if ($currentPage < $totalPages): ?>
        <a href="?id=<?= $_GET['id']; ?>&page=<?php echo $currentPage + 1; ?>">Suivant</a>
    <?php endif; ?>
</div>