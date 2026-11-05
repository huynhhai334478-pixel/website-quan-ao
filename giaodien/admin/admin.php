<?php
include "header.php";
include "slider.php";
include "class/donhang_class.php";

$donhang = new donhang();
$userCount = $donhang->getTotalUsers()->fetch_assoc()['total_users'];
$productCount = $donhang->getTotalProducts()->fetch_assoc()['total_products'];
$orderCount = $donhang->getTotalOrders()->fetch_assoc()['total_orders'];

$doanhthu_data = $donhang->get_doanhthu();
?>
<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Tổng quan hệ thống</h1>
                <table>
                    <tr style="background-color: #f2f2f2;">
                    <th>Tổng người dùng</th>
                    <th>Tổng sản phẩm</th>
                    <th>Tổng đơn hàng</th>
                </tr>
                <tr>
                    <td><?php echo $userCount; ?></td>
                    <td><?php echo $productCount; ?></td>
                    <td><?php echo $orderCount; ?></td>
                </tr>
                </table>
            </div>
            <div class="admin-content-right-doanhthu">
                <h1>Doanh thu theo tháng</h1>
                <canvas id="doanhThuChart" width="400" height="200"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('doanhThuChart').getContext('2d');
                const doanhThuData = <?php echo json_encode($doanhthu_data); ?>;
                const monthNames = [
                    "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                    "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                ];
                const labels = Object.keys(doanhThuData).map(month => monthNames[month - 1]);
                const data = Object.values(doanhThuData);

                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Doanh thu (VNĐ)',
                            data: data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    </section>
</body>
</html>