$(document).ready(function () {
    // Like button handling
    $("#like-button").on("click", function () {
        var postId = $(this).data("post-id");
        var csrfToken = $(this).data("csrf-token");

        $.ajax({
            url: "/blog/" + postId + "/toggle-like",
            type: "POST",
            data: {
                _token: csrfToken,
            },
            success: function (response) {
                $("#like-count").text(response.like_count);

                if (response.liked) {
                    $("#like-button").addClass("liked");
                } else {
                    $("#like-button").removeClass("liked");
                }
            },
            error: function (xhr) {
                if (xhr.status === 403) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text:
                            xhr.responseJSON.message ||
                            "You need to login to like.",
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "An error occurred while performing the like action.",
                    });
                }
            },
        });
    });
    $(document).ready(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        // Giữ màu vàng cho sao đã chọn khi tải lại trang
        $(".star.rated").css("color", "#ffcc00");

        // Hover Effect khi di chuột lên sao
        $(".star").on("mouseenter", function () {
            var rating = $(this).data("value");
            $(".star").each(function () {
                if ($(this).data("value") <= rating) {
                    $(this).css("color", "#ffcc00");
                } else {
                    $(this).css("color", "#ccc");
                }
            });
        });

        // Khi người dùng click vào sao để chọn rating
        $(".star").on("click", function () {
            var rating = $(this).data("value");
            var postId = $(this).data("post-id");

            $.ajax({
                url: "/blog/" + postId + "/rating",
                method: "POST",
                data: {
                    _token: csrfToken,
                    rating: rating,
                },
                success: function (response) {
                    // Cập nhật lại điểm trung bình
                    $("#average-rating").text(response.averageRating);

                    // Xóa class "rated" khỏi tất cả sao
                    $(".star").removeClass("rated");

                    // Đánh dấu sao đã chọn và giữ màu vàng
                    $(".star").each(function () {
                        if ($(this).data("value") <= rating) {
                            $(this).addClass("rated");
                        }
                    });

                    // Giữ màu vàng cho sao đã chọn
                    $(".star.rated").css("color", "#ffcc00");
                },
                error: function () {
                    alert("Có lỗi xảy ra. Vui lòng thử lại.");
                },
            });
        });

        // Khi người dùng rời chuột khỏi sao
        $(".star").on("mouseleave", function () {
            // Giữ màu vàng cho sao đã chọn, những sao chưa chọn sẽ có màu xám
            $(".star").each(function () {
                if ($(this).hasClass("rated")) {
                    $(this).css("color", "#ffcc00");
                } else {
                    $(this).css("color", "#ccc");
                }
            });
        });
    });

    // Comment handling
    $("#comment-form").on("submit", function (e) {
        e.preventDefault();
        const textarea = $("#message");
        const commentContent = textarea.val().trim();
        const postId = $(this).data("post-id");

        if (commentContent) {
            $.ajax({
                url: `/posts/${postId}/comment`,
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    message: commentContent,
                },
                success: function (data) {
                    const newComment = createCommentElement(data);
                    $("#comment-list").prepend(newComment);
                    textarea.val("");
                },
                error: function (xhr) {
                    if (xhr.status === 403) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text:
                                xhr.responseJSON.message ||
                                "You need to login to comment.",
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "An error occurred while posting the comment.",
                        });
                    }
                },
            });
        }
    });

    //form reply
    $("#comment-list").on("click", ".reply-btn", function () {
        const replyForm = $(this).next(".reply-form");
        replyForm.toggleClass("hidden");

        if (!replyForm.hasClass("hidden")) {
            replyForm.find("textarea").focus();
        }
    });

    // Submit reply
    $("#comment-list").on("click", ".submit-reply", function () {
        const replyForm = $(this).closest(".reply-form");
        const textarea = replyForm.find("textarea");
        const replyContent = textarea.val().trim();
        const commentId = $(this)
            .closest("[data-comment-id]")
            .data("comment-id");

        if (replyContent) {
            $.ajax({
                url: `/comments/${commentId}/reply`,
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    message: replyContent,
                },
                success: function (data) {
                    const newReply = createReplyElement(data);
                    replyForm.next(".replies").append(newReply);
                    textarea.val("");
                    replyForm.addClass("hidden");
                },
                error: function (xhr) {
                    if (xhr.status === 403) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text:
                                xhr.responseJSON.message ||
                                "You need to login to reply.",
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "An error occurred while posting the reply.",
                        });
                    }
                },
            });
        }
    });

    //comment
    function createCommentElement(data) {
        return `
            <div class="flex space-x-4" data-comment-id="${data.id}">
                <div class="flex-shrink-0">
                    <img src="${data.avatar}" alt="User Avatar" class="w-12 h-12 rounded-full">
                </div>
                <div class="flex-grow">
                    <div class="flex items-center mb-1 justify-between">
                        <div>
                            <h6 class="font-semibold mr-2">${data.user.name}</h6>
                            <small class="text-gray-500">${data.created_at}</small>
                        </div>
                        <!-- Nút menu 3 chấm -->
                        <div class="relative">
                            <button class="menu-button text-gray-500 focus:outline-none" onclick="toggleMenu(this)">
                                &#8226;&#8226;&#8226;
                            </button>
                            <!-- Menu chỉnh sửa và xóa -->
                            <div class="menu hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 update-comment" onclick="editComment(this, '{{ $comment->id }}')">Sửa</a>
                                <a class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 delete-comment">Xóa</a>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-3">${data.content}</p>
                    <button class="reply-btn px-3 py-1 text-sm border border-indigo-500 text-indigo-500 font-semibold rounded-md hover:bg-indigo-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Reply
                    </button>
                    <div class="reply-form hidden mt-4">
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" rows="3" placeholder="Write your reply..."></textarea>
                        <button class="submit-reply mt-2 px-3 py-1 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Submit Reply
                        </button>
                    </div>
                    <div class="replies mt-4 ml-6 space-y-4"></div>
                </div>
            </div>
        `;
    }

    //reply
    function createReplyElement(data) {
        return `
            <div class="flex space-x-4" data-reply-id="${data.id}">
                <div class="flex-shrink-0">
                    <img src="${data.avatar}" alt="User Avatar" class="w-12 h-12 rounded-full">
                </div>
                <div class="flex-grow">
                    <div class="flex items-center mb-1 justify-between">
                        <div>
                            <h6 class="font-semibold mr-2">${data.user.name}</h6>
                            <small class="text-gray-500">${data.created_at}</small>
                        </div>
                        <div class="relative">
                            <button class="menu-button text-gray-500 focus:outline-none"
                                onclick="toggleMenu(this)">
                                &#8226;&#8226;&#8226;
                            </button>
                            <!-- Menu chỉnh sửa và xóa -->
                            <div
                                class="menu hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                                <a
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 update-reply" onclick="editReply(this, '{{ $reply->id }}')">Sửa</a>
                                <a
                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 delete-reply">Xóa</a>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-3">${data.content}</p>
                </div>
            </div>
        `;
    }
});

