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
class Zauberzeilen_ReCaptcha_Model_Observer
{
    /**
     * call rules
     * @throws Mage_Core_Controller_Varien_Exception
     */
    public function controllerActionPredispatchCustomerAccountCreatepost()
    {
        /** @var Zauberzeilen_ReCaptcha_Helper_Data $helper */
        $helper = Mage::helper('zauberzeilen_recaptcha');
        if ($helper->isReCaptchaEnabled()) {
            $this->_verifySiteResponse();
        }
    }

    /**
     * @throws Mage_Core_Controller_Varien_Exception
     */
    public function controllerActionPredispatchBlockReviewForm()
    {
        /** @var Zauberzeilen_ReCaptcha_Helper_Data $helper */
        $helper = Mage::helper('zauberzeilen_recaptcha');
        if ($helper->isReCaptchaEnabled()) {
            $this->_verifySiteResponse();
        }
    }

    /**
     * @throws Mage_Core_Controller_Varien_Exception
     */
    public function controllerActionPredispatchCustomerAccountForgotPasswordPost()
    {
        /** @var Zauberzeilen_ReCaptcha_Helper_Data $helper */
        $helper = Mage::helper('zauberzeilen_recaptcha');
        if ($helper->isReCaptchaEnabled()) {
            $this->_verifySiteResponse();
        }
    }

    /**
     * @throws Mage_Core_Controller_Varien_Exception
     */
    public function controllerActionPredispatchContactsIndexPost()
    {
        /** @var Zauberzeilen_ReCaptcha_Helper_Data $helper */
        $helper = Mage::helper('zauberzeilen_recaptcha');
        if ($helper->isReCaptchaEnabled()) {
            $this->_verifySiteResponse();
        }
    }

    /**
     * @throws Mage_Core_Controller_Varien_Exception
     */
    public function controllerActionPredispatchNewsletterSubscriberNew()
    {
        /** @var Zauberzeilen_ReCaptcha_Helper_Data $helper */
        $helper = Mage::helper('zauberzeilen_recaptcha');
        if ($helper->isReCaptchaEnabled()) {
            $this->_verifySiteResponse();
        }
    }

    /**
     * validate honeypot field
     * @throws Mage_Core_Controller_Varien_Exception
     */
    protected function _verifySiteResponse()
    {
        /* @var Zauberzeilen_ReCaptcha_Helper_Data $helper */
        $helper = Mage::helper('zauberzeilen_recaptcha');

        $captcha_is_valid = FALSE;
        $captcha = Mage::app()->getRequest()->getPost('recaptcha-token');

        if (!empty($captcha)) {

            $client = $this->_getClient('https://www.google.com/recaptcha/api/siteverify');
    				$client->setParameterPost(array(
					      'secret'   => $helper->getSecretKey(),
        				'response' => $captcha,
          			'remoteip' => Mage::helper('core/http')->getRemoteAddr(false),
    				));

            $response = $client->request(Zend_Http_Client::POST);
            if($response->isSuccessful()) {
                $json = json_decode($response->getBody());
                if(!empty($json->success) && true == $json->success){
                    $captcha_is_valid = TRUE;
                }
            }
        }

        if (!$captcha_is_valid) {
            $helper->log('There was an error with the recaptcha code. Aborted.', Zend_Log::WARN);

            $e = new Mage_Core_Controller_Varien_Exception();
            $e->prepareForward('index', 'error', 'recaptcha');
            throw $e;
        }
    }

    /**
     * Returns the Zend Http Client
     *
     * @param string $url
     * @return Zend_Http_Client
     */
    public function _getClient($url)
    {
        return new Zend_Http_Client($url, array(
            'adapter'     => 'Zend_Http_Client_Adapter_Curl',
            'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false),
        ));
    }
}
