<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace WSite\Menu\Ui\Component\Form\Element;

/**
 * Class Input
 */
class Tree extends \Magento\Ui\Component\Form\Element\AbstractElement
{
    const NAME = 'tree';

    /**
     * Get component name
     *
     * @return string
     */
    public function getComponentName()
    {
        return static::NAME;
    }
}
