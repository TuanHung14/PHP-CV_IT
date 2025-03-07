<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>error</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 1rem;
            line-height: 1;
        }

        .error-message {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .error-description {
            color: #7f8c8d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .home-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #2980b9;
        }

        @media (max-width: 480px) {
            .error-code {
                font-size: 80px;
            }
            
            .error-message {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code"><?= $status ?></div>
        <h1 class="error-message"><?= $message ?></h1>
        <p class="error-description">
            Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển đến một địa chỉ khác.
        </p>
        <a href="/" class="home-button">Trở về trang chủ</a>
    </div>
</body>
</html>