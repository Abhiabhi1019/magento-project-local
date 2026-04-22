<?php
namespace Abhi\CustomFeature\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\PageRepository;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class CreateCmsPage implements DataPatchInterface
{
    private $moduleDataSetup;
    private $pageFactory;
    private $pageRepository;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        PageRepository $pageRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        // Create the CMS page
        $page = $this->pageFactory->create();
        $page->setTitle('Custom Promotional Page')
             ->setIdentifier('custom-promo-page')
             ->setIsActive(true)
             ->setPageLayout('1column')
             ->setStores([0]) // Available on all store views
             ->setContent('<div class="promo-banner">{{block class="Mageplaza\BannerSlider\Block\Widget" slider_id="1"}}</div><p>Welcome to our custom promotional page! Check out the banners above.</p>');

        $this->pageRepository->save($page);

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
