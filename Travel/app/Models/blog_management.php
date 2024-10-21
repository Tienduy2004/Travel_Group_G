<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Hàm xác nhận trước khi xóa
        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn xóa bài viết này?");
        }

        // Hàm hiển thị hình ảnh trong modal
        function showImage(src) {
            const modalImg = document.getElementById("modalImage");
            modalImg.src = src;
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }

        // Hàm hiển thị chi tiết bài viết trong modal
        function showDetails(title, content, author, createdAt, image) {
            document.getElementById("detailTitle").innerText = title;
            document.getElementById("detailContent").innerText = content;
            document.getElementById("detailAuthor").innerText = "Tác giả: " + author;
            document.getElementById("detailCreatedAt").innerText = "Ngày tạo: " + createdAt;
            document.getElementById("detailImage").src = image; // Hiển thị hình ảnh trong chi tiết
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    </script>
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Quản lý Blog</h1>

        <!-- Hiển thị thông báo sau khi thêm/sửa/xóa -->
        <?php
        session_start();
        include 'connect.php'; // Kết nối cơ sở dữ liệu
        
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success' role='alert'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>

        <!-- Nút thêm bài viết mới -->
        <div class="mb-3">
            <a href="addblog.php" class="btn btn-primary">Thêm bài viết mới</a>
        </div>

        <!-- Bảng hiển thị danh sách blog -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Tác giả (User ID)</th>
                    <th>Hình ảnh</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lấy dữ liệu từ cơ sở dữ liệu
                $sql = "SELECT * FROM posts"; // Cập nhật tên bảng
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";

                        // Lấy user_id và hiển thị
                        $author = htmlspecialchars($row['user_id']); // Hiển thị user_id
                        echo "<td>" . $author . "</td>";

                        // Hiển thị hình ảnh nếu có
                        $imagePath = htmlspecialchars($row['image_url']); // Cập nhật trường hình ảnh
                        echo "<td><img src='" . $imagePath . "' alt='Hình ảnh' style='width: 100px; height: auto;' onclick='showImage(\"$imagePath\")' style='cursor: pointer;'></td>";

                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>"; // Cập nhật trường ngày tạo
                        echo "<td>
                <a href='edit_blog.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-success btn-sm'>Sửa</a>
                <a href='delete_blog.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirmDelete();'>Xóa</a>
                <button class='btn btn-info btn-sm' onclick='showDetails(\"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['content']) . "\", \"$author\", \"" . htmlspecialchars($row['created_at']) . "\", \"$imagePath\")'>Hiển thị chi tiết</button>
            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Không có bài viết nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal để hiển thị hình ảnh  -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Hình Ảnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Hình ảnh lớn" style="width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal để hiển thị chi tiết bài viết -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Chi tiết bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="detailTitle"></h5>
                    <p id="detailContent"></p>
                    <p id="detailAuthor"></p>
                    <p id="detailCreatedAt"></p>
                    <img id="detailImage" src="" alt="Hình ảnh trong chi tiết" style="width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
