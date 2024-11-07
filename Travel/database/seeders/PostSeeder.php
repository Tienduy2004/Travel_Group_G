<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Tạo dữ liệu mẫu cho bảng posts với chủ đề du lịch
        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Đà Nẵng',
            'content' => 'Đà Nẵng là một trong những thành phố du lịch nổi tiếng nhất Việt Nam với những bãi biển tuyệt đẹp và các danh lam thắng cảnh nổi bật.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 300,
            'like_count' => 300,
            'comment_count' => 300,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Trải Nghiệm Phú Quốc',
            'content' => 'Phú Quốc là một hòn đảo xinh đẹp với bãi biển trong xanh, cát trắng và nhiều hoạt động thú vị cho du khách.',
            'image_url' => 'blog-2.jpg',
            'view_count' => 450,
            'like_count' => 450,
            'comment_count' => 450,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 3, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Hà Nội',
            'content' => 'Hà Nội không chỉ nổi tiếng với văn hóa ẩm thực phong phú mà còn có nhiều di tích lịch sử thú vị.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 500,
            'like_count' => 500,
            'comment_count' => 500,
            'is_featured' => false,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 2, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Những Địa Điểm Không Thể Bỏ Qua Ở Nha Trang',
            'content' => 'Nha Trang là thiên đường du lịch với các bãi biển đẹp, các khu nghỉ dưỡng sang trọng và các hoạt động giải trí phong phú.',
            'image_url' => 'blog-3.jpg',
            'view_count' => 600,
            'like_count' => 600,
            'comment_count' => 600,
            'is_featured' => true,
            'status' => 'approved',
        ]);
        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Đà Nẵng',
            'content' => 'Đà Nẵng là một trong những thành phố du lịch nổi tiếng nhất Việt Nam với những bãi biển tuyệt đẹp và các danh lam thắng cảnh nổi bật.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 300,
            'like_count' => 300,
            'comment_count' => 300,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Trải Nghiệm Phú Quốc',
            'content' => 'Phú Quốc là một hòn đảo xinh đẹp với bãi biển trong xanh, cát trắng và nhiều hoạt động thú vị cho du khách.',
            'image_url' => 'blog-2.jpg',
            'view_count' => 450,
            'like_count' => 450,
            'comment_count' => 450,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 3, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Hà Nội',
            'content' => 'Hà Nội không chỉ nổi tiếng với văn hóa ẩm thực phong phú mà còn có nhiều di tích lịch sử thú vị.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 500,
            'like_count' => 500,
            'comment_count' => 500,
            'is_featured' => false,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 2, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Những Địa Điểm Không Thể Bỏ Qua Ở Nha Trang',
            'content' => 'Nha Trang là thiên đường du lịch với các bãi biển đẹp, các khu nghỉ dưỡng sang trọng và các hoạt động giải trí phong phú.',
            'image_url' => 'blog-3.jpg',
            'view_count' => 600,
            'like_count' => 600,
            'comment_count' => 600,
            'is_featured' => true,
            'status' => 'approved',
        ]);
        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Đà Nẵng',
            'content' => 'Đà Nẵng là một trong những thành phố du lịch nổi tiếng nhất Việt Nam với những bãi biển tuyệt đẹp và các danh lam thắng cảnh nổi bật.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 300,
            'like_count' => 300,
            'comment_count' => 300,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Trải Nghiệm Phú Quốc',
            'content' => 'Phú Quốc là một hòn đảo xinh đẹp với bãi biển trong xanh, cát trắng và nhiều hoạt động thú vị cho du khách.',
            'image_url' => 'blog-2.jpg',
            'view_count' => 450,
            'like_count' => 450,
            'comment_count' => 450,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 3, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Hà Nội',
            'content' => 'Hà Nội không chỉ nổi tiếng với văn hóa ẩm thực phong phú mà còn có nhiều di tích lịch sử thú vị.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 500,
            'like_count' => 500,
            'comment_count' => 500,
            'is_featured' => false,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 2, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Những Địa Điểm Không Thể Bỏ Qua Ở Nha Trang',
            'content' => 'Nha Trang là thiên đường du lịch với các bãi biển đẹp, các khu nghỉ dưỡng sang trọng và các hoạt động giải trí phong phú.',
            'image_url' => 'blog-3.jpg',
            'view_count' => 600,
            'like_count' => 600,
            'comment_count' => 600,
            'is_featured' => true,
            'status' => 'approved',
        ]);
        Post::create([
            'user_id' => 1,
            'category_id' => 2, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Đà Nẵng',
            'content' => 'Đà Nẵng là một trong những thành phố du lịch nổi tiếng nhất Việt Nam với những bãi biển tuyệt đẹp và các danh lam thắng cảnh nổi bật.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 300,
            'like_count' => 300,
            'comment_count' => 300,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Trải Nghiệm Phú Quốc',
            'content' => 'Phú Quốc là một hòn đảo xinh đẹp với bãi biển trong xanh, cát trắng và nhiều hoạt động thú vị cho du khách.',
            'image_url' => 'blog-2.jpg',
            'view_count' => 450,
            'like_count' => 450,
            'comment_count' => 450,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 3, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Hà Nội',
            'content' => 'Hà Nội không chỉ nổi tiếng với văn hóa ẩm thực phong phú mà còn có nhiều di tích lịch sử thú vị.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 500,
            'like_count' => 500,
            'comment_count' => 500,
            'is_featured' => false,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 2, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Những Địa Điểm Không Thể Bỏ Qua Ở Nha Trang',
            'content' => 'Nha Trang là thiên đường du lịch với các bãi biển đẹp, các khu nghỉ dưỡng sang trọng và các hoạt động giải trí phong phú.',
            'image_url' => 'blog-3.jpg',
            'view_count' => 600,
            'like_count' => 600,
            'comment_count' => 600,
            'is_featured' => true,
            'status' => 'approved',
        ]);
        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Đà Nẵng',
            'content' => 'Đà Nẵng là một trong những thành phố du lịch nổi tiếng nhất Việt Nam với những bãi biển tuyệt đẹp và các danh lam thắng cảnh nổi bật.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 300,
            'like_count' => 300,
            'comment_count' => 300,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 1, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Trải Nghiệm Phú Quốc',
            'content' => 'Phú Quốc là một hòn đảo xinh đẹp với bãi biển trong xanh, cát trắng và nhiều hoạt động thú vị cho du khách.',
            'image_url' => 'blog-2.jpg',
            'view_count' => 450,
            'like_count' => 450,
            'comment_count' => 450,
            'is_featured' => true,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 3, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Khám Phá Hà Nội',
            'content' => 'Hà Nội không chỉ nổi tiếng với văn hóa ẩm thực phong phú mà còn có nhiều di tích lịch sử thú vị.',
            'image_url' => 'blog-1.jpg',
            'view_count' => 500,
            'like_count' => 500,
            'comment_count' => 500,
            'is_featured' => false,
            'status' => 'approved',
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 2, // Giả sử ID 1 là danh mục "Travel"
            'title' => 'Những Địa Điểm Không Thể Bỏ Qua Ở Nha Trang',
            'content' => 'Nha Trang là thiên đường du lịch với các bãi biển đẹp, các khu nghỉ dưỡng sang trọng và các hoạt động giải trí phong phú.',
            'image_url' => 'blog-3.jpg',
            'view_count' => 600,
            'like_count' => 600,
            'comment_count' => 600,
            'is_featured' => true,
            'status' => 'approved',
        ]);
    }
}
