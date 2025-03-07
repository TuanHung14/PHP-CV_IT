<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Thêm công ty mới</h4>
        <?php //inspectAndDie($errors) ?>
        <form class="forms-sample" action="/admin-panel/company/update/<?= $company['id'] ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
          <div class="form-group text-center">
            <input type="file" name="thumbnail" class="file-upload-default" style="display: none;">
            <div class="image-upload-wrapper">
              <img src="/images/company/<?= $company['thumbnail'] ?>" alt="Upload Image" class="image-preview rounded-circle">
            </div>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['thumbnail']) ? $errors['thumbnail'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleInputName1">Tên công ty</label>
            <input type="text" value="<?= $company['name'] ?>" name="name" class="form-control" id="exampleInputName1" placeholder="Name">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3">Địa chỉ</label>
            <input type="text" value="<?= $company['address'] ?>" name="address" class="form-control" id="exampleInputEmail3" placeholder="text">
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['address']) ? $errors['address'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="exampleSelectLevel">Thành Phố</label>
            <input type="hidden" id="location" name="location" value="<?= isset($company['location']) ? $company['location'] : "" ?>">
            <select class="form-select" name="location" id="exampleSelectLevel">
              <option value="">Thuộc Thành Phố...</option>
            </select>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['location']) ? $errors['location'] : "" ?></span>
          </div>
          <div class="form-group">
            <label for="summernote">Nội dung</label>
            <textarea class="form-control" name="description" id="summernote"><?= $company['description'] ?></textarea>
            <span class="text-danger" style="font-size: 12px;"><?= isset($errors['description']) ? $errors['description'] : "" ?></span>
          </div>
          <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  (function($) {
    'use strict';
    $(function() {
      // Khi bấm vào hình tròn
      $('.image-upload-wrapper').on('click', function() {
        $(this).closest('.form-group').find('.file-upload-default').trigger('click');
      });
  
      // Hiển thị ảnh đã chọn
      $('.file-upload-default').on('change', function(event) {
        var file = event.target.files[0];
        if (file) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('.image-preview').attr('src', e.target.result);

            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            $('.file-upload-default')[0].files = dataTransfer.files;
          }
          reader.readAsDataURL(file);
        }
      });
    });
  })(jQuery);

  $(document).ready(function() {
    $('#summernote').summernote({
      height: 400,
      lang: 'vi-VN',
      fontNames: ['Roboto', 'Arial', 'Open Sans', 'Tahoma'],
      fontNamesIgnoreCheck: ['Roboto', 'Arial', 'Open Sans', 'Tahoma'],
      charset: 'UTF-8',
      placeholder: 'Nhập nội dung công ty',
      tabsize: 2
    });
  });
  const cities = [{
      name: "Hà Nội"
    },
    {
      name: "TP. Hồ Chí Minh"
    },
    {
      name: "Đà Nẵng"
    },
    {
      name: "Cần Thơ"
    },
    {
      name: "Hải Phòng"
    }
  ];

  

  document.addEventListener("DOMContentLoaded", function() {
    const location = document.querySelector('input[name="location"]');
    const citySelect = document.getElementById("exampleSelectLevel");
    // Duyệt mảng và thêm option vào select
    cities.forEach(city => {
      let option = document.createElement("option");
      option.value = city.name;
      option.textContent = city.name;
      citySelect.appendChild(option);
      // Nếu giá trị input đã chọn đã tồn tại trong mảng, thì set selected cho option đó
      if (location.value === city.name) {
        option.selected = true;
      }
    });
  });
</script>