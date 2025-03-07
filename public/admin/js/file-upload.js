(function($) {
  'use strict';
  $(function() {
    $('.file-upload-browse').on('click', function() {
      var file = $(this).parent().parent().parent().find('.file-upload-default');
      file.trigger('click');
    });
    $('.file-upload-default').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
  });
})(jQuery);


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
        }
        reader.readAsDataURL(file);
      }
    });
  });
})(jQuery);