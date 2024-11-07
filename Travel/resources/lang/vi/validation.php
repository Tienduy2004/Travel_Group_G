<?php

return [
    'required' => 'Trường :attribute là bắt buộc.',
    'string' => 'Trường :attribute phải là một chuỗi.',
    'max' => [
        'string' => 'Trường :attribute không được vượt quá :max ký tự.',
    ],
    'integer' => 'Trường :attribute phải là một số nguyên.',
    'numeric' => 'Trường :attribute phải là một số.',
    'image' => 'Trường :attribute phải là một file hình ảnh.',
    'mimes' => 'Trường :attribute phải có định dạng: :values.',
    'mimetypes' => 'Trường :attribute phải có định dạng: :values.',
    
    // Thêm các thông báo lỗi khác
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'unique' => 'Trường :attribute đã tồn tại trong hệ thống.',
    'confirmed' => 'Xác nhận :attribute không khớp.',
    'date' => 'Trường :attribute không phải là ngày hợp lệ.',
    'before' => 'Trường :attribute phải là một ngày trước :date.',
    'after' => 'Trường :attribute phải là một ngày sau :date.',
    'exists' => 'Giá trị đã chọn cho :attribute không hợp lệ.',
    'url' => 'Trường :attribute phải là một URL hợp lệ.',
    'in' => 'Giá trị đã chọn cho :attribute không hợp lệ.',
    'size' => [
        'numeric' => 'Trường :attribute phải có kích thước :size.',
        'file' => 'Trường :attribute phải có kích thước :size kilobyte.',
        'string' => 'Trường :attribute phải có độ dài :size ký tự.',
    ],
    'min' => [
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
    ],
    'boolean' => 'Trường :attribute chỉ có thể là true hoặc false.',
    'file' => 'Trường :attribute phải là một tập tin hợp lệ.',
    'same' => 'Trường :attribute và :other phải giống nhau.',
    'timezone' => 'Trường :attribute phải là một múi giờ hợp lệ.',
];
