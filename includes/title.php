<?php
function Title($text1, $text2)
{
    echo '
    <div class="inline-flex gap-2 items-center mb-3">
        <p class="text-gray-500">
            ' . htmlspecialchars($text1) . '
            <span class="text-gray-700 ml-2 font-medium">' . htmlspecialchars($text2) . '</span>
        </p>
        <p class="w-8 sm:w-12 h-[1px] sm:h-[2px] bg-gray-700"></p>
    </div>';
} 