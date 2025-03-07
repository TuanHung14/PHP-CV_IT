<div class="container my-5">
    <div class="flex-grow-1 p-4">
        <div class="row">
            <?= loadPartial($folder, 'nav', $user); ?>
            <div class="col-md-9">
                <h2 class="mb-4">Resume đã ứng tuyển</h2>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Công ty</th>
                                <th>Vị trí</th>
                                <th>Ngày ứng tuyển</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resumes as $row) {
                            ?>
                                <tr>
                                    <td><?= $row['company_name'] ?></td>
                                    <td><?= $row['post_job_name'] ?></td>
                                    <td><?= $row['createdAt'] ?></td>
                                    <td><span class="badge bg-secondary"><?= $row['status'] ?></span></td>
                                    <td>
                                        <a target="_blank" href="/file/resume/<?=  $row['url'] ?>" class="btn btn-sm btn-primary">Xem hồ sơ</a>
                                    </td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if ($page == 1) { ?>
                            <li class="page-item disabled">
                                <button class="page-link" button-pagination="">
                                    << </button>
                            </li>
                        <?php } else { ?>
                            <li class="page-item"><button class="page-link" button-pagination="<?= $page - 1 ?>">
                                    << </button>
                            </li>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $count; $i++) {
                            if ($i == $page) { ?>
                                <li class="page-item active"><button class="page-link" button-pagination="<?= $i ?>"><?= $i ?></button></li>
                            <?php  } else {  ?>
                                <li class="page-item"><button class="page-link" button-pagination="<?= $i ?>"><?= $i ?></button></li>
                        <?php }
                        } ?>
                        <?php if ($page == $count) { ?>
                            <li class="page-item disabled"><button class="page-link" button-pagination="<?= $page + 1 ?>">>></button> </li>
                        <?php } else { ?>
                            <li class="page-item"><button class="page-link" button-pagination="<?= $page + 1 ?>">>></button></li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    //pagination
    let url = new URL(window.location.href);
    const buttonPagination = document.querySelectorAll("[button-pagination]");
    if (buttonPagination) {
        buttonPagination.forEach(button => {
            button.addEventListener('click', () => {
                const page = button.getAttribute('button-pagination');
                if (page) {
                    url.searchParams.set('page', page);
                    window.location.href = url.href;
                }
            })
        })
    }
    //end pagination
</script>