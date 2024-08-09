
<div>
    <?= $pages[$currentPage - 1]; ?>
</div>
<div class="pagination">
    <div>
        <?php if ($currentPage > 1): ?>
            <a href="index.php?action=detail&id=<?= $_GET['id']; ?>&page=<?php echo $currentPage - 1; ?>">Précédent</a>
        <?php endif; ?>
        
        Page <?= $currentPage; ?> sur <?= $totalPages; ?>
        
        <?php if ($currentPage < $totalPages): ?>
            <a href="index.php?action=detail&id=<?= $_GET['id']; ?>&page=<?php echo $currentPage + 1; ?>">Suivant</a>
        <?php endif; ?>
    </div>
</div>