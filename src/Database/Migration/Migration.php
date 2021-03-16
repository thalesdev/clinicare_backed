<?php

namespace Clinicare\Database\Migration;

use Clinicare\Database;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    // @var \Illuminate\Database\Capsule\Manager $capsule 
    public $capsule;
    // @var \Illuminate\Database\Schema\Builder $capsule
    public $schema;

    public function init()
    {
        $this->capsule = Database\Database::boot();
        $this->schema = $this->capsule->schema();
    }
}
