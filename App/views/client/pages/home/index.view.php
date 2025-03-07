<?= loadPartial($folder ,'search', $data)?>

<section class="company-option mt-4">
    <div class="container-xl">
        <h1 class="fs-3 text-center fw-bolder">Các nhà tuyển dụng</h1>
        <div class="row row-cols-6 mt-4">
            <?php foreach($companies as $row): ?>
                <div class="col">
                    <a href="/company/<?=  $row['id'] ?>"><img src="/images/company/<?= $row['thumbnail'] ?>" style="width: 160px; aspect-ratio: 1; overflow: hidden; " class="img-thumbnail rounded object-fit-cover" alt="logo <?= $row['name'] ?>"></a>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</section>
<section class="job-option mt-5">
    <div class="container">
        <h1 class="fs-3 text-center fw-bolder">Các công việc hiện có</h1>
        <div class="row row-cols-2 mt-4">
            <?php foreach($jobs as $row): ?>
            <div class="col">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <a href="/job/<?=  $row['id'] ?>"><img src="/images/company/<?= $row['company_thumbnail'] ?>" style="height: 200px;" class="img-fluid rounded-start object-fit-cover" alt="..."></a>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <a href="/job/<?=  $row['id'] ?>" class="card-title text-decoration-none"><h5 class="card-title"><?= $row['name'] ?></h5></a>
                                <p class="card-title">Lĩnh vực: <span class="text-body-secondary"><?= $row['job_name'] ?></span></p>
                                <p class="card-title">Số lượng: <span class="text-body-secondary"><?= $row['quantity'] ?></span></p>
                                <p class="card-title">Mức lương: <span class="text-body-secondary"><?= formatSalary($row['salary']) ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <div class="d-grid col-2 mx-auto mt-3">
            <a href="/jobs" class="btn btn-info">Xem thêm công việc</a>
        </div>
    </div>
</section>