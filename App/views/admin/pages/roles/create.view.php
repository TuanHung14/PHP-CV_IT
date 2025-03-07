<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Thêm role mới</h4>
        <form class="forms-sample" action="/admin-panel/role/store" method="POST">
          <div class="form-group">
            <label for="name">Tên role</label>
            <input type="text" name="name" class="form-control" value="<?= isset($role['name']) ? $role['name'] : "" ?>" id="name" placeholder="Tên">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="description">Mô tả quyền</label>
            <textarea name="description" style="height: 100px;" class="form-control" id="description" placeholder="Mô tả"><?= isset($role['description']) ? $role['description'] : "" ?></textarea>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['description']) ? $errors['description'] : "" ?></span>
          </div>
          <div class="d-flex flex-wrap align-items-center gap-5">
            <?php foreach ($permissions as $key => $permission): ?>
              <div class="form-group">
                <label for="description"><?= strtoupper($key) ?>:</label>
                <?php foreach ($permission as  $row): ?>
                  <div class="form-check form-check-primary">
                    <label class="form-check-label">
                      <input type="checkbox" <?= isset($role['permission']) && in_array($row['id'], $role['permission']) ? 'checked' : '' ?> data-permission="<?= $row['id'] ?>" class="form-check-input"> <?= $row['name'] ?> </label>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </div>
          <input type="hidden" value='<?= isset($role['permission']) ? json_encode($role['permission']) : "" ?>' name="permissions">
          <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelectorAll('.form-check-input');
    let data = [];
    // Tạo input hidden
    const permissionsInput = document.querySelector('[name="permissions"]');
    const initialPermissions = permissionsInput.value ? JSON.parse(permissionsInput.value) : [];
    console.log(initialPermissions);
    data = [...initialPermissions]; // Khởi tạo data với giá trị ban đầu
    input.forEach(item => {
        item.addEventListener('change', function() {
        const permission = this.dataset.permission;
        if (item.checked) {
          if (!data.includes(permission)) {
            data.push(permission);
          }
        } else {
          data = data.filter(item => item != permission);
        }
        permissionsInput.value = JSON.stringify(data);
      });
    });
  });
</script>