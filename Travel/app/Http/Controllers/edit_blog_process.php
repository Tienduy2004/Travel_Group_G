<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = (int)$_POST['user_id']; // Lấy user_id từ form
    $target_file = ""; // Khởi tạo biến cho URL hình ảnh

    // Kiểm tra thư mục uploads
    $target_dir = "uploads/"; // Thư mục để lưu ảnh
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Tạo thư mục nếu không tồn tại
    }

    // Kiểm tra xem có checkbox xóa hình ảnh không
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == 1) {
        // Lấy URL hình ảnh hiện tại từ database
        $stmt = $conn->prepare("SELECT image_url FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_image = $row['image_url'];

            // Xóa file hình ảnh nếu tồn tại
            if (file_exists($current_image)) {
                unlink($current_image);
            }

            // Cập nhật URL hình ảnh về rỗng trong database
            $target_file = "";
        }
        $stmt->close();
    }

    // Kiểm tra xem có file ảnh mới không và xử lý upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Xử lý upload file ảnh
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra loại file
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Kiểm tra kích thước file (giới hạn 5MB)
        if ($_FILES["image"]["size"] > 5000000) {
            $_SESSION['message'] = "File quá lớn!";
            $uploadOk = 0;
        }

        // Cho phép các định dạng ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['message'] = "Chỉ cho phép file JPG, JPEG, PNG & GIF.";
            $uploadOk = 0;
        }

        // Kiểm tra xem upload có gặp lỗi không
        if ($uploadOk == 0) {
            $_SESSION['message'] = "Xin lỗi, file không thể được tải lên.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $_SESSION['message'] = "File ". basename( $_FILES["image"]["name"]). " đã được tải lên.";
            } else {
                $_SESSION['message'] = "Xin lỗi, đã có lỗi xảy ra khi tải file lên.";
            }
        }
    }

    // Cập nhật bài viết
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, image_url = ?, user_id = ? WHERE id = ?");
    $stmt->bind_param("sssii", $title, $content, $target_file, $userId, $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Bài viết đã được cập nhật thành công!";
    } else {
        $_SESSION['message'] = "Lỗi khi cập nhật bài viết.";
    }

    header("Location: blog_management.php");
    exit();
}
?>
