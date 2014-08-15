<?php

namespace Atwix\Bundle\MandrillBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;

/*
 * @author    Atwix Core Team
 * @copyright Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('atwix_mandrill');

        SettingsBuilder::append(
            $rootNode,
            [
                'api_key'  => ['value' => ''],
                'api_username'  => ['value' => ''],
                'enable_mandrill_integration' => ['value' => 0],
                'smtp_host' => ['value' => 'smtp.mandrillapp.com'],
                'smtp_port' => ['value' => '587']
            ]
        );

        return $treeBuilder;
    }
}
