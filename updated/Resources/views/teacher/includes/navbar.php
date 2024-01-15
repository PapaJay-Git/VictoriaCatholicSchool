
<header role="banner">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border-bottom border-warning border-3 animate__animated animate__fadeIn">
    <div class="container">
      <a class="navbar-brand fs-6" href="index.php"><img class ="logo" src="../../images/victoria.png" width="45px" height="45px"> Victoria Catholic School</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon fs-6"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto ">
          <li class="nav-item">
            <a class="navs nav-link mx-2" aria-current="page" href="index.php" id="home_tab">HOME</a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="schedules.php" id="schedules_tab">SCHEDULES</a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="assigned_subjects.php" id="assigned_subjects_tab">SUBJECTS</a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="advisories.php" id="advisories_tab">ADVISORIES</a>
          </li>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="promissories.php" id="promissories_tab">PROMISSORIES</a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2 position-relative" href="notifications.php" id="notifications_tab">NOTIFICATIONS
              <?php 
              if($unread_count > 0){
                echo '
                <span class="position-absolute start-100 translate-middle bg-danger p-2 rounded-circle text-center" style="width: 25px;">
                  '.$unread_count.'
                </span>
                ';
              }
              ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="profiles.php" id="profiles_tab">PROFILE</a>
          </li>
          <li class="nav-item">
            <a role="button" class="navs nav-link mx-2" onclick="logout()">LOGOUT</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<div class="mt-5">_</div>

