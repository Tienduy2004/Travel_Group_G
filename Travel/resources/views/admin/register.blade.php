<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Admin</title>
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
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        /* Form styling */
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center; /* Center text in the form */
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-top: 15px;
            text-align: left; /* Align labels to the left */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        /* Error message styling */
        .error {
            margin-top: 20px;
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
        }

        p {
            margin: 5px 0;
        }

        /* Success message styling */
        .success {
            color: green;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="POST" action="{{ route('admin.register.submit') }}">
        @csrf
        <h2>Đăng ký tài khoản Admin</h2>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <label for="name">Tên:</label>
        <input type="text" name="name" required value="{{ old('name') }}">

        <label for="email">Email:</label>
        <input type="email" name="email" required value="{{ old('email') }}">

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Xác nhận mật khẩu:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Đăng ký</button>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </form>
</body>
</html>
