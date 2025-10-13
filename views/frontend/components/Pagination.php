<nav class="flex items-center justify-center space-x-1 select-none">
    <?php if ($currentPage > 1): ?>
        <a href="?controllers=product&action=index&page=<?= $currentPage - 1 ?>"
           class="px-3 py-1 border rounded-lg bg-white text-gray-700 hover:bg-gray-100 transition">
            &laquo;
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?controllers=product&action=index&page=<?= $i ?>"
           class="px-3 py-1 border rounded-lg transition 
                  <?= $i == $currentPage 
                      ? 'bg-blue-500 text-white font-semibold border-blue-500' 
                      : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?controllers=product&action=index&page=<?= $currentPage + 1 ?>"
           class="px-3 py-1 border rounded-lg bg-white text-gray-700 hover:bg-gray-100 transition">
            &raquo;
        </a>
    <?php endif; ?>
</nav>
