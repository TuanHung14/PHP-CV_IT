<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Thêm kỹ job mới</h4>
        <?php //inspectAndDie($errors) ?>
        <form class="forms-sample" action="/admin-panel/job/store" method="POST">
          <div class="form-group">
            <label for="exampleInputName1">Tên job</label>
            <input type="text" name="name" class="form-control" value="<?= isset($job['name']) ? $job['name'] : "" ?>" id="exampleInputName1" placeholder="Name">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="desc">Mô tả</label>
            <textarea name="description" style="height: 100px;" class="form-control" id="desc" placeholder="Description"><?= isset($job['description'])? $job['description'] : ""?></textarea>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['description']) ? $errors['description'] : "" ?></span>
          </div>
          <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

</div>