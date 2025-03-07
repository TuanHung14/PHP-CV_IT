<div class="row">
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">Resume: <?= $sumResume['totalDay'] ?></h3>
              <!-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> -->
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success ">
              <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Số CV nộp theo ngày</h6>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">Resume: <?= $sumResume['totalMonth'] ?></h3>
              <!-- <p class="text-success ms-2 mb-0 font-weight-medium">+11%</p> -->
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success">
              <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Số CV nộp theo tháng</h6>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">Resume: <?= $sumResume['totalYear'] ?></h3>
              <!-- <p class="text-danger ms-2 mb-0 font-weight-medium">-2.4%</p> -->
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success ">
              <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Số CV nộp theo năm</h6>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">Resume: <?= $sumResume['totalPending'] ?></h3>
              <!-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> -->
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success ">
              <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Số CV đang chờ</h6>
      </div>
    </div>
  </div>
</div>
<div class="row ">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Resume mới nhất</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <!-- <th>
                  <div class="form-check form-check-muted m-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" id="check-all">
                    </label>
                  </div>
                </th> -->
                <th> Tên </th>
                <th> Công việc </th>
                <th> Công ty </th>
                <th> Xem nhanh </th>
                <th> Thời gian apply </th>
                <th> Trạng thái </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($newResumes as $row){
                $formatted_date = date("d/m/Y", strtotime($row['createdAt']));
                $status = $row['status']; 
                $badgeClass = '';

                switch ($status) {
                    case 'Được mời phỏng vấn':
                        $badgeClass = 'success'; // Xanh lá
                        break;
                    case 'Đã xem':
                        $badgeClass = 'warning'; // Vàng
                        break;
                    case 'Từ chối':
                        $badgeClass = 'danger'; // Đỏ
                        break;
                    default:
                        $badgeClass = 'secondary'; // Xám (mặc định)
                        break;
                }
              ?>
              <tr>
                <!-- <td>
                  <div class="form-check form-check-muted m-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input">
                    </label>
                  </div>
                </td> -->
                <td>
                  <span class="ps-2"><?= $row['user_name'] ?></span>
                </td>
                <td> <?= $row['company_name'] ?></td>
                <td> <?= $row['post_name'] ?> </td>
                <td><a target="_blank" href="/file/resume/<?= $row['url'] ?>">Xem nhanh</a></td>
                <td> <?= $formatted_date ?> </td>
                <td>
                  <div class="badge badge-outline-<?= $badgeClass ?>"><?= $row['status'] ?></div>
                </td>
              </tr>
              <?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h5>Revenue</h5>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">$32123</h2>
              <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p>
            </div>
            <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h5>Sales</h5>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">$45850</h2>
              <p class="text-success ms-2 mb-0 font-weight-medium">+8.3%</p>
            </div>
            <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h5>Purchase</h5>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">$2039</h2>
              <p class="text-danger ms-2 mb-0 font-weight-medium">-2.1% </p>
            </div>
            <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="row">
  <div class="col-md-6 col-xl-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-row justify-content-between">
          <h4 class="card-title">Messages</h4>
          <p class="text-muted mb-1 small">View all</p>
        </div>
        <div class="preview-list">
          <div class="preview-item border-bottom">
            <div class="preview-thumbnail">
              <img src="/admin/images/faces/face6.jpg" alt="image" class="rounded-circle" />
            </div>
            <div class="preview-item-content d-flex flex-grow">
              <div class="flex-grow">
                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                  <h6 class="preview-subject">Leonard</h6>
                  <p class="text-muted text-small">5 minutes ago</p>
                </div>
                <p class="text-muted">Well, it seems to be working now.</p>
              </div>
            </div>
          </div>
          <div class="preview-item border-bottom">
            <div class="preview-thumbnail">
              <img src="/admin/images/faces/face8.jpg" alt="image" class="rounded-circle" />
            </div>
            <div class="preview-item-content d-flex flex-grow">
              <div class="flex-grow">
                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                  <h6 class="preview-subject">Luella Mills</h6>
                  <p class="text-muted text-small">10 Minutes Ago</p>
                </div>
                <p class="text-muted">Well, it seems to be working now.</p>
              </div>
            </div>
          </div>
          <div class="preview-item border-bottom">
            <div class="preview-thumbnail">
              <img src="/admin/images/faces/face9.jpg" alt="image" class="rounded-circle" />
            </div>
            <div class="preview-item-content d-flex flex-grow">
              <div class="flex-grow">
                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                  <h6 class="preview-subject">Ethel Kelly</h6>
                  <p class="text-muted text-small">2 Hours Ago</p>
                </div>
                <p class="text-muted">Please review the tickets</p>
              </div>
            </div>
          </div>
          <div class="preview-item border-bottom">
            <div class="preview-thumbnail">
              <img src="/admin/images/faces/face11.jpg" alt="image" class="rounded-circle" />
            </div>
            <div class="preview-item-content d-flex flex-grow">
              <div class="flex-grow">
                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                  <h6 class="preview-subject">Herman May</h6>
                  <p class="text-muted text-small">4 Hours Ago</p>
                </div>
                <p class="text-muted">Thanks a lot. It was easy to fix it .</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Portfolio Slide</h4>
        <div class="owl-carousel owl-theme full-width owl-carousel-dash portfolio-carousel" id="owl-carousel-basic">
          <div class="item">
            <img src="/admin/images/dashboard/Rectangle.jpg" alt="">
          </div>
          <div class="item">
            <img src="/admin/images/dashboard/Img_5.jpg" alt="">
          </div>
          <div class="item">
            <img src="/admin/images/dashboard/img_6.jpg" alt="">
          </div>
        </div>
        <div class="d-flex py-4">
          <div class="preview-list w-100">
            <div class="preview-item p-0">
              <div class="preview-thumbnail">
                <img src="/admin/images/faces/face12.jpg" class="rounded-circle" alt="">
              </div>
              <div class="preview-item-content d-flex flex-grow">
                <div class="flex-grow">
                  <div class="d-flex d-md-block d-xl-flex justify-content-between">
                    <h6 class="preview-subject">CeeCee Bass</h6>
                    <p class="text-muted text-small">4 Hours Ago</p>
                  </div>
                  <p class="text-muted">Well, it seems to be working now.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p class="text-muted">Well, it seems to be working now. </p>
        <div class="progress progress-md portfolio-progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-xl-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">To do list</h4>
        <div class="add-items d-flex">
          <input type="text" class="form-control todo-list-input" placeholder="enter task..">
          <button class="add btn btn-primary todo-list-add-btn">Add</button>
        </div>
        <div class="list-wrapper">
          <ul class="d-flex flex-column-reverse text-white todo-list todo-list-custom">
            <li>
              <div class="form-check form-check-primary">
                <label class="form-check-label">
                  <input class="checkbox" type="checkbox"> Create invoice </label>
              </div>
              <i class="remove mdi mdi-close-box"></i>
            </li>
            <li>
              <div class="form-check form-check-primary">
                <label class="form-check-label">
                  <input class="checkbox" type="checkbox"> Meeting with Alita </label>
              </div>
              <i class="remove mdi mdi-close-box"></i>
            </li>
            <li class="completed">
              <div class="form-check form-check-primary">
                <label class="form-check-label">
                  <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
              </div>
              <i class="remove mdi mdi-close-box"></i>
            </li>
            <li>
              <div class="form-check form-check-primary">
                <label class="form-check-label">
                  <input class="checkbox" type="checkbox"> Plan weekend outing </label>
              </div>
              <i class="remove mdi mdi-close-box"></i>
            </li>
            <li>
              <div class="form-check form-check-primary">
                <label class="form-check-label">
                  <input class="checkbox" type="checkbox"> Pick up kids from school </label>
              </div>
              <i class="remove mdi mdi-close-box"></i>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Visitors by Countries</h4>
        <div class="row">
          <div class="col-md-5">
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td>
                      <i class="flag-icon flag-icon-us"></i>
                    </td>
                    <td>USA</td>
                    <td class="text-end"> 1500 </td>
                    <td class="text-end font-weight-medium"> 56.35% </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="flag-icon flag-icon-de"></i>
                    </td>
                    <td>Germany</td>
                    <td class="text-end"> 800 </td>
                    <td class="text-end font-weight-medium"> 33.25% </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="flag-icon flag-icon-au"></i>
                    </td>
                    <td>Australia</td>
                    <td class="text-end"> 760 </td>
                    <td class="text-end font-weight-medium"> 15.45% </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="flag-icon flag-icon-gb"></i>
                    </td>
                    <td>United Kingdom</td>
                    <td class="text-end"> 450 </td>
                    <td class="text-end font-weight-medium"> 25.00% </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="flag-icon flag-icon-ro"></i>
                    </td>
                    <td>Romania</td>
                    <td class="text-end"> 620 </td>
                    <td class="text-end font-weight-medium"> 10.25% </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="flag-icon flag-icon-br"></i>
                    </td>
                    <td>Brasil</td>
                    <td class="text-end"> 230 </td>
                    <td class="text-end font-weight-medium"> 75.00% </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-7">
            <div id="audience-map" class="vector-map"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->