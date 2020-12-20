<div class="container-fluid">
    <h1 class="pagetitle text-center"><?= __('ModelShipGallery.com') ?></h1>
    <div class="row mt-5">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4">
            <h4 class="text-center float-right">Filter by</h4>
        </div>
        <div class="col-sm-4">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input check_scales" id="check_scales" name="Scales" value="Scales"><span class="ml-2">Scales</span>
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input check_manufacturers" id="check_manufacturers" name="Manufacturers" value="Manufacturers"><span class="ml-2">Manufacturers</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div id="scales_filter" class="d-none col-12 col-sm-5">
            <?php
                echo $this->Form->control('scale_id', ['options' => $filterScales, 'label' => 'Filter by Scale', 'id' => 'scale_id', 'empty' => true]);
            ?>
        </div>
        <div id="manufacturer_filter" class="d-none col-12 col-sm-5">
            <?php
                echo $this->Form->control('manufacturer_id', ['options' => $filterManufacturer, 'label' => 'Filter by Manufacturer', 'id' => 'manufacturer_id', 'empty' => true]);
            ?>
        </div>
        <div id="filter_submit" class="d-none col-12 col-sm-2">
            <button id="filter_click_button" type="button" class="btn btn-success">Filter Submissions</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 mt-5">
            <ul class="list-group">
                <?php foreach ($submissionCategories as $submissionCategory): ?>
                    <li class="list-group-item">
                        <a style="color: #0071BC;cursor: pointer;" class="filterSubmissionCategory" data-id="<?= $submissionCategory->id ?>" style="text-decoration: none;"><?= h($submissionCategory->title) ?></a>
                        <!--
                        <?= $this->Html->link(h($submissionCategory->title), ['controller' => 'SubmissionCategories', 'action' => 'view', $submissionCategory->id]) ?>
                        -->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-sm-4 mt-5">
            <!--<div class="submission-container">-->
                <?php foreach($submissions as $submission): ?>
                    <div class="col-sm-12 mt-2 gridSubmissions d-flex justify-content-center">
                        <img src="../../img/<?= $submission['image_path']; ?>" class="img-thumbnail img-fluid" />
                        <div class="overlay">
                            <div class="text"><?= h($submission->subject); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
           <!-- </div>-->
        </div>
        <div class="col-sm-4 mt-5">
            <div class="submission-container">
                <?php foreach($submissions as $submission): ?>
                    <div class="col-sm-12 content mt-2 gridSubmissions d-flex justify-content-center">
                        <div class="inner">
                            <h4>
                                <?php foreach($scales as $scale): ?>
                                    <?php if($scale->id === $submission->scale_id): ?>
                                        <?= h($scale->scale) ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?= $this->Html->link(__(h($submission->subject)), ['controller' => 'Submissions', 'action' => 'view', $submission->id]) ?>
                                <?php foreach($manufacturers as $manufacturer): ?>
                                    <?php if($manufacturer->id === $submission->manufacturer_id): ?>
                                        (<?= h($manufacturer->name); ?>)
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <span>by</span>
                                <?php foreach($users as $user): ?>
                                    <?php if($user->id === $submission->user_id): ?>
                                        <?= h($user->name) ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </h4>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="paginator mt-3">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
<script>
    $(document).ready(function() {
        var scale_id             = 0;
        var manufacturer_id      = 0;
        var submissionCategoryid = 0;
        $("#check_scales").on('change', function() {
            if($("input.check_scales").is(':checked')) {
                $("#scales_filter").removeClass('d-none');
                $("#filter_submit").removeClass('d-none');
            } else {
                $("#scales_filter").addClass('d-none');
            }
        });
        $("#check_manufacturers").on('change', function() {
            if($("input.check_manufacturers").is(':checked')) {
                $("#manufacturer_filter").removeClass('d-none');
                $("#filter_submit").removeClass('d-none');
            } else {
                $("#manufacturer_filter").addClass('d-none');
            }
        });
        $("#scale_id").on('change', function() {
            scale_id = $(this).val();
        });
        $("#manufacturer_id").on('change', function() {
            manufacturer_id = $(this).val();
        });
        $(".filterSubmissionCategory").on('click', function() {
            $(this).map(function() {
                submissionCategoryid = $(this).attr('data-id'); 
                console.log(submissionCategoryid);
                search(scale_id, manufacturer_id, submissionCategoryid);
            });
        });
        $("#filter_click_button").on('click', function() {
            if(scale_id == "") {
                scale_id = 0;
            }
            if(manufacturer_id == "") {
                manufacturer_id = 0;
            }
            search(scale_id, manufacturer_id, submissionCategoryid);
        });

        function search(filter_scale, filter_manufacturer, filter_category) {
            var dataScale        = filter_scale;
            var dataManufacturer = filter_manufacturer;
            var dataCategory     = filter_category;
            $.ajax({
                method: 'get',
                url: "<?php echo $this->Url->build(['controller' => 'SubmissionCategories', 'action' => 'Search']); ?>",
                data: {
                    scale:        dataScale,
                    manufacturer: dataManufacturer,
                    category:     dataCategory
                },
                success: function(response) {
                    $('.submission-container').html(response);
                }
            });
        }
    });
</script>