//menu comment
function toggleMenu(button) {
    const menu = button.nextElementSibling;
    menu.classList.toggle("hidden");
}

// Đóng menu khi nhấn ngoài
document.addEventListener("click", function (event) {
    const menus = document.querySelectorAll(".menu");
    menus.forEach((menu) => {
        if (
            !menu.contains(event.target) &&
            !menu.previousElementSibling.contains(event.target)
        ) {
            menu.classList.add("hidden");
        }
    });
});

function editReply(element, replyId) {
    const replyElement = $(element)
        .closest(".flex.space-x-4")
        .find(".flex-grow");
    const content = replyElement.find("p").text().trim();

    replyElement.html(updateFormReply(replyId, content));
}
function editComment(element, commentId) {
    const commentElement = $(element)
        .closest(".flex.space-x-4")
        .find(".flex-grow");
    const content = commentElement.find("p").text().trim();

    commentElement.html(updateFormComment(commentId, content));
}

//xu ly update reply
$("#comment-list").on("click", ".update-reply", function () {
    const replyId = $(this).data("reply-id");
    const replyElement = $(this).closest(".flex-grow");
    const newContent = replyElement.find("textarea").val();

    if (newContent.length > 1000) {
        Swal.fire(
            "Too long!",
            "Content must not exceed 1000 characters.",
            "warning"
        );
        return;
    }

    $.ajax({
        url: `/comments/reply/${replyId}`,
        type: "PUT",
        data: {
            content: newContent,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            replyElement.html(`
                <div class="flex items-center mb-1 justify-between">
                    <div>
                        <h6 class="font-semibold mr-2">${data.user.name}</h6>
                        <small class="text-gray-500">${data.created_at}</small>
                    </div>
                    <div class="relative">
                        <button class="menu-button text-gray-500 focus:outline-none" onclick="toggleMenu(this)">
                            &#8226;&#8226;&#8226;
                        </button>
                        <div class="menu hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 edit-reply" onclick="editReply(this, ${replyId})">Sửa</a>
                            <a class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 delete-reply">Xóa</a>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-3">${newContent}</p>
            `);
            Swal.fire("Updated!.", data.message, "success");
        },
        error: function () {
            Swal.fire(
                "Error!",
                "An error occurred while updating the reply.",
                "error"
            );
        },
    });
});
$("#comment-list").on("click", ".update-comment", function () {
    const commentId = $(this).data("comment-id");
    const commentElement = $(this).closest(".flex-grow");
    const newContent = commentElement.find("textarea").val();

    if (newContent.length > 1000) {
        Swal.fire(
            "Too long!",
            "Content must not exceed 1000 characters.",
            "warning"
        );
        return;
    }
    $.ajax({
        url: `/comments/${commentId}`,
        type: "PUT",
        data: {
            content: newContent,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            commentElement.html(`
                <div class="flex items-center mb-1 justify-between">
                    <div>
                        <h6 class="font-semibold mr-2">${data.user.name}</h6>
                        <small class="text-gray-500">${data.created_at}</small>
                    </div>
                    <div class="relative">
                        <button class="menu-button text-gray-500 focus:outline-none" onclick="toggleMenu(this)">
                            &#8226;&#8226;&#8226;
                        </button>
                        <div class="menu hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 edit-comment" onclick="editComment(this, ${commentId})">Sửa</a>
                            <a class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 delete-comment">Xóa</a>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-3">${newContent}</p>
                <button
                    class="reply-btn px-3 py-1 text-sm border border-indigo-500 text-indigo-500 font-semibold rounded-md hover:bg-indigo-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Reply
                </button>
                <div class="reply-form hidden mt-4">
                    <textarea
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        rows="3" placeholder="Write your reply..."></textarea>
                    <button
                        class="submit-reply mt-2 px-3 py-1 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit Reply
                    </button>
                </div>
            `);
            Swal.fire("Updated!", data.message, "success");
        },
        error: function () {
            Swal.fire(
                "Error!",
                "An error occurred while updating the comment.",
                "error"
            );
        },
    });
});

