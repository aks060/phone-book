<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>PhoneBook</title>

    <!-- Fontfaces CSS-->
    <link href="/static/css/font-face.css" rel="stylesheet" media="all">
    <link href="/static/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/static/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="/static/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="/static/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="/static/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="/static/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="/static/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="/static/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="/static/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="/static/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/static/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="/static/css/theme.css" rel="stylesheet" media="all">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="/static/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="/static/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            PhoneBook
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="/">
                                <i class="fas fa-tachometer-alt"></i>PhoneBook</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Assessment</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="login.html">Data Science</a>
                                </li>
                                <li>
                                    <a href="/dashboard/assessment/ml.html">Machine Learning</a>
                                </li>
                                <li>
                                    <a href="/dashboard/assessment/nlp.html">NLP</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/dashboard/assessment/cv.html">
                                <i class="fa fa-file" aria-hidden="true"></i>CV</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE -->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    PhoneBook
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="/">
                                <i class="fas fa-tachometer-alt"></i>PhoneBook</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Assessment</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/dashboard/assessment/ds.html">Data Science</a>
                                </li>
                                <li>
                                    <a href="/dashboard/assessment/ml.html">Machine Learning</a>
                                </li>
                                <li>
                                    <a href="/dashboard/assessment/nlp.html">NLP</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/dashboard/assessment/cv.html">
                                <i class="fa fa-file" aria-hidden="true"></i>CV</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop" style="z-index: 1">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">