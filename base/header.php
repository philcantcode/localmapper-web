<?php 
    $propCount = file_get_contents($GLOBALS['server'] . "/propositions/get-count");
    
    $jobStats = file_get_contents($GLOBALS['server'] . "/capability/jobs/get/stats");
    $jobStats = json_decode($jobStats, true);

    $pending = loadJSON("/cmdb/pending/get/all", true);
    $pendingCount = count($pending);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        <?php echo $GLOBALS['tab-name']; ?>
    </title>

    <!-- Favicons -->
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="/assets/vendor/FlexiJsonEditor/jsoneditor.css" rel="stylesheet" />
    <link href="/assets/css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>$.holdReady(true);</script>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">

        <!-- Logo -->
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="/assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">
                    <?php echo $GLOBALS['site-name']; ?>
                </span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="/assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="/assets/img/messages-2.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Anna Nelson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>6 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="/assets/img/messages-3.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>David Muldon</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>8 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>

                    </ul>

                </li>

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="/assets/img/profile-img.png" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">P.Kendrick</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Kevin Anderson</h6>
                            <span>Web Designer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-heading">System</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>Overview</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/dashboards.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboards</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/jobs.php">
                    <i class="bi bi-grid"></i>
                    <?php
                        echo "<span>Running Jobs</span>
                        <span class='badge mx-1 bg-success' data-toggle='tooltip' data-placement='top' title='Actively running jobs'>" . $jobStats["Running"] . "</span>
                        <span class='badge mx-1 bg-warning' data-toggle='tooltip' data-placement='top' title='Waiting jobs'>" . $jobStats["Waiting"] . "</span>";
                    ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/propositions.php">
                    <i class="bi bi-grid"></i>
                    <?php
                        if ($propCount > 0) 
                        {
                            echo "<span>Propositions</span><span class='badge mx-1 bg-danger'>" . $propCount . "</span>";
                        }
                        else {
                            echo "<span>Propositions</span>";
                        }
                    ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/logs.php">
                    <i class="bi bi-grid"></i>
                    <span>Logs</span>
                </a>
            </li>

            <li class="nav-heading">Capabilities</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/capabilities/run.php">
                    <i class="bi bi-share"></i>
                    <span>Run Capability</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/capabilities/manage.php">
                    <i class="bi bi-share"></i>
                    <span>Manage Capability</span>
                </a>
            </li>

            <li class="nav-heading">CMDB</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/cmdb/graph.php">
                    <i class="bi bi-share"></i>
                    <span>Graph View</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/cmdb/inventory.php">
                    <i class="bi bi-box"></i>
                    <span>Inventory</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/cmdb/pending.php">
                    <i class="bi bi-search"></i>
                    <?php
                        if ($pendingCount > 0) 
                        {
                            echo "<span>Pending Devices</span><span class='badge mx-1 bg-warning'>" . $pendingCount . "</span>";
                        }
                        else 
                        {
                            echo "<span>Pending Devices</span>";
                        }
                    ?>
                </a>
            </li>

            <li class="nav-heading">Admin</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/admin.php">
                    <i class="bi bi-grid"></i>
                    <span>Accounts</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/dbhealth.php">
                    <i class="bi bi-grid"></i>
                    <span>Database Health</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/server-health.php">
                    <i class="bi bi-grid"></i>
                    <span>Server Health</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/webhealth.php">
                    <i class="bi bi-grid"></i>
                    <span>Web Health</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/settings.php">
                    <i class="bi bi-grid"></i>
                    <span>Settings</span>
                </a>
            </li>

        </ul>

    </aside>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>
                <?php echo $GLOBALS['tab-name']; ?>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">
                            <?php echo $GLOBALS['previous-dir']; ?>
                        </a></li>
                    <li class="breadcrumb-item active">
                        <?php echo $GLOBALS['tab-name']; ?>
                    </li>
                </ol>
            </nav>
        </div>