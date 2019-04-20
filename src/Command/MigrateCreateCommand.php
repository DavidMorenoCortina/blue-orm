<?php

namespace DavidMorenoCortina\ORM\Command;


class MigrateCreateCommand extends BaseCommand {

    public function execute() {
        $parts = explode(' ', microtime());
        $migrationName = date('Y_m_d_H_i_s_') . str_replace('0.', '', $parts[0]);

        $fileName = 'Migration' . $migrationName;

        $body = '<?php' . self::EOL . self::EOL;
        $body .= 'use DavidMorenoCortina\ORM\Migration\BaseMigration;' . self::EOL . self::EOL;
        $body .= 'class ' . $fileName . ' extends BaseMigration {' . self::EOL;

        $body .= '    public function getVersionName() :string {' . self::EOL;
        $body .= '        return \'' . $migrationName . '\';' . self::EOL;
        $body .= '    }' . self::EOL . self::EOL;

        $body .= '    public function setUp() :void {' . self::EOL . self::EOL;
        $body .= '    }' . self::EOL . self::EOL;

        $body .= '    public function tearDown() :void {' . self::EOL . self::EOL;
        $body .= '    }' . self::EOL;

        $body .= '}' . self::EOL;

        if(!is_dir(BLUEORM_ROOT . 'migrations/')){
            mkdir(BLUEORM_ROOT . 'migrations/');
        }

        $filePath = BLUEORM_ROOT . 'migrations/' . $fileName . '.php';
        file_put_contents($filePath, $body);
    }
}