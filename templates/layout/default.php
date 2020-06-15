<?php
    $cakeDescription = 'CakePHP: the rapid development php framework';
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
        <nav class="top-nav">
            <div class="top-nav-title">
                <a href="/"><span>Cake</span>PHP</a>
            </div>
            <div class="top-nav-links">
                <a target="_blank" href="https://book.cakephp.org/4/">Home</a>
                <a target="_blank" href="https://api.cakephp.org/4/">Reviews</a>
                <a target="_blank" href="https://api.cakephp.org/4/">Features</a>
                <a target="_blank" href="https://api.cakephp.org/4/">Gallery</a>
                <a target="_blank" href="https://api.cakephp.org/4/">Forum</a>
                <a target="_blank" href="https://api.cakephp.org/4/">Archives</a>
                <a target="_blank" href="https://api.cakephp.org/4/">Contact</a>
                <a target="_blank" href="https://api.cakephp.org/4/">Login / Create Account</a>
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
