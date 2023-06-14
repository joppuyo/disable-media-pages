<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function type($text)
    {
        $I = $this;
        $I->executeInSelenium(function(RemoteWebDriver $webDriver)use($text)
        {
            // https://maslosoft.com/blog/2017/03/03/codeception-acceptance-filling-in-contenteditable/
            $webDriver->getKeyboard()->sendKeys($text);
        });
    }

    /**
     * Define custom actions here
     */
}
