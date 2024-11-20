<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <style>
    /* Reset styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background: linear-gradient(135deg, #f0f2f5, #e0e7ff);
        font-family: 'Roboto', Arial, sans-serif;
    }

    /* Form styling */
    form {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    h2 {
        color: #333;
        margin-bottom: 25px;
        font-size: 1.5em;
    }

    label {
        font-weight: 600;
        color: #555;
        display: block;
        margin-top: 20px;
        text-align: left;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        background-color: #f9f9f9;
        transition: border-color 0.3s, background-color 0.3s;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #007bff;
        background-color: #fff;
        outline: none;
    }

    button[type="submit"] {
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    a {
        display: inline-block;
        margin-top: 15px;
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }

    a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Error message styling */
    div {
        margin-top: 20px;
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

   
</style>

</head>
<body>
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <h2>Đăng nhập vào trang quản lý</h2>
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required>

        <button type="submit">Đăng nhập</button>
        <a href="{{ route('admin.register') }}">đăng Ky</a>
    </form>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>
