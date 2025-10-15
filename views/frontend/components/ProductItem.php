<?php
function ProductItem($id, $image, $name, $price)
{
    if (is_string($image)) {
        $image = json_decode($image, true) ?? [];
    }
?>

<a href="index.php?controllers=product&action=detail&id=<?php echo htmlspecialchars($id); ?>"
    class="text-gray-700 cursor-pointer block">
    <div class="overflow-hidden">
        <img class="hover:scale-110 transition ease-in-out w-full h-[290px] object-cover object-top borderImage"
            src="<?= htmlspecialchars($image[0]) ?>" alt="<?php echo htmlspecialchars($name); ?>">

        <p class="pt-3 pb-1 text-sm">
            <?php echo htmlspecialchars($name); ?>
        </p>

        <p class="text-sm font-medium">
            <?php echo number_format(htmlspecialchars($price), 0, ',', '.'); ?> VND
        </p>
    </div>
</a>

<?php
}
?>