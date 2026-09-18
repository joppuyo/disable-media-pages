<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    /**
     * Activate a plugin on the plugins page by clicking its "Activate" row action and wait for the page to reload.
     *
     * wp-browser's activatePlugin() looks for the bulk action checkbox with an XPath that WordPress 7.1 broke
     * (the checkbox cell changed from th to td). Clicking the row action link by id works on every version.
     */
    public function activatePluginByLink(string $pluginSlug): void
    {
        $webDriver = $this->getModule('WPWebDriver');
        $webDriver->click("#activate-$pluginSlug");
        $webDriver->waitForElement("table.plugins tr[data-slug='$pluginSlug'].active", 30);
    }

    /**
     * Deactivate a plugin on the plugins page by clicking its "Deactivate" row action and wait for the page to reload.
     */
    public function deactivatePluginByLink(string $pluginSlug): void
    {
        $webDriver = $this->getModule('WPWebDriver');
        $webDriver->click("#deactivate-$pluginSlug");
        $webDriver->waitForElement("table.plugins tr[data-slug='$pluginSlug'].inactive", 30);
    }
}
