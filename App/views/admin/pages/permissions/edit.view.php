<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Update quyền mới</h4>
        <form class="forms-sample" action="/admin-panel/permission/update/<?= $permission['id'] ?>" method="POST">
          <input type="hidden" name="_method" value="PUT">
          <div class="form-group">
            <label for="name">Tên phân quyền</label>
            <input type="text" name="name" class="form-control" value="<?= isset($permission['name']) ? $permission['name'] : "" ?>" id="name" placeholder="Tên">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="description">Mô tả quyền</label>
            <textarea name="description" style="height: 100px;" class="form-control" id="description" placeholder="Mô tả"><?= isset($permission['description']) ? $permission['description'] : "" ?></textarea>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['description']) ? $errors['description'] : "" ?></span>
          </div>
          <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

</div>