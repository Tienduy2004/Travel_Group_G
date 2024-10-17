<?php

return [
    'required' => ':attribute là bắt buộc.',
    'string' => ':attribute phải là chuỗi.',
    'max' => [
        'string' => ':attribute không được vượt quá :max ký tự.',
        'file' => ':attribute không được vượt quá :max kilobyte.',
    ],
    'email' => ':attribute phải là địa chỉ email hợp lệ.',
    'image' => ':attribute không hợp lệ.',
    'mimes' => ':attribute phải có định dạng: :values.',

    'attributes' => [
        'name' => 'tên tour',
        'location' => 'địa điểm',
        'time' => 'thời gian',
        'quantity' => 'số lượng',
        'rating' => 'đánh giá',
        'image' => 'hình ảnh',
    ],
];
