# Project Name

## Cài đặt

1. Clone repository:
    ```sh
    git clone <https://github.com/TuanHung14/PHP-CV_IT.git>
    cd <https://github.com/TuanHung14/PHP-CV_IT.git>
    ```

2. Cài đặt các phụ thuộc:
    ```sh
    composer install
    ```

3. Tạo các file cấu hình từ các file mẫu:
    ```sh
    cp config/db.example.php config/db.php
    cp config/jwt.example.php config/jwt.php
    ```

4. Cập nhật các file cấu hình với thông tin của bạn.

5. Khởi động server:
    ```sh
    php -S localhost:8000 -t public
    ```

6. Truy cập ứng dụng tại `http://localhost:8000`.