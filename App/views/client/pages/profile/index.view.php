<div class="container my-5">
    <!-- Main Content Area -->
    <div class="flex-grow-1 p-4">
        <div class="row">
            <?= loadPartial($folder, 'nav', $user); ?>
            <div class="col-md-9">
                <div class="card">
                    
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Thông tin cá nhân</h4>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-sm-9 d-flex justify-content-between align-items-center">
                                    <span class="editable-text"><?= $user['email'] ?></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Name:</strong>
                                </div>
                                <div class="col-sm-9 d-flex justify-content-between align-items-center">
                                    <div class="editable-container w-100">
                                        <span class="editable-text"><?= $user['name'] ?></span>
                                        <span class="text-danger" style="font-size: 12px;"><?= isset($errors['name']) ? $errors['name'] : "" ?></span>
                                        <div class="edit-form d-none">
                                            <form action="/profile" method="POST">
                                                <div class="input-group">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>">
                                                    <button class="btn btn-success save-btn">✓</button>
                                                    <button type="button" class="btn btn-danger cancel-btn">✕</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <button class="btn btn-link text-dark p-0 edit-btn" data-field="name">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                   
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Giới thiệu</h4>
                        </div>
                        <hr>
                        <div class="editable-container w-100">
                            <div class="editable-text">
                                <p>CV IT giúp bạn tạo CV ấn tượng, chuyên nghiệp và tối ưu cho ngành công nghệ thông tin.
                                    Với các mẫu thiết kế hiện đại, dễ chỉnh sửa và phù hợp với nhiều vị trí IT,
                                    bạn có thể nhanh chóng xây dựng hồ sơ nổi bật để thu hút nhà tuyển dụng.
                                    Bắt đầu ngay và đưa sự nghiệp IT của bạn lên một tầm cao mới! 🚀</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy tất cả các nút chỉnh sửa
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Tìm container chứa nội dung có thể chỉnh sửa
                const container = this.closest('.d-flex').querySelector('.editable-container');
                const textElement = container.querySelector('.editable-text');
                const formElement = container.querySelector('.edit-form');

                // Hiển thị form và ẩn text
                textElement.classList.add('d-none');
                formElement.classList.remove('d-none');

                // Focus vào input
                const input = formElement.querySelector('input, textarea');
                input.focus();

                // Xử lý nút Save
                const saveBtn = formElement.querySelector('.save-btn');
                saveBtn.addEventListener('click', function() {
                    const newValue = input.value;
                    const text = textElement.tagName.toLowerCase() === 'div' ?
                        textElement.querySelector('p') :
                        textElement;
                    text.textContent = newValue;

                    // Ẩn form và hiện text
                    textElement.classList.remove('d-none');
                    formElement.classList.add('d-none');

                    const fieldName = button.dataset.field;
                    console.log('Saving', fieldName, ':', newValue);
                });

                // Xử lý nút Cancel
                const cancelBtn = formElement.querySelector('.cancel-btn');
                cancelBtn.addEventListener('click', function() {
                    // Ẩn form và hiện text
                    textElement.classList.remove('d-none');
                    formElement.classList.add('d-none');
                });
            });
        });
    });
</script>