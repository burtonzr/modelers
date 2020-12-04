<?php
    $cakeDescription = 'The Model Gallery';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        
        <?= $this->Html->script('users.js') ?>
        <?= $this->Html->css('milligram.min.css') ?>
        <?= $this->Html->css('cake.css') ?>
        <?= $this->Html->css('home.css') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <nav class="navbar navbar-expand-md bg-danger navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/review">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/feature">Features</a>
                    </li>
                    <li class="nav-item">
                        <a>
                            <?php 
                                echo $this->Html->link('Gallery', array('controller' => 'SubmissionCategories', 'action' => 'index'), array('title' => 'Gallery', 'class' => 'nav-link'));
                            ?>
                        </a>
                    </li>
                    <?php if($email) { ?>
                        <div class="dropdown-container">
                            <li type="button" class="nav-item btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only"></span>
                            </li>
                            <div class="dropdown-menu">
                                <?php
                                    echo $this->Html->link('Add Submission', array('controller' => 'submissions', 'action' => 'add'), array('title' => 'Add Submission', 'class' => 'dropdown-item dropdown-menu-right'));
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <li class="nav-item">
                        <a target="_blank" class="nav-link" href="http://www.shipmodels.info/mws_forum/index.php">Forum</a>
                    </li>
                    <li class="nav-item">
                        <a target="_blank" class="nav-link" href="http://www.modelshipgallery.com/gallery/index-gallery.html">Archives</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/contact">Contact</a>
                    </li>
                    <?php if(!$email) { ?>
                        <li class="nav-item">
                            <a>
                                <?php echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'add'), array('title' => 'Register', 'class' => 'nav-link'));?>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a>
                                <?php 
                                    echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('title' => 'Login','class' => 'nav-link'));
                                ?>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a>
                                <?php echo $this->Html->link('My Profile', array('controller' => 'users', 'action' => 'view/', $id), array('title' => 'My Profile', 'class' => 'nav-link'));?>
                            </a> 
                        </li>
                        <?php if($UserGroupID == 2 || $UserGroupID == 3): ?>
                            <li class="nav-item">
                                <div class="nav-link">Admin</div>
                            </li>
                            <div class="dropdown-container">
                                <li type="button" class="nav-item btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only"></span>
                                </li>
                                <div class="dropdown-menu">
                                    <?php
                                        echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index'), array('title' => 'Users', 'class' => 'dropdown-item dropdown-menu-right'));
                                        echo $this->Html->link('Submissions', array('controller' => 'submissions', 'action' => 'index'), array('title' => 'Submission', 'class' => 'dropdown-item dropdown-menu-right'));
                                        if($UserGroupID == 3) {
                                            echo $this->Html->link('Manufacturers', array('controller' => 'manufacturers', 'action' => 'index'), array('title' => 'Manufacturers', 'class' => 'dropdown-item dropdown-menu-right'));
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a>
                                <?php 
                                    echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('title' => 'Logout', 'class' => 'nav-link'));
                                ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <main class="main">
            <div style="margin-left: 10px; margin-right: 10px;">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>
    </body>
</html>
