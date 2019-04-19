<?php

namespace DavidMorenoCortina\ORM\Command;


class UnknownCommand extends BaseCommand  {

    public function execute() {
        echo 'Command not found. Maybe it was wrong spelled or not exists.' . self::EOL;
    }
}