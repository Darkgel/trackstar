<?php
namespace abCUpuCVWEleWt__hlEEZr39dajfAK;
/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 * @author shweihua
 * 这个文件的存在是为了让IDE能够自动地进行代码提醒,对程序的运行不会有影响
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 */
abstract class BaseApplication extends \yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property \app\components\rbac\ManagerInterface $authManager The auth manager application component. Null is returned
 * if auth manager is not configured. This property is read-only.
 */
class WebApplication extends \yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 * @property \app\components\rbac\ManagerInterface $authManager The auth manager application component. Null is returned
 * if auth manager is not configured. This property is read-only.
 */
class ConsoleApplication extends \yii\console\Application
{
}