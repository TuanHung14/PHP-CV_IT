

<!-- Registration Form Box -->
<form class="login-form mt-5" action="/auth/register" method="POST">
      <h3 class="text-center mb-4">Đăng ký</h3>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" value="<?= isset($user['email']) ? $user['email'] : "" ?>" name="email" class="form-control" id="email" placeholder="Nhập email của bạn">
        <span class="text-danger" style="font-size: 12px;"><?= isset($errors['email']) ? $errors['email'] : "" ?></span>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Họ và tên</label>
        <input type="text"  value="<?= isset($user['name']) ? $user['name'] : "" ?>" name="name" class="form-control" id="name" placeholder="Nhập tên của bạn">
        <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Nhập mật khẩu">
        <span class="text-danger" style="font-size: 12px;"><?= isset($errors['password']) ? $errors['password'] : "" ?></span>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Nhập lại mật khẩu</label>
        <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="Nhập mật khẩu">
        <span class="text-danger" style="font-size: 12px;"><?= isset($errors['passwordConfirmation']) ? $errors['passwordConfirmation'] : "" ?></span>
      </div>
      <button type="submit" class="btn btn-login w-100">Đăng Nhập</button>
      <div class="d-flex justify-content-between">
        <p class="text-center mt-3">
            <a href="#" class="text-decoration-none text-primary">Quên mật khẩu?</a>
        </p>
        <p class="text-center mt-3">
            <a href="/auth/login" class="text-decoration-none text-primary">Đăng nhập</a>
        </p>
      </div>
      
</form>