<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Deposit;
use app\models\Downline;
use app\models\FundActive;
use app\models\FundPassive;
use app\models\Groups;
use app\models\Member;
use app\models\RewardClaimed;
use app\models\User;
use DirectoryIterator;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\FileHelper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionUpdateMemberGroups()
    {
        $count = 0;

        $allMember = Member::find();

        foreach ($allMember->all() as $member) {

            if (@$member->groups != null) {
                continue;
            }

            $group = new Groups([
                'id_group' => Groups::GROUP_ADMIN,
                'id_member' => $member->id,
            ]);
            $group->save();

            $count++;
        }

        echo "done, $count rows updated";
    }

    public function actionInitDatabase()
    {
        Deposit::deleteAll();
        Downline::deleteAll();
        FundActive::deleteAll();
        FundPassive::deleteAll();
        Groups::deleteAll(['<>', 'id_member', 28]);
        Member::deleteAll(['<>', 'id', 28]);
        RewardClaimed::deleteAll();
        User::deleteAll(['<>', 'id', 3378]);

        echo 'done';
    }

    public function actionClearAsset()
    {
        $directory = Yii::getAlias('@app').'\web\assets';
        // echo $directory;

        $dir = new DirectoryIterator($directory);
        foreach ($dir as $folder) {
            if (!$folder->isDot()) {
                $folderName = $folder->getFilename();
                $folderPath = $directory . '\\' . $folderName;
                FileHelper::removeDirectory($folderPath);
            }
        }

    }

}
