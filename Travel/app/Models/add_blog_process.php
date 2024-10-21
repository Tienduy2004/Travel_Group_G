<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

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
        $stmt = $conn->prepare("INSERT INTO posts (categories, title, content, image_url, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $categories, $title, $content, $target_file);

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
