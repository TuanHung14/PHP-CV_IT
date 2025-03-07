<div class="container mt-4">
    <!-- Job Header -->
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title"><?= $job['name'] ?></h1>
                    <p class="card-text">Lĩnh vực: <?= $job['job_name'] ?></p>
                    <p class="card-text">Số lượng: <?= $job['quantity'] ?></p>
                    <p class="card-text">Trình độ: <?= $job['level'] ?></p>
                    <p class="card-text">Mức lương: <?= formatSalary($job['salary']) ?>/tháng</p>
                    <div class="d-flex align-items-center gap-3">

                        <p class="card-text" style="padding-top: 16px;">Kỹ năng</p>

                        <?php foreach ($job['skills_name'] as $row): ?>
                            <button type="button" style="cursor: default;" class="btn btn-outline-info"><?= $row ?></button>
                        <?php endforeach; ?>

                    </div>
                    <button class="btn btn-danger mt-3 w-100">Ứng tuyển</button>
                </div>
            </div>
            <!-- Job Details -->
            <div class="card">
                <div class="card-body">
                    <?= $job['description'] ?>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="applyModalLabel">Ứng tuyển</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form ứng tuyển -->
                        <form action="/resume" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="<?= isset($user['id']) ? $user['id'] : '' ?>">
                            <input type="hidden" name="job_id" value="<?= isset($job['id']) ? $job['id'] : '' ?>">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Họ và tên</label>
                                <input type="text" disabled value="<?= isset($user['name']) ? $user['name'] : '' ?>" class="form-control" id="fullName" name="fullName">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" disabled value="<?= isset($user['email']) ? $user['email'] : '' ?>" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="resume" class="form-label">Upload CV</label>
                                <input type="file" class="form-control" id="resume" name="resume">
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đơn ứng tuyển</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="text-center">
                        <a href="/company/<?= $company['id'] ?>"> <img src="/images/company/<?= $company['thumbnail'] ?>" alt="Logo" style="width: 120px; aspect-ratio: 1; overflow: hidden; " class="img-thumbnail rounded object-fit-cover mb-3"></a>
                        <h5 class="card-title fw-bold"><?= $company['name'] ?></h5>
                        <a href="/company/<?= $company['id'] ?>" class="text-primary text-decoration-none">Xem công ty</a>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <strong>Địa chỉ công ty:</strong>
                        <span class="d-block"><?= $company['address'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.querySelector('.btn-danger').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('applyModal'), {
            keyboard: false
        });
        myModal.show();
    });
</script>