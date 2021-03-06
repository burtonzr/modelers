<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Status Entity
 *
 * @property int $id
 * @property string $type
 * @property string $code
 * @property string $title
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User[] $users
 */
class Status extends Entity {
    
    protected $_accessible = [
        'type' => true,
        'code' => true,
        'title' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'users' => true,
    ];
}
