<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;

class WordPress64Cest
{

    public function iDoSetup(AcceptanceTester $I, $scenario)
    {
        global $wp_version;
        if (version_compare($wp_version, '6.4', 'lt')) {
            $scenario->skip('This test is only applicable for WordPress 6.4 and newer.');
        }

        $I->importSqlDumpFile(codecept_data_dir('dump.sql'));

        $I->cli(['option', 'update', 'home', $_ENV['TEST_SITE_WP_URL']]);
        $I->cli(['option', 'update', 'siteurl', $_ENV['TEST_SITE_WP_URL']]);
        $I->cli(['option', 'update', 'admin_email_lifespan', '2147483646']);

        try {
            $I->cli(['config', 'set', 'WP_DEBUG', 'true', '--raw']);
            $I->cli(['config', 'set', 'SCRIPT_DEBUG', 'true', '--raw']);
            $I->cli(['config', 'set', 'AUTOMATIC_UPDATER_DISABLED', 'true', '--raw']);
        } catch (Throwable $exception) {

        }

        $I->cli(['core', 'update-db']);

        $I->cli(['option', 'set', 'wp_attachment_pages_enabled', '0']);

        //$I->cli(['config', 'set', 'AUTOMATIC_UPDATER_DISABLED', 'true', '--raw']);

        $I->cli(['plugin', 'install', 'disable-welcome-messages-and-tips']);
        $I->cli(['plugin', 'activate', 'disable-welcome-messages-and-tips']);

        $I->cli(['theme', 'install', 'twentynineteen']);
        $I->cli(['theme', 'activate', 'twentynineteen']);
    }

    /**
     * @depends iDoSetup
     */
    public function iUploadImage(AcceptanceTester $I)
    {
        $I->loginAsAdmin();
        $I->amOnAdminPage('upload.php');
        $I->click('.page-title-action');
        $I->attachFile(
            '.moxie-shim input',
            'example.jpg'
        );
        $I->waitForElementNotVisible('.attachment.uploading.save-ready');
        $I->saveSessionSnapshot('login');
    }

    /**
     * @depends iUploadImage
     */
    public function iGoToMediaPage(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPage('/example/');
        $I->dontSee('example');
    }

    /**
     * @depends iGoToMediaPage
     */
    public function iActivatePlugin(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPluginsPage();
        $I->activatePlugin('disable-media-pages');
    }

    /**
     * @depends iActivatePlugin
     */
    public function iGoToMediaPageAgain(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPage('/example/');
        $I->dontSee('example');
        $I->see('That page can’t be found.');
    }

    /**
     * @depends iGoToMediaPageAgain
     */
    public function iMangleExistingAttachments(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnAdminPage('options-general.php?page=disable-media-pages');
        $I->waitForText('Mangle existing slugs');
        $I->click('Mangle existing slugs');
        $I->waitForText('Existing media slug mangling tool');
        $I->click('Start mangling process');
        $I->waitForText('All media slugs mangled');
    }

    /**
     * @depends iMangleExistingAttachments
     */
    public function createPage(AcceptanceTester $I)
    {
        global $wp_version;
        $I->loadSessionSnapshot('login');
        $I->amOnAdminPage('post-new.php?post_type=page');

        if (version_compare($wp_version, '6.3', 'ge')) {
            $I->switchToIFrame("editor-canvas");
            // https://maslosoft.com/blog/2017/03/03/codeception-acceptance-filling-in-contenteditable/
            $I->waitForElementVisible('.editor-post-title__input', 30);
            $I->click('.editor-post-title__input');
            $I->type('Example');
            $I->switchToIFrame();
        } else if (version_compare($wp_version, '6.2', 'ge')) {
            // https://maslosoft.com/blog/2017/03/03/codeception-acceptance-filling-in-contenteditable/
            $I->waitForElementVisible('.editor-post-title__input', 30);
            $I->click('.editor-post-title__input');
            $I->type('Example');
        } else {
            $I->fillField('.editor-post-title__input', 'Example');
        }

        $publish_text = 'Publish…';

        if (version_compare($wp_version, '5.5', 'ge')) {
            $publish_text = 'Publish';
        }

        $I->click($publish_text);

        if (version_compare($wp_version, '5', 'ge')) {
            $I->waitForElementVisible('.editor-post-publish-button', 30);
            $I->click('.editor-post-publish-button');
        }

        $I->waitForText('Page published.', 60);
        $I->amOnAdminPage('edit.php?post_type=page');
        $I->see('Example');
    }

    /**
     * @depends createPage
     */
    public function iCheckPageUrl(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPage('/example/');
        $I->see('Example');
    }

}
