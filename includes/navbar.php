<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand"
           href="dashboard.php">

            Exit Exam System

        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
             id="menu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">

                    <a class="nav-link"
                       href="dashboard.php">

                        Dashboard

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                       href="select_exam.php">

                        Start Exam

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                       href="user/history.php">

                        History

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                       href="user/profile.php">

                        Profile

                    </a>

                </li>

                <?php if($_SESSION['role'] == 'admin'){ ?>

                    <li class="nav-item">

                        <a class="nav-link text-warning"
                           href="admin/dashboard.php">

                            Admin

                        </a>

                    </li>

                <?php } ?>

                <li class="nav-item">

                    <a class="nav-link text-danger"
                       href="logout.php">

                        Logout

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>