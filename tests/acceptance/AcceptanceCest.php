<?php 

class AcceptanceCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->cli(['core', 'update-db']);
        $I->cli(['plugin', 'install', 'disable-welcome-messages-and-tips', '--activate']);
        codecept_debug(error_reporting());
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
        $I->amOnPluginsPage();
        $I->click(
            'a[href="options-general.php?page=disable-media-pages"]'
        );
        $I->waitForText('Mangle existing media slugs');
        $I->click('Start mangling process');
        $I->waitForText('All media slugs mangled');
    }

    public function createPage(AcceptanceTester $I)
    {
        global $wp_version;
        $I->loadSessionSnapshot('login');
        $I->amOnAdminPage('post-new.php?post_type=page');
        $I->fillField(
            version_compare($wp_version, '5.0', 'ge')
                ? 'Add title'
                : 'Enter title here',
            'Example'
        );

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

    public function iCheckPageUrl(AcceptanceTester $I)
    {
        $I->loadSessionSnapshot('login');
        $I->amOnPage('/example/');
        $I->see('Example');
    }

}
