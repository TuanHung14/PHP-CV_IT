# Project Name

## Cài đặt

1. Clone repository:
    ```sh
    git clone https://github.com/TuanHung14/PHP-CV_IT.git
    cd PHP-CV_IT
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

5. Tạo database và import file SQL:
    - Tạo một database mới trong MySQL.
    - Import file `database.sql` vào database vừa tạo.

6. Khởi động server:
    ```sh
    php -S localhost:8000 -t public
    ```

7. Truy cập ứng dụng tại `http://localhost:8000`.

Tài khoản: vhung5912@gmail.com
Password:123456
