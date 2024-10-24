<?php
session_start();
include 'connect.php';

// Kiểm tra xem ID bài viết có được cung cấp không
if (isset($_GET['id'])) {
    $postId = (int)$_GET['id'];

    // Chuẩn bị câu lệnh SQL để lấy bài viết
    $sql = "SELECT * FROM posts WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
        } else {
            $_SESSION['message'] = "Không tìm thấy bài viết.";
            header("Location: blog_management.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Lỗi khi chuẩn bị câu lệnh: " . $conn->error;
        header("Location: blog_management.php");
        exit;
    }
} else {
    $_SESSION['message'] = "Không có ID bài viết.";
    header("Location: blog_management.php");
    exit;
}

// Xử lý biểu mẫu gửi để chỉnh sửa bài viết
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $userId = (int)$_POST['user_id']; // Lấy user_id từ form
    $image = $post['image_url']; // Giữ lại URL hình ảnh cũ

    // Xử lý tải lên hình ảnh nếu có hình ảnh mới
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Kiểm tra file có phải là hình ảnh
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            // Tạo thư mục uploads nếu chưa tồn tại
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            // Di chuyển file đã tải lên
            $image = 'uploads/' . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                $_SESSION['message'] = "Lỗi khi tải lên hình ảnh.";
                header("Location: blog_management.php");
                exit;
            }
        } else {
            $_SESSION['message'] = "Định dạng file không hợp lệ. Chỉ hỗ trợ JPG, JPEG, PNG, GIF.";
            header("Location: blog_management.php");
            exit;
        }
    }

    // Cập nhật bài viết trong cơ sở dữ liệu
    $sql = "UPDATE posts SET title = ?, content = ?, image_url = ?, user_id = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssiii", $title, $content, $image, $userId, $postId);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Cập nhật bài viết thành công!";
            header("Location: blog_management.php");
            exit;
        } else {
            $_SESSION['message'] = "Lỗi: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "Lỗi khi chuẩn bị câu lệnh: " . $conn->error;
    }

    // Chuyển hướng về trong trường hợp lỗi
    header("Location: blog_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Chỉnh sửa bài viết</h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>

    <form action="edit_blog_process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>"> <!-- Thêm id ẩn -->
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($post['user_id']); ?>"> <!-- Thêm user_id ẩn -->
        
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea class="form-control" id="content" name="content" rows="4" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="currentImage" class="form-label">Hình ảnh hiện tại</label>
            <div>
                <?php if (!empty($post['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Hình ảnh hiện tại" style="max-width: 100%; height: auto;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="delete_image" name="delete_image" value="1">
                        <label class="form-check-label" for="delete_image">Xóa hình ảnh hiện tại</label>
                    </div>
                <?php else: ?>
                    <p>Không có hình ảnh hiện tại.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh mới (Để trống để giữ hình ảnh hiện tại)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
        <a href="blog_management.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
