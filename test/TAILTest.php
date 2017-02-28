
<?php
class TAILTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;

	public function setUp()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
    }

    public function tearDown()
    {
        $this->webDriver->quit();
    }

    protected $url = 'http://www.tailopez.com/';

	public function a_testHomePage() {
        $this->webDriver->get($this->url);

        // The members <div> tag exists.
        $memberDiv = $this->webDriver->findElement(WebDriverBy::className("members"));
        $this->assertContains("Members", $memberDiv->getText(), "", true);

        // Make sure facebook likes number <div> and link exist.
        $fb_likes = $this->webDriver->findElement(WebDriverBy::className("fb_likes"));
        $this->assertNotNull($fb_likes->findElement(WebDriverBy::partialLinkText("Page Likes")));

        // Find the nav-bar
        $navBar = $this->webDriver->findElement(WebDriverBy::id("navbar"));
        $this->assertNotNull($navBar);

        // The 67 steps page link exists.
        $link67Steps = $navBar->findElement(WebDriverBy::partialLinkText("67 STEPS"));
        $this->assertNotNull($link67Steps);

        // The SOCIAL MEDIA AGENCY link
        //  "a[href*=\"7880\"]" select the <a> element with its 'href' attribute containing '7880'
        $agencyLink = $navBar->findElement(WebDriverBy::cssSelector("a[href*=\"7880\"]"));
        $this->assertEquals("SOCIAL MEDIA AGENCY",$agencyLink->getText());

    }

    public function b_testHelpPage()
    {
        $this->webDriver->get($this->url . 'help.php');

        // Who is Tai Lopez?
        // Got this unique selector from chrome dev tools.
        $elem = $this->webDriver->findElement(WebDriverBy::cssSelector("#leftside > div > div.row > div > div:nth-child(1) > div.panel-heading.panel-collapsed > h4"));
        $this->assertNotNull($elem);
        $this->assertEquals("Who is Tai Lopez?", $elem->getText());

        // The footerNav element exists.
        $elem = $this->webDriver->findElement(WebDriverBy::id("footerNav"));
        $this->assertNotNull($elem);

        $this->assertContains('Help', $this->webDriver->getTitle());
    }


    /**
     * This test is here to logout, so that the following tests can carry on.
     */
    public function testLogoutFromHelpPage() {
        $this->webDriver->get($this->url . 'help.php');

        $topMenu = $this->webDriver->findElement(WebDriverBy::cssSelector("#header > div.topPanel > div > div.topMenu"));

        $this->assertNotNull($topMenu);

        try {
            $logoutBtn = $topMenu->findElement(WebDriverBy::partialLinkText("Logout"));
        } catch (Exception $e) {
            return;
        }
        $logoutBtn->click();
    }

    public function testLogin() {

        $this->webDriver->get($this->url . 'member.php');

        $id_input = $this->webDriver->findElement(WebDriverBy::cssSelector( "#loginForm > div.form-text > input" ));
        $pass_input = $this->webDriver->findElement(WebDriverBy::cssSelector( "#loginForm > div.form-password > input" ));
        $id_input->sendKeys("yllfever@163.com");
        $pass_input->sendKeys("4yan7lxi");

        $loginSubmitBtn = $this->webDriver->findElement(WebDriverBy::cssSelector("#btn_login"));
        $loginSubmitBtn->click();

        $this->webDriver->wait(20, 1000)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector("a[href*=\"logout\"]"))
        );


    }

//    public function test67StepsPage()
//    {
//        $this->webDriver->get($this->url . 'flow.php?lp=FS-7506');
//        $elem = $this->webDriver->findElement(WebDriverBy::id("youtubevideo_iframe"));
//
//        $this->assertNotNull($elem);
//    }
//
//    public function testRealEstate() {
//
//        $this->webDriver->get($this->url . 'flow.php?lp=FS-7652&source=topnav');
//    }
//
//    public function testTravellingCEO() {
//        $this->webDriver->get($this->url . 'flow.php?lp=FS-4754&source=topnav');
//    }
//
//    public function testSocialMediaAgency() {
//        $this->webDriver->get($this->url . 'flow.php?id=FS-7880&source=topnav');
//    }


}
?>
