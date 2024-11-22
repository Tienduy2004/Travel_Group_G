$(document).ready(function () {
    // Initialize Summernote
    $("#content").summernote({
        height: 300,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline", "clear"]],
            ["color", ["color"]], // Thanh công cụ màu
            ["para", ["ul", "ol", "paragraph"]],
            ["table", ["table"]],
            ["insert", ["link", "picture", "video"]],
            ["view", ["fullscreen", "codeview", "help"]],
        ],
    });

    // Handle image preview
    $("#featuredImage").change(function (e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").html(
                    '<img src="' +
                        e.target.result +
                        '" class="img-fluid" alt="Featured Image Preview">'
                );
            };
            reader.readAsDataURL(file);
        }
    });

    // // Handle form submission
    // $("#blogForm").submit(function (e) {
    //     e.preventDefault();
    //     var title = $("#title").val();
    //     var category = $("#category").val();
    //     var content = $("#content").summernote("code");
    //     var featuredImage = $("#featuredImage")[0].files[0];

    //     // Here you would typically send this data to your server
    //     console.log("Title:", title);
    //     console.log("Category:", category);
    //     console.log("Content:", content);
    //     console.log("Featured Image:", featuredImage);

    //     alert("Blog post submitted successfully!");
    // });
});
$(document).ready(function () {
    // Giới hạn ký tự cho Title
    const maxTitleChars = 255;
    $("#title").on("input", function () {
        const $this = $(this);
        const currentLength = $this.val().length;

        if (currentLength > maxTitleChars) {
            Swal.fire(
                "Notification",
                `You can enter up to ${maxTitleChars} characters.`,
                "warning"
            );
            $this.val($this.val().substring(0, maxTitleChars));
        }
    });

    const maxContentChars = 1000;
    $('#content').summernote({
        height: 300, // Chiều cao của editor
        callbacks: {
            onChange: function (contents, $editable) {
                const textLength = contents.replace(/<[^>]*>/g, "").length; // Loại bỏ thẻ HTML để tính ký tự

                if (textLength > maxContentChars) {
                    const truncatedText = contents
                        .replace(/<[^>]*>/g, "") // Loại bỏ thẻ HTML
                        .substring(0, maxContentChars); // Cắt chuỗi thừa

                    const newContent = $('<div>').text(truncatedText).html();
                    $('#content').summernote('code', newContent); 
                }
            }
        }
    });
});
