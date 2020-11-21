<?php
    use Cake\Cache\Cache;
    use Cake\Core\Configure;
    use Cake\Core\Plugin;
    use Cake\Datasource\ConnectionManager;
    use Cake\Error\Debugger;
    use Cake\Http\Exception\NotFoundException;
    use Cake\I18n\FrozenTime;
    use Cake\I18n\Time;

    $this->disableAutoLayout();

    $cakeDescription = 'Model Warship Gallery';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
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
        <?= $this->Html->script('home.js') ?>
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
                                echo $this->Html->link('Gallery', array('controller' => 'ModelTypes', 'action' => 'index'), array('title' => 'Gallery', 'class' => 'nav-link'));
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
                            </li>
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
        <header>
            <div class="container text-center">
                <h1 class="pagetitle text-center">
                    Model Warship Gallery
                </h1>
                <img src="../img/mwlogo-05a.gif" class="img-fluid" />
            </div>
        </header>
        <div>
            <script>
                $(document).ready(function() {
                    var d        = new Date();
                    year         = d.getFullYear();
                    month        = '' + (d.getMonth() + 1);
                    day          = '' + d.getDate();
                    var created  = year + "-" + month + "-" + day;
                    $("#created").text(created);
                });
            </script>
            <h2 class="text-center">What's New</h2>
            <div class="row">
                <?php foreach($query as $row): ?>
                    <div class="col-6 text-center">
                        <h3>
                            <?= $this->Html->link(__(h($row->subject)), ['controller' => 'Submissions', 'action' => 'view', $row->id]) ?> 
                        </h3>
                        <img src="../img/<?= $row['image_path']; ?>" width="70%" class="img-fluid" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="container text-center mt-3">
            <div class="row">
                <div class="col-6 col-sm-4 col-md-3 border border-dark d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.gwylanmodels.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/gwy.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-dark d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.ka-models.com/?ckattempt=3" target="_blank" style="text-decoration: none;">
                        <img src="../img/freetime.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-dark d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://pontosmodel.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/pontomodel.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-dark d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.bnamodelworld.com/model-ships-section" target="_blank" style="text-decoration: none;">
                        <img src="../img/bna-modelworld.gif" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-dark d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.hobbyeasy.com//" target="_blank" style="text-decoration: none;">
                        <img src="../img/HobbyEasy.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-dark d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://sdmodelmakers.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/SDModelmakers.jpg" class="img-fluid" />
                    </a>
                </div>
            </div>
        </div>
        <div class="container text-center mt-3">
            <div class="row">
                <div class="col-6 col-sm-4 col-md-3 border border-warning d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.infini-model.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/infini-model.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-warning d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.ka-models.com/?ckattempt=3" target="_blank" style="text-decoration: none;">
                        <img src="../img/KA-Models.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-warning d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.tomsmodelworks.com/catalog/index.php" target="_blank" style="text-decoration: none;">
                        <img src="../img/toms-mw.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-warning d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.hismodel.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/HiSModel.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-warning d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.flyhawkmodel.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/flyhawk.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-warning d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.whiteensignmodels.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/wem.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-warning d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://3dmodelparts.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/3DModelParts.jpg" class="img-fluid" />
                    </a>
                </div>
            </div>
        </div>
        <div class="container text-center mt-5">
            <h3>Visit Our Sponsors</h3>
            <div class="row">
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://combrig-models.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/combrig.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.nntmodell.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/NNT-logo.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.dodo-models.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/Dodo_Models.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.facebook.com/Veteran-Models-%E5%A8%81%E7%89%B9%E5%80%AB%E6%A8%A1%E5%9E%8B-170063279690089/?fref=ts" target="_blank" style="text-decoration: none;">
                        <img src="../img/VeteranModels.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://flagshipmodels.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/flagship.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.akamodel.com/en/" target="_blank" style="text-decoration: none;">
                        <img src="../img/akamodel.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.avrmodel.com/es/" target="_blank" style="text-decoration: none;">
                        <img src="../img/AvrModel.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.grandpascabinets.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/grandpabanner.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://scaledecks.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/scaledecks.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://blackcatmodels.eu/en/" target="_blank" style="text-decoration: none;">
                        <img src="../img/BlackCatModels.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.ssnmodellbau.de/" target="_blank" style="text-decoration: none;">
                        <img src="../img/SSN_ModelBau.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://micromaster.co.nz/" target="_blank" style="text-decoration: none;">
                        <img src="../img/Micro-Master.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.shapeways.com/shops/Frenobulax" target="_blank" style="text-decoration: none;">
                        <img src="../img/KokodaTrailModels.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.model-monkey.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/ModelMonkey.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.starfighter-decals.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/starfighter.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.modelships.info/Amphionmodels/" target="_blank" style="text-decoration: none;">
                        <img src="../img/Amphion.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.shapeways.com/shops/classicairships" target="_blank" style="text-decoration: none;">
                        <img src="../img/ClassicAirships.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://ihphobby.tripod.com/700shipkits/7001.html" target="_blank" style="text-decoration: none;">
                        <img src="../img/IHP.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.veryfirehobby.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/VeryFire.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.classicwarships.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/CW-Logo.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.artisthobby.net/" target="_blank" style="text-decoration: none;">
                        <img src="../img/ArtistHobby.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.bigblueboy.net/" target="_blank" style="text-decoration: none;">
                        <img src="../img/BigBlueBoy.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://www.sovereignhobbies.co.uk/password" target="_blank" style="text-decoration: none;">
                        <img src="../img/SovereignHobbies.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.larsenal.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/larsenal.jpeg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.master-model.pl/" target="_blank" style="text-decoration: none;">
                        <img src="../img/master.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://starling-models.co.uk/" target="_blank" style="text-decoration: none;">
                        <img src="../img/StarlingModels.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://krakenhobbies.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/KrakenHobbies.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://mtminiatures.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/mt-mini.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://webshop.modellbaudienst.de/offline.html" target="_blank" style="text-decoration: none;">
                        <img src="../img/PetrOs-Modellbau.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="http://www.warshiphobbies.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/warshiphobbies.jpg" class="img-fluid" />
                    </a>
                </div>
                <div class="col-6 col-sm-4 col-md-3 border border-danger d-flex justify-content-center align-items-center">
                    <a class="mt-5" href="https://ak-interactive.com/" target="_blank" style="text-decoration: none;">
                        <img src="../img/ak-interactive.jpg" class="img-fluid" />
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
