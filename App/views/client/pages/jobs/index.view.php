<div class="container mt-4">
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="" id="form-search" role="search">
                <div class="input-group">
                    <input type="text" name="keyword" value="<?= isset($keyword) ? $keyword : ""  ?>" class="form-control" placeholder="Tìm kiếm việc làm...">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection">
                <i class="fas fa-filter"></i> Bộ lọc
            </button>
        </div>
    </div>

    <!-- Filter Collapse Section -->
    <div class="collapse mb-4" id="filterSection">
        <form action="" id="form-filter">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Địa điểm</label>
                    <select name="address" class="form-select">
                        <option value="">Tất cả địa điểm</option>
                        <?php foreach ($locations as $row): ?>
                            <?php if($row == $location){ ?>
                                <option selected value="<?= $row?>"><?= $row?></option>
                            <?php } else {?>
                            <option value="<?= $row ?>"><?= $row ?></option>
                            <?php }?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ngành nghề</label>
                    <select name="suggestion" class="form-select">
                        <option value="">Tất cả ngành nghề</option>
                        <?php foreach ($jobsFilter as $row): ?>
                            <?php if($row['name'] == $suggestion){ ?>
                                <option selected value="<?= $row['name']?>"><?= $row['name']?></option>
                            <?php } else {?>
                            <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                            <?php }?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kỹ năng</label>
                    <select name="skills" class="form-select">
                        <option value="">Tất cả kỹ năng</option>
                        <?php foreach ($skills as $row): ?>
                            <?php if($row['name'] == $nameSkill){ ?>
                                <option selected value="<?= $row['name']?>"><?= $row['name']?></option>
                            <?php } else {?>
                            <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                            <?php }?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-primary">Lọc</button>
                <button class="btn btn-secondary" type="button" id="drop-filter">Xóa bộ lọc</button>
            </div>
        </div>
        </form>
    </div>

    <!-- Job Listings -->
    <div class="row">
        <!-- Job Card 1 -->
        <?php foreach ($jobs as $row) { ?>
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title text-primary"><a class="card-title text-primary" href="/job/<?= $row['id'] ?>"><?= $row['name'] ?></a></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Công Ty <?= $row['company_name'] ?></h6>
                            </div>
                            <span class="badge bg-success">Mới</span>
                        </div>
                        <div class="mt-3">
                            <p class="card-text"><i class="fas fa-map-marker-alt text-secondary"></i> <?= $row['company_address'] ?></p>
                            <p class="card-text"><i class="fas fa-dollar-sign text-secondary"></i> <?= formatSalary($row['salary']) ?></p>
                            <p class="card-text"><i class="fas fa-briefcase text-secondary"></i> <?= $row['level'] ?></p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <?php foreach ($row['skills_name'] as $skill): ?>
                                    <span class="badge bg-light text-dark"><?= $skill ?></span>
                                <?php endforeach; ?>
                            </div>
                            <a href="/job/<?= $row['id'] ?>" class="btn btn-primary">Ứng tuyển ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

    <!-- Pagination -->
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

<script>
    const formSearch = document.getElementById('form-search');
    const formFilter = document.getElementById('form-filter');
    const dropFilter = document.getElementById('drop-filter');

    
    let url = new URL(window.location.href);
    dropFilter.addEventListener('click', () => {
        url.searchParams.delete('suggestion');
        url.searchParams.delete('skill');
        url.searchParams.delete('keyword');
        url.searchParams.delete('page');
        url.searchParams.delete('location');
        window.location.href = url.href;
    });
    
    if(formFilter){
        formFilter.addEventListener('submit', (event) => {
            event.preventDefault();
            const address = event.target.elements.address.value;
            const suggestion = event.target.elements.suggestion.value;
            const skills = event.target.elements.skills.value;
            if (suggestion) {
                url.searchParams.delete('suggestion');
                url.searchParams.set('suggestion', suggestion);
            } else {
                url.searchParams.delete('suggestion');
            }
            if (skills) {
                url.searchParams.delete('skill');
                url.searchParams.set('skill', skills);
            } else {
                url.searchParams.delete('skill');
            }
            if (address) {
                url.searchParams.delete('location');
                url.searchParams.set('location', address);
            } else {
                url.searchParams.delete('location');
            }
            window.location.href = url.href;
        })
    }

    if (formSearch) {
        formSearch.addEventListener('submit', (event) => {
            event.preventDefault();

            const keyword = event.target.elements.keyword.value;
            
            if (keyword) {
                url.searchParams.delete('page');
                url.searchParams.set('keyword', keyword);
            } else {
                url.searchParams.delete('keyword');
            }
            window.location.href = url.href;
        })
    }
    //pagination
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