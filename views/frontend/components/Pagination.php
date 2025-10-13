<nav class="flex items-center justify-center space-x-1 select-none">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?controllers=product&action=index&page=<?= $i ?>"
           class="px-3 py-1 border rounded-lg transition 
                  <?= $i == $currentPage 
                      ? 'bg-blue-500 text-white font-semibold border-blue-500' 
                      : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</nav>
