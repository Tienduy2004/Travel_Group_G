<?php
session_start();
include 'connect.php';

// Kiểm tra phương thức yêu cầu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $user_id = $conn->real_escape_string($_POST['user_id']); // Nhận user_id từ form

    // Lấy categories từ input
    if (isset($_POST['categories'])) {
        $categories = $conn->real_escape_string($_POST['categories']);
    } else {
        $_SESSION['message'] = "Vui lòng chọn danh mục.";
        header("Location: blog_management.php");
        exit;
    }

    // Handle image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . uniqid() . '-' . basename($_FILES["image"]["name"]);

    // Kiểm tra upload lỗi
    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "Có lỗi khi tải lên hình ảnh.";
        header("Location: blog_management.php");
        exit;
    }

    // Kiểm tra nếu file là hình ảnh
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['message'] = "File không phải là hình ảnh.";
        header("Location: blog_management.php");
        exit;
    }

    // Kiểm tra kích thước file
    if ($_FILES["image"]["size"] > 2 * 1024 * 1024) {
        $_SESSION['message'] = "Kích thước file phải nhỏ hơn 2MB.";
        header("Location: blog_management.php");
        exit;
    }

    // Di chuyển file vào thư mục uploads
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Chèn vào cơ sở dữ liệu
        $created_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
        $stmt = $conn->prepare("INSERT INTO posts (user_id, categories, title, content, image_url, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $categories, $title, $content, $target_file, $created_at);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Bài viết đã được thêm thành công!";
        } else {
            $_SESSION['message'] = "Lỗi khi thêm bài viết: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Có lỗi khi tải lên hình ảnh.";
    }

    header("Location: blog_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bài Viết</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Thêm Bài Viết Mới</h1>

    <!-- Hiển thị thông báo nếu có -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-success' role='alert'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    ?>

    <form action="addblog.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="categories" class="form-label">Danh Mục</label>
            <input type="text" class="form-control" id="categories" name="categories" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">User ID (Tác Giả)</label>
            <input type="text" class="form-control" id="user_id" name="user_id" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Hình Ảnh</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Bài Viết</button>
        <a href="blog_management.php" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