function updateFormReply(commentId, currentContent) {
    return `
        <textarea maxlength="1000" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" rows="3">${currentContent}</textarea>
        <button class="update-reply mt-2 px-3 py-1 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" data-reply-id="${commentId}">
            Update
        </button>
        <button class="cancel-edit mt-2 px-3 py-1 text-red-600 font-semibold rounded-md hover:bg-red-500 hover:text-white">
            Cancel
        </button>
    `;
}
function updateFormComment(commentId, currentContent) {
    return `
        <textarea maxlength="1000" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" rows="3">${currentContent}</textarea>
        <button class="update-comment mt-2 px-3 py-1 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" data-comment-id="${commentId}">
            Update
        </button>
        <button class="cancel-edit mt-2 px-3 py-1 text-red-600 font-semibold rounded-md hover:bg-red-500 hover:text-white">
            Cancel
        </button>
    `;
}

//Xoa comment
$("#comment-list").on("click", ".delete-comment", function () {
    const commentId = $(this).closest("[data-comment-id]").data("comment-id");
    console.log("ID: ", commentId);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to delete this comment?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/comments/${commentId}`,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    // Cập nhật giao diện sau khi xóa
                    $(`[data-comment-id="${commentId}"]`).remove();
                    Swal.fire("Deleted!", response.message, "success");
                },
                error: function () {
                    Swal.fire(
                        "Error!",
                        "An error occurred while deleting the comment.",
                        "error"
                    );
                },
            });
        }
    });
});
//Xoa reply
$("#comment-list").on("click", ".delete-reply", function () {
    const replyId = $(this).closest("[data-reply-id]").data("reply-id");
    console.log("ID: ", replyId);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to delete this reply?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/comments/reply/${replyId}`,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    // Cập nhật giao diện sau khi xóa
                    $(`[data-reply-id="${replyId}"]`).remove();
                    Swal.fire("Deleted!", response.message, "success");
                },
                error: function () {
                    Swal.fire(
                        "Error!",
                        "An error occurred while deleting the comment.",
                        "error"
                    );
                },
            });
        }
    });
});

$("textarea").on("input", function () {
    const maxChars = 1000;
    const currentLength = $(this).val().length;

    if (currentLength > maxChars) {
        Swal.fire(
            "Notification",
            "You can enter up to 1000 characters.",
            "warning"
        );
        $(this).val($(this).val().substring(0, maxChars));
    }
});

function confirmDelete(postId) {
    Swal.fire({
        title: "Are you sure you want to delete?",
        text: "You will not be able to restore this post!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete now!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Gửi form xóa bài viết
            document.getElementById("delete-post-" + postId).submit();
        }
    });
}
