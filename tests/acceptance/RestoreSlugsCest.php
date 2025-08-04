<?php

class RestoreSlugsCest
{

    public function iDoSetup(AcceptanceTester $I)
    {
        $I->importSqlDumpFile(codecept_data_dir('dump.sql'));

        $I->cli(['option', 'update', 'home', $_ENV['TEST_SITE_WP_URL']]);
        $I->cli(['option', 'update', 'siteurl', $_ENV['TEST_SITE_WP_URL']]);
        $I->cli(['option', 'update', 'admin_email_lifespan', '2147483646']);

        $I->cli(['core', 'update-db']);

        try {
            $I->cli(['config', 'set', 'AUTOMATIC_UPDATER_DISABLED', 'true', '--raw']);
        } catch (Throwable $exception) {

        }

        $I->cli(['plugin', 'install', 'disable-welcome-messages-and-tips']);
        $I->cli(['plugin', 'activate', 'disable-welcome-messages-and-tips']);

        $I->cli(['theme', 'install', 'twentynineteen']);
        $I->cli(['theme', 'activate', 'twentynineteen']);
    }

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

    public function iGoToMediaPage(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPage('/example/');
        $I->see('example');
    }

    public function iActivatePlugin(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPluginsPage();
        $I->activatePlugin('disable-media-pages');
    }

    public function iGoToMediaPageAgain(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPage('/example/');
        $I->dontSee('example');
        $I->see('That page can’t be found.');
    }

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

    public function iCheckSlugIsUuid(AcceptanceTester $I)
    {
        $query = new WP_Query([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 1,
        ]);

        $post = $query->posts[0];

        \PHPUnit\Framework\Assert::assertMatchesRegularExpression(
            '/[0-9a-f]{8}[0-9a-f]{4}4[0-9a-f]{3}[89ab][0-9a-f]{3}[0-9a-f]{12}/', $post->post_name
        );
    }

    public function iRestoreAttachmentSlugs(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnAdminPage('options-general.php?page=disable-media-pages');
        $I->waitForText('Restore media slugs');
        $I->click('Restore media slugs');
        $I->waitForText('Start restoring process');
        $I->click('Start restoring process');
        $I->waitForText('All media slugs restored');
    }

    public function iDeactivatePlugin(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPluginsPage();
        $I->deactivatePlugin('disable-media-pages');
    }

    public function iGoToMediaPageOnceMore(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPage('/example/');
        $I->see('example');
    }

}
