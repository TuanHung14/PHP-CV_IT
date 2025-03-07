<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="card-title">Danh sách kỹ năng</h4>
        <form id="form-search" class="d-flex" role="search">
          <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
      <div class="table-responsive mt-4">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th> # </th>
              <th> Kỹ năng công việc</th>
              <th colspan="2"> Hành động </th>
            </tr>
          </thead>
          <tbody>
            <?php

            use Framework\Template;

            foreach ($skills as $row): ?>
              <tr>
                <td> <?= $row['id'] ?> </td>
                <td> <?= $row['name'] ?> </td>
                <?php
                $content = "<td><a href='/admin-panel/skill/edit/{$row['id']}' class='btn btn-outline-warning'><i class='fa fa-edit'></i></a> </td>";
                echo Template::can('edit_skills', $content);
                ?>

                <?php
                $content = " <form action='/admin-panel/skill/delete/{$row['id']}' method='POST'>
                              <input type='hidden' name='_method' value='DELETE'>
                              <td> <button type='submit' class='btn btn-outline-danger'><i class='fa fa-trash-o'></i></button> </td>
                            </form>";
                echo Template::can('delete_skills', $content);
                ?>
              </tr>
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
</script>