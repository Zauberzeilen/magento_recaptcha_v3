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
class Zauberzeilen_ReCaptcha_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CONFIG_PATH_ENABLE        = 'zauberzeilen/recaptcha/enable';
    const CONFIG_PATH_SITE_KEY      = 'zauberzeilen/recaptcha/site_key';
    const CONFIG_PATH_SECRET_KEY    = 'zauberzeilen/recaptcha/secret_key';
    const CONFIG_PATH_ENABLE_LOG    = 'zauberzeilen/recaptcha/enable_logging';
    const CONFIG_PATH_LOG_FILE      = 'zauberzeilen/recaptcha/logfile';

    /**
     * @return bool
     */
    public function isReCaptchaEnabled()
    {
        return Mage::getStoreConfigFlag(self::CONFIG_PATH_ENABLE);
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return Mage::getStoreConfig(self::CONFIG_PATH_SITE_KEY);
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return Mage::getStoreConfig(self::CONFIG_PATH_SECRET_KEY);
    }

    /**
     * @return bool
     */
    public function isLoggingEnabled()
    {
        return Mage::getStoreConfigFlag(self::CONFIG_PATH_ENABLE_LOG);
    }

    /**
     * @return string
     */
    public function getLogFilename()
    {
        return Mage::getStoreConfig(self::CONFIG_PATH_LOG_FILE);
    }

    /**
     * @param string $message
     * @param int $level
     */
    public function log($message, $level = Zend_Log::INFO)
    {
        if ($this->isLoggingEnabled()) {
            Mage::log($message, $level, $this->getLogFilename());
        }
    }
}
