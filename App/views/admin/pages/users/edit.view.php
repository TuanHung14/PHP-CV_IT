<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <form class="forms-sample" action="/admin-panel/user/update/<?= $user['id'] ?>" method="POST">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title">Update User</h4>
            <div role="select">
                <select class="form-select" style="color: #FFF  !important ;" name="role_id" id="exampleSelectLevel">
                  <?php foreach($roles as $role): ?>
                    <option  value="<?php echo $role['id'];?>" <?php echo $user['role_id'] == $role['id']?'selected' : '';?>><?php echo $role['name'];?></option>
                  <?php endforeach;?>
                </select>
            </div>
          </div>
          
          <div>
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
              <label for="exampleInputName1">Email</label>
              <input type="text" name="email" style="pointer-events: none; opacity: 0.5;" class="form-control" value="<?= $user['email'] ?>" id="exampleInputName1" placeholder="email">
            </div>
            <div class="form-group">
              <label for="exampleInputName1">Tên người dùng</label>
              <input type="text" name="name" style="pointer-events: none; opacity: 0.5;" class="form-control" value="<?= $user['name'] ?>" id="exampleInputName1" placeholder="Name">
            </div>
            <div class="form-group">
              <label for="exampleSelectLevel">Công ty</label>
              <select class="form-select" style="color: #FFF  !important ;" name="company_id" id="exampleSelectLevel">
                <option value="">Thuộc công ty...</option>
                <?php foreach($companies as $row): ?>
                <option <?php if(isset($user['company_id']) && $user['company_id'] == $row['id']) echo"selected" ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php  endforeach;?>
              </select>
              <span class="text-danger" style="font-size: 12px;"><?= isset($errors['company_id']) ? $errors['company_id'] : "" ?></span>
            </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>