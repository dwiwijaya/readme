<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\helpers\Utils;
use app\models\mstMenu;
use app\models\User;
use app\widgets\Alert;
use mdm\admin\components\Helper;
use mdm\admin\components\MenuHelper;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$profileUrl = Yii::$app->user->isGuest ? ['site/login'] : ['users/account', 'id' => User::me()->id];
$profileImg = Yii::$app->user->isGuest ? Utils::baseUploadsStock('user.png') : Utils::baseUploadsStock('user.png');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column h-100">

    <!-- Import Font awesome -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        li a {
            text-transform: capitalize;
        }

        .landing-img {
            width: 50% ;
            position: absolute;
            right: 0;
            bottom: -18rem;
        }

        @media screen and (max-width:767px) {
            .landing-img {
                width: 100% !important;
                position: static !important;
            }

            .home {
                height: 100vh !important;
            }

            .landing-img {
                margin: auto;
                display: flex;
            }

            .img img {
                position: relative;
                width: 75% !important;
            }

            .main-content {
                margin-top: 4rem !important;
                text-align: center;
                display: table-footer-group;
            }

            .group-btn {
                display: flex;
                justify-content: center;
                gap: 1rem;
                margin-top: 2rem;
            }
            .w50 {
                width: 50%;
            }
            .h50v {
                width: 40vh;
            }

        }

        .account {
            width: 100%;
        }

        .account a {
            float: right;
        }

        .home {
            display: none;
        }

        .nav-container {
            display: flex;
            align-items: center;
            padding: 0 !important;
        }

        .profile-navbar img {
            width: 35px !important;
        }

        .home {
            height: 50vh;
            background-color: #0b2862;
        }

        

        .relative {
            position: relative;
        }

        

        .py-6 {
            padding-top: 9rem;
            padding-bottom: 6rem
        }

    </style>

    <?php $this->beginBody() ?>
    <?php
    $profile = User::getProfile();
    $menu = mstMenu::getNativenavbar();
    $menu = Yii::$app->user->isGuest ? $menu['guest'] : $menu['guest'];
    ?>
    <nav class="border-bottom fixed-top navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand" href="#"><b>Readme</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php foreach ($menu as $m) : ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= Url::to([$m['route']]) ?>"><?= $m['name']; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="profile-navbar" href="<?= Url::to([$profile['route']]); ?>"><img src="<?= $profile['img']; ?>" alt=""></a>
            </div>
        </div>
    </nav>

    </nav>
    <main id="main" class="flex-shrink-0" role="main">
        <div class="home">
            <div class="container h-100 h50 py-6">
                <div class="relative">
                    <img class="landing-img" src="<?= Utils::baseUploadsStock('developer.png'); ?>" alt="">
                </div>
                <div class="main-content float-left text-light w-100 w50 mt-3">
                    <h1 class="fw-700">Readme.</h1>
                    <h5 class="mb-3">Learning code by the easy way</h5>
                    <a href="<?= Url::to(['login']); ?>" class="text-light btn btn-outline-primary"><li class="fa fa-sign-in"></li>&nbsp; Sign-in / Sign-up</a>
                    <a href="<?= Url::to(['login']); ?>" class="text-light btn btn-outline-success"><li class="fa fa-search"></li>&nbsp; Explore</a>
                </div>
            </div>
        </div>
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])) : ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>