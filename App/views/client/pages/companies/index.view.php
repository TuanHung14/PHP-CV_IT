<div class="container mt-5">
<div class="row mb-4">
        <div class="col-md-12">
            <form action="" id="form-search" role="search">
                <div class="input-group">
                    <input type="text" name="keyword" value="<?= isset($keyword) ? $keyword : ""  ?>" class="form-control" placeholder="Tìm kiếm công ty...">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>
    <h2 class="text-center mb-4">Danh sách Công ty</h2>
    <div class="row">
        <?php foreach ($companies as $row): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <a href="/company/<?= $row['id'] ?>"><img src="/images/company/<?= $row['thumbnail'] ?>" class="card-img-top" alt="Công ty 1" style="height: 200px; object-fit: cover;"></a>
                    <div class="card-body text-center">
                        <h5 class="card-title"><a href="/company/<?= $row['id'] ?>" class="card-title"><?= $row['name'] ?></a> </h5>
                        <p class="card-text">Địa chỉ: <?= $row['address'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
    //pagination
    let url = new URL(window.location.href);
    const formSearch = document.getElementById('form-search');

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