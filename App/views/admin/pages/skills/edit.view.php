<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Update kỹ năng</h4>
        <?php //inspectAndDie($errors) ?>
        <form class="forms-sample" action="/admin-panel/skill/update/<?= $skill['id'] ?>" method="POST">
          <input type="hidden" name="_method" value="PUT">
          <div class="form-group">
            <label for="exampleInputName1">Tên kỹ năng</label>
            <input type="text" name="name" class="form-control" value="<?= $skill['name'] ?>" id="exampleInputName1" placeholder="Name">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
          </div>
          <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

</div>