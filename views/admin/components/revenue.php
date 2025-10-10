<div class="p-6">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">📊 Thống kê doanh thu</h3>

    <!-- Các thẻ thống kê -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Tổng doanh thu (Đã giao) -->
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold">Tổng Doanh Thu</h4>
            <p class="text-3xl font-bold mt-2">
                <?= number_format($totalRevenue ?? 0, 0, ',', '.') ?> VND
            </p>
            <p class="text-sm opacity-80 mt-1">Từ các đơn hàng đã giao</p>
        </div>

        <!-- Doanh thu (Chờ xác nhận) -->
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold">Chờ xác nhận</h4>
            <p class="text-3xl font-bold mt-2">
                <?= number_format($statusRevenues['Chờ xác nhận'] ?? 0, 0, ',', '.') ?> VND
            </p>
            <p class="text-sm opacity-80 mt-1">Doanh thu từ đơn hàng mới</p>
        </div>

        <!-- Doanh thu (Đang giao) -->
        <div class="bg-orange-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold">Đang giao</h4>
            <p class="text-3xl font-bold mt-2">
                <?= number_format($statusRevenues['Đang giao'] ?? 0, 0, ',', '.') ?> VND
            </p>
            <p class="text-sm opacity-80 mt-1">Doanh thu từ đơn hàng đang vận chuyển</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-lg font-semibold text-gray-700 mb-4">Doanh thu hàng tháng (Đơn hàng đã giao)</h4>
        <div id="revenueChart"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy dữ liệu từ PHP
        const chartData = <?= json_encode($chartData ?? ['categories' => [], 'series' => []]) ?>;

        const options = {
            series: [{
                name: 'Doanh thu',
                data: chartData.series
            }],
            chart: {
                type: 'line', // Thay đổi loại biểu đồ thành 'line'
                height: 350,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth' // Làm cho đường cong mượt hơn
            },
            xaxis: {
                categories: chartData.categories,
            },
            yaxis: {
                title: {
                    text: 'VND'
                },
                labels: {
                    formatter: function(val) {
                        return val.toLocaleString('vi-VN');
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toLocaleString('vi-VN') + " VND"
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#revenueChart"), options);
        chart.render();
    });
</script>