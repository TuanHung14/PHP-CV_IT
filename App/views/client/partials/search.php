<section class="search-section .p-2" style="background-color: #0093E9; background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%); color: white;">
    <div class="container">
        <h1 class="fs-3">708 Việc làm IT cho Developer "Chất"</h1>
        <form action="" id="form-search" role="search">
            <div class="d-flex align-items-center gap-2">
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <select name="address" class="form-select" id="address" aria-label="Default select example">
                        <option selected value="">Tất cả thành phố</option>
                        <?php foreach ($data['locations'] as $row): ?>
                            <option value="<?php echo $row?>"><?php echo $row?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <input type="text" id="form-search" name="keyword" class="form-control" style="max-width: 800px" placeholder="Nhập từ khóa theo tên job, kỹ năng, công ty...">
                <button class="btn btn-primary d-flex gap-2 align-items-center">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                </button>
            </div>

            <div class="suggestions mt-3 d-flex align-items-center flex-wrap">
                <?php foreach ($data['jobs'] as $row): ?>
                    <div class="form-check form-check-inline">
                        <input type="radio"
                            name="suggestion"
                            id="radio-<?= $row['id'] ?>"
                            value="<?= $row['name'] ?>"
                            class="custom-radio-btn">
                        <label class="custom-radio-label" for="radio-<?= $row['id'] ?>">
                            <?= $row['name'] ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
</section>
