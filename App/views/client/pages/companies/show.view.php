<div class="container mt-4">
    <!-- Job Header -->
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <img src="/images/company/<?= $company['thumbnail'] ?>" style="width: 120px; aspect-ratio: 1; overflow: hidden; " alt="" class="img-fluid rounded-start object-fit-cover">
                        <div>
                            <h1 class="card-title"><?= $company['name'] ?></h1>
                            <h5 class="text-muted"><?= $company['address'] ?></h5>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Job Details -->
            <div class="card">
                <div class="card-body">
                    <?= $company['description'] ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">

            <!-- Job List -->
            <div class="">
                <!-- Job 1 -->
                <?php foreach($jobs as $row): ?>
                <div class="">
                    <div class="job-card">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Đăng 2 giờ trước</small>
                            <span class="badge-new">Công việc hiện có</span>
                        </div>
                       <a href="/job/<?= $row['id'] ?>" class=""> <h5 class="mt-2"><?= $row['name'] ?></h5></a>
                        <p class="text-muted">Số lượng: <?= $row['quantity'] ?></p>
                        <p class="text-muted">Mức lương: <?= formatSalary($row['salary']) ?></p>
                        <p><i class="bi bi-geo-alt"></i> <?= $row['level'] ?></p>
                        <div class="job-tags d-flex flex-wrap gap-2">
                            <?php foreach($row['skills_name'] as $skill): ?>
                                <button type="button" style="cursor: default;" class="btn btn-outline-info"><?= $skill ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>



            </div>
        </div>

    </div>
</div>