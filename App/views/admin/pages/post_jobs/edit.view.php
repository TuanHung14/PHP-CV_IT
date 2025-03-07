<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Thêm công việc mới</h4>
        <form class="forms-sample" action="/admin-panel/post_job/update/<?= $job['id'] ?>"  method="POST">
          <input type="hidden" name="_method" value="PUT">
          <div class="form-group">
            <label for="exampleInputName1">Tên công việc</label>
            <input type="text" name="name" class="form-control" value="<?= isset($job['name']) ? $job['name'] : "" ?>" id="exampleInputName1" placeholder="Name">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3">Số lượng</label>
            <input type="number" name="quantity" class="form-control" value="<?= isset($job['quantity']) ? $job['quantity'] : "" ?>" id="exampleInputEmail3" placeholder="Số lượng">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['quantity']) ? $errors['quantity'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3">Nhập lương yêu cầu</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white">$</span>
              </div>
              <input type="number" value="<?= isset($job['salary']) ? $job['salary'] : "" ?>" name="salary" min="0" class="form-control" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-append">
                <span class="input-group-text">VNĐ</span>
              </div>
            </div>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['salary']) ? $errors['quantity'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleSelectLevel">Thuộc job: </label>
            <select class="form-select" name="job_id" id="exampleSelectLevel">
              <?php
                foreach ($jobs as $row):
              ?>
              <option <?php if(isset($job['job_id']) && $job['job_id'] == $row['id']) echo"selected" ?> value="<?= $row['id']?>"><?= $row['name']?></option>
              <?php endforeach; ?>
            </select>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['level']) ? $errors['level'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleSelectLevel">Trình độ</label>
            <select class="form-select" name="level" id="exampleSelectLevel">
              <?php
                foreach ($levels as $level):
              ?>
              <option <?php if($level['active']) echo "selected" ?> value="<?= $level['value']?>"><?= $level['name']?></option>
              <?php endforeach; ?>
            </select>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['level']) ? $errors['level'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleSelectLevel">Công ty</label>
            <select class="form-select" name="company_id" id="exampleSelectLevel">
              <option value="">Thuộc công ty...</option>
              <?php foreach($company as $row): ?>
              <option <?php if(isset($job['company_id']) && $job['company_id'] == $row['id']) echo"selected" ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
              <?php  endforeach;?>
            </select>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['company_id']) ? $errors['company_id'] : "" ?></span>
          </div>
          <div class="form-group">
            <label>Chọn kỹ năng bạn cần</label>
            <div class="select-container">
              <div class="selected-tags" id="selectedTags"></div>
              <select class="select-options" name="skills[]" multiple id="selectOptions">
                <?php isset($job['skills']) ?>
                <?php foreach ($skills as $row): ?>
                  <option class="option" <?= isset($job['skills']) && in_array($row['id'], $job['skills']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['skills']) ? $errors['skills'] : "" ?></span>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col">
                <label for="startDate" class="form-label">Ngày bắt đầu</label>
                <div class="input-group">
                  <input type="date" value="<?= isset($job['startDate']) ? $job['startDate'] : "" ?>" class="form-control datepicker" id="startDate" name="startDate" placeholder="DD/MM/YYYY">
                </div>
                <span class="text-danger" style="font-size: 12px;"><?= isset($errors['startDate']) ? $errors['startDate'] : "" ?></span>
              </div>
              <div class="col">
                <label for="endDate" class="form-label">Ngày kết thúc</label>
                <div class="input-group">
                  <input type="date" value="<?= isset($job['endDate']) ? $job['endDate'] : "" ?>" class="form-control datepicker" id="endDate" name="endDate" placeholder="DD/MM/YYYY">
                </div>
                <span class="text-danger" style="font-size: 12px;"><?= isset($errors['endDate']) ? $errors['endDate'] : "" ?></span>
              </div>
            </div>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['date']) ? $errors['date'] : "" ?></span>
          </div>
          
          <div class="form-group">
            <label for="summernote">Nội dung</label>
            <textarea class="form-control" name="description" id="summernote"><?= isset($job['description']) ? $job['description'] : "" ?></textarea>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['description']) ? $errors['description'] : "" ?></span>
          </div>
          <div class="form-group">
            <div class="form-check form-switch ms-4">
              <input class="form-check-input" name="active" type="checkbox" role="switch" id="flexSwitchCheckDefault">
              <label class="form-check-label d-inline-flex" for="flexSwitchCheckDefault">Đăng liền</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#summernote').summernote({
      height: 400,
      lang: 'vi-VN',
      fontNames: ['Roboto', 'Arial', 'Open Sans', 'Tahoma'],
      fontNamesIgnoreCheck: ['Roboto', 'Arial', 'Open Sans', 'Tahoma'],
      charset: 'UTF-8',
      placeholder: 'Nhập nội dung công ty',
      tabsize: 2,
    });

  });
  // xử lý skills chọn nhìu option
  document.addEventListener('DOMContentLoaded', function() {
    const selectedTags = document.getElementById('selectedTags');
    const selectOptions = document.getElementById('selectOptions');
    const tagColors = ['blue', 'green'];
    const selectedValues = new Set();

    // Hàm tạo tag
    function createTag(value, text, colorIndex) {
      const tag = document.createElement('span');
      tag.className = `tag ${tagColors[colorIndex % tagColors.length]}`;
      tag.innerHTML = `${text} <span class="remove" data-value="${value}">×</span>`;
      return tag;
    }

     // Khởi tạo tag từ option đã chọn
     Array.from(selectOptions.options).forEach((option, index) => {
      if (option.selected) {
        selectedValues.add(option.value);
        const tag = createTag(option.value, option.textContent, index);
        selectedTags.appendChild(tag);
        option.classList.add('selected');
      }
    });

    // Hàm đồng bộ các giá trị đã chọn với <select>
    function syncSelectValues() {
      // Loại bỏ trạng thái "selected" hiện tại
      Array.from(selectOptions.options).forEach(option => {
        option.selected = selectedValues.has(option.value);
      });
    }

    // Click vào selected-tags để show/hide options
    selectedTags.addEventListener('click', function(e) {
      if (!e.target.classList.contains('remove')) {
        selectOptions.classList.toggle('show');
      }
    });

    // Click ra ngoài để đóng options
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.select-container')) {
        selectOptions.classList.remove('show');
      }
    });

    // Xử lý click vào option
    selectOptions.addEventListener('click', function(e) {
      const option = e.target.closest('.option');
      if (!option) return;

      const value = option.value;
      const text = option.textContent;

      if (selectedValues.has(value)) {
        // Bỏ chọn
        selectedValues.delete(value);
        option.classList.remove('selected');
        const tag = selectedTags.querySelector(`[data-value="${value}"]`).parentElement;
        if (tag) tag.remove();
      } else {
        // Chọn mới
        selectedValues.add(value);
        option.classList.add('selected');
        const tag = createTag(value, text, selectedValues.size - 1);
        selectedTags.appendChild(tag);
      }

      // Đồng bộ lại các giá trị trong <select>
      syncSelectValues();
    });

    // Xử lý xóa tag
    selectedTags.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove')) {
        const value = e.target.dataset.value;
        selectedValues.delete(value);
        e.target.parentElement.remove();
        const option = selectOptions.querySelector(`[value="${value}"]`);
        if (option) option.classList.remove('selected');

        // Đồng bộ lại các giá trị trong <select>
        syncSelectValues();
      }
    });
  });
</script>