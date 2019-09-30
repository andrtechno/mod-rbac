<?php

namespace panix\mod\rbac\migrations;

use yii\db\MigrationInterface;

/**
 * Class Migration
 *
 * @package panix\mod\rbac\migrations
 */
class Migration extends \panix\engine\db\Migration implements MigrationInterface
{

    use MigrationTrait;


    /**
     * @inheritdoc
     */
    public function up()
    {
        $transaction = $this->authManager->db->beginTransaction();
        try {
            if ($this->safeUp() === false) {
                $transaction->rollBack();

                return false;
            }
            $transaction->commit();
            $this->authManager->invalidateCache();

            return true;
        } catch (\Exception $e) {
            echo "Rolling transaction back\n";
            echo 'Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            echo $e->getTraceAsString() . "\n";
            $transaction->rollBack();

            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $transaction = $this->authManager->db->beginTransaction();
        try {
            if ($this->safeDown() === false) {
                $transaction->rollBack();

                return false;
            }
            $transaction->commit();
            $this->authManager->invalidateCache();

            return true;
        } catch (\Exception $e) {
            echo "Rolling transaction back\n";
            echo 'Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            echo $e->getTraceAsString() . "\n";
            $transaction->rollBack();

            return false;
        }
    }

}
