<?php
require '/var/www/html/app/bootstrap.php';

$bootstrap = Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$om = $bootstrap->getObjectManager();
Magento\Framework\App\ObjectManager::setInstance($om);

$state = $om->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

// Create Slider
$slider = $om->create('Mageplaza\BannerSlider\Model\Slider');
$slider->setData([
    'name'               => 'Homepage Hero',
    'status'             => 1,
    'store_ids'          => '0',
    'customer_group_ids' => '0,1,2,3',
    'priority'           => 0,
    'effect'             => 'slide',
    'autoWidth'          => 0,
    'autoHeight'         => 0,
    'design'             => 0,
    'loop'               => 1,
    'lazyLoad'           => 1,
    'autoplay'           => 1,
    'autoplayTimeout'    => 4000,
    'nav'                => 1,
    'dots'               => 1,
    'is_responsive'      => 1,
]);
$slider->save();
$sliderId = $slider->getId();
echo "Slider created ID: $sliderId\n";

// Banner HTML content
$banner1Html = '<div style="background:linear-gradient(135deg,#e94560,#0f3460);color:#fff;text-align:center;padding:80px 20px"><h2 style="font-size:2.5rem;margin:0 0 16px">Summer Sale - Up to 50% Off</h2><p style="opacity:.9;font-size:1.1rem">Shop our biggest deals this season</p><a href="/sale" style="display:inline-block;margin-top:24px;padding:14px 36px;background:#fff;color:#e94560;border-radius:30px;font-weight:700;text-decoration:none">Shop Now</a></div>';
$banner2Html = '<div style="background:linear-gradient(135deg,#533483,#1a1a2e);color:#fff;text-align:center;padding:80px 20px"><h2 style="font-size:2.5rem;margin:0 0 16px">New Arrivals</h2><p style="opacity:.9;font-size:1.1rem">Discover the latest products in our store</p><a href="/new" style="display:inline-block;margin-top:24px;padding:14px 36px;background:#fff;color:#533483;border-radius:30px;font-weight:700;text-decoration:none">Explore Now</a></div>';

// Create Banner 1
$b1 = $om->create('Mageplaza\BannerSlider\Model\Banner');
$b1->setData([
    'name'       => 'Summer Sale',
    'status'     => 1,
    'type'       => 1,
    'content'    => $banner1Html,
    'url_banner' => 'http://localhost:8080',
    'title'      => 'Summer Sale',
    'newtab'     => 1,
]);
$b1->save();
echo "Banner 1 created ID: " . $b1->getId() . "\n";

// Create Banner 2
$b2 = $om->create('Mageplaza\BannerSlider\Model\Banner');
$b2->setData([
    'name'       => 'New Arrivals',
    'status'     => 1,
    'type'       => 1,
    'content'    => $banner2Html,
    'url_banner' => 'http://localhost:8080',
    'title'      => 'New Arrivals',
    'newtab'     => 1,
]);
$b2->save();
echo "Banner 2 created ID: " . $b2->getId() . "\n";

// Link banners to slider
$resource = $om->get('Magento\Framework\App\ResourceConnection');
$conn = $resource->getConnection();
$conn->insert('mageplaza_bannerslider_banner_slider', ['slider_id' => $sliderId, 'banner_id' => $b1->getId(), 'position' => 0]);
$conn->insert('mageplaza_bannerslider_banner_slider', ['slider_id' => $sliderId, 'banner_id' => $b2->getId(), 'position' => 1]);

echo "Done. Slider ID $sliderId now has 2 banners.\n";
