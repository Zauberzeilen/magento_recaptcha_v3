<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @package   Zauberzeilen_ReCaptcha
 * @author    Björn Rennfanz <bjoern@zauberzeilen.de>
 * @copyright Copyright (c) 2019 Zauberzeilen - Ihr Webauftritt von A-Z (https://www.zauberzeilen.de)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.zauberzeilen.de
 */
class Zauberzeilen_ReCaptcha_Block_Head extends Mage_Core_Block_Template
{
    protected $_template = 'zauberzeilen/recaptcha/form.phtml';

    protected function _construct()
    {
        parent::_construct();
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        /* @var Zauberzeilen_ReCaptcha_Helper_Data $helper */
        $helper = Mage::helper('zauberzeilen_recaptcha');
        return $helper->getSiteKey();
    }
}
