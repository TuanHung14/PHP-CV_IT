<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="card-title">Danh sách role</h4>
        <form id="form-search" class="d-flex" role="search">
          <input class="form-control me-2" value="<?= isset($keyword) ? $keyword : ""  ?>" name="keyword" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
      <div class="table-responsive mt-4">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th> Tên</th>
              <th> Email</th>
              <th> Công việc ứng tuyển</th>
              <th> Trạng thái </th>
              <th> Link resume </th>
              <th colspan="2"> Hành động </th>
            </tr>
          </thead>
          <tbody>
            
            <?php

            use Framework\Template;

            foreach ($resumes as $row): ?>
            <form action="/admin-panel/resume/<?= $row['id'] ?>" method="POST">
              <input type="hidden" name="_method" value="PUT">
              <tr>
                <td> <?= $row['user_name'] ?> </td>
                <td> <?= $row['email'] ?> </td>
                <td> <?= $row['post_job_name'] ?> </td>
                <td>
                  <select class="form-select status-select" name="status">
                    <?php
                      foreach ($status as $sta){
                    ?>
                    <option value="<?= $sta['name'] ?>" <?= $row['status'] == $sta['name'] ? 'selected' : '' ?>><?= $sta['name'] ?></option>
                    <?php } ?>
                  </select>
                </td>
                <td> <a target="_blank" href="/file/resume/<?= $row['url'] ?>">Xem</a></td>
                <?php
                $content = "<td><button class='btn btn-outline-warning btn-edit-status'>
                      <i class='fa fa-edit'></i>
                    </button> </td>";
                echo Template::can('edit_resumes', $content);
                ?>
              </tr>
            </form>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-end">
        <nav aria-label="Page navigation example">
          <ul class="pagination custom-pagination">
            <?php for ($i = 1; $i <= $count; $i++) {
              if ($i == $page) { ?>
                <li class="page-item active"><button class="page-link" button-pagination="<?= $i ?>"><?= $i ?></button></li>
              <?php  } else {  ?>
                <li class="page-item"><button class="page-link" button-pagination="<?= $i ?>"><?= $i ?></button></li>
            <?php }
            } ?>

          </ul>
        </nav>

      </div>
    </div>
  </div>
</div>

<script>
  const formSearch = document.getElementById('form-search');

  let url = new URL(window.location.href);
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
        console.log(page);
        if (page) {
          url.searchParams.set('page', page);
          window.location.href = url.href;
        }
      })
    })
  }
  //end pagination
// Lấy tất cả các select box trong bảng
  const selects = document.querySelectorAll(".status-select");
  
  selects.forEach(select => {
    const oldStatus = select.querySelector("option[selected]");
    
    const status = select.querySelectorAll('option');
    let fould = false;
    if (status) {
      status.forEach(item => {
        if (item.value == oldStatus.value) {
          fould = true;
        }
        if (!fould) {
          item.disabled = true; 
        }
      })
    }
  });
  
</script>