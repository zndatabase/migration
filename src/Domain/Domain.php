<?php

namespace ZnDatabase\Migration\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'migration';
    }


}

