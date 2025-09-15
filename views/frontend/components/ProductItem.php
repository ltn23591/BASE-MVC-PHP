<?php
function ProductItem($id, $image, $name, $price)
{
?>
    <a href="index.php?controllers=product&action=detail&id=<?php echo htmlspecialchars($id); ?>"
        class="text-gray-700 cursor-pointer block">
        <div class="overflow-hidden">
            <img class="hover:scale-110 transition ease-in-out w-full h-auto"
                src="<?php echo htmlspecialchars($image[0]); ?>" alt="<?php echo htmlspecialchars($name); ?>">

            <p class="pt-3 pb-1 text-sm">
                <?php echo htmlspecialchars($name); ?>
            </p>

            <p class="text-sm font-medium">
                $<?php echo htmlspecialchars($price); ?>
            </p>
        </div>
    </a>
<?php
}
?>