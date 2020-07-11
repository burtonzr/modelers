<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Submission extends Entity {
    protected $_accessible = [
        'user_id' => true,
        'subject' => true,
        'model_type_id' => true,
        'submission_category_id' => true,
        'manufacturer_id' => true,
        'description' => true,
        'scale_id' => true,
        'status_id' => true,
        'created' => true,
        'approved' => true,
        'modified' => true,
        'image_path' => true,
        'user' => true,
        'model_type' => true,
        'submission_category' => true,
        'manufacturer' => true,
        'scale' => true,
        'status' => true,
        'images' => true,
        'submission_field_values' => true,
    ];
}
