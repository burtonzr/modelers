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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

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
                        <a class="nav-link" href="/">Home</a>
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
                                echo $this->Html->link('Gallery', array('controller' => 'ModelTypes', 'action' => 'index'), array('title' => 'Gallery', 'class' => 'nav-link'));
                            ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a target="_blank" class="nav-link" href="http://www.shipmodels.info/mws_forum/index.php">Forum</a>
                    </li>
                    <li class="nav-item">
                        <a target="_blank" class="nav-link" href="http://www.modelshipgallery.com/gallery/index-gallery.html">Archives</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/contact">Contact</a>
                    </li>
                    <?php if($UserGroupID == 3): ?>
                        <li class="nav-item">
                            <a>
                                <?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index'), array('title' => 'Users', 'class' => 'nav-link'));?>
                            </a> 
                        </li>
                    <?php endif; ?>
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
            <div class="container">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>
        <footer>
        </footer>
    </body>
</html>
