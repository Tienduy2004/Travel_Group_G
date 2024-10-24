<?php
include 'connect.php';
session_start();

// Kiểm tra xem ID có được gửi qua URL hay không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn để lấy thông tin bài viết, bao gồm cả hình ảnh
    $stmt = $conn->prepare("SELECT image_url FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_url = $row['image_url'];

        // Xóa hình ảnh nếu tồn tại
        if (!empty($image_url) && file_exists($image_url)) {
            unlink($image_url); // Xóa file hình ảnh
        }

        // Xóa bài viết sau khi đã xóa hình ảnh
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Xóa bài viết và hình ảnh thành công!";
        } else {
            $_SESSION['message'] = "Lỗi khi xóa bài viết: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Không tìm thấy bài viết.";
    }
} else {
    $_SESSION['message'] = "ID không hợp lệ.";
}

// Chuyển hướng về trang quản lý blog
header("Location: blog_management.php");
exit;
?>
