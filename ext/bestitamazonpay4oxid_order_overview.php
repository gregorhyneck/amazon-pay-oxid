<?php

/**
 * Extension for OXID order_overview controller
 *
 * @author best it GmbH & Co. KG <info@bestit-online.de>
 */
class bestitAmazonPay4Oxid_order_overview extends bestitAmazonPay4Oxid_order_overview_parent
{
    /**
     * @var null|bestitAmazonPay4OxidContainer
     */
    protected $_oContainer = null;

    /**
     * Returns the active user object.
     *
     * @return bestitAmazonPay4OxidContainer
     * @throws oxSystemComponentException
     */
    protected function _getContainer()
    {
        if ($this->_oContainer === null) {
            $this->_oContainer = oxNew('bestitAmazonPay4OxidContainer');
        }

        return $this->_oContainer;
    }

    /**
     * Capture order after changing it to shipped
     * @throws Exception
     */
    public function sendorder()
    {
        parent::sendorder();
        /** @var oxOrder $oOrder */
        $oOrder = $this->_getContainer()->getObjectFactory()->createOxidObject('oxOrder');

        if ($oOrder->load($this->getEditObjectId()) === true
            && $oOrder->getFieldData('oxPaymentType') === 'bestitamazon'
        ) {
            $this->_getContainer()->getLogger()->debug(
                'Save amazon pay capture for order'
            );
            $this->_getContainer()->getClient()->saveCapture($oOrder);
        }
    }

}

