<?php

namespace Custom\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    public function execute()
    {
        echo "Hello Magento Custom Module!";
    }
}
