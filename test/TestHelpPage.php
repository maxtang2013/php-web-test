
<?php
class HelpPageTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;

	public function setUp()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
    }

    protected $url = 'http://www.tailopez.com/';

    public function testHelpPage()
    {
        $this->webDriver->get($this->url . 'help.php');
        // checking that page title contains word 'GitHub'
        $elem = $this->webDriver->findElement(WebDriverBy::id("footerNav"));

        $this->assertNotNull($elem);

        $this->assertContains('Help', $this->webDriver->getTitle());
    }


    public function test67StepsPage()
    {
        $this->webDriver->get($this->url . 'flow.php?lp=FS-7506');
        // checking that page title contains word 'GitHub'
        $elem = $this->webDriver->findElement(WebDriverBy::id("youtubevideo_iframe"));

        $this->assertNotNull($elem);
    }

}
?>
