<div class="w-full mx-auto my-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Danh sách Người Dùng</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($users as $user): ?>
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700"><?= $user['id'] ?></td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700"><?= $user['name'] ?></td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700"><?= $user['email'] ?></td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">
                        <?= !empty($user['created_at']) ? date('d-m-Y H:i:s', strtotime($user['created_at'])) : '' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>