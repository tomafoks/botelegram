<?php

class Setting extends DB\SQL\Mapper
{
    public function __construct(DB\SQL $db)
    {
        parent::__construct($db, 'setting');
    }

    public function getSetting()
    {
        $this->load();
        return $this->query;
    }
}
