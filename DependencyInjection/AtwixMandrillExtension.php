<?php

namespace Atwix\Bundle\MandrillBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader;

/*
 * @author    Atwix Core Team
 * @copyright Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class AtwixMandrillExtension extends Extension
{
    const TRANSPORT_SHORT_NAME = 'mandrill';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->prependExtensionConfig($this->getAlias(), array_intersect_key($config, array_flip(['settings'])));

        $authDecorator = new DefinitionDecorator('swiftmailer.transport.authhandler.abstract');
        $container
            ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.authhandler', self::TRANSPORT_SHORT_NAME), $authDecorator)
            ->addMethodCall('setAuthMode', array('login'));

        $bufferDecorator = new DefinitionDecorator('swiftmailer.transport.buffer.abstract');
        $container
            ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.buffer', self::TRANSPORT_SHORT_NAME), $bufferDecorator);

        $definitionDecorator = new DefinitionDecorator('swiftmailer.transport.smtp.abstract');
        $container
            ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.smtp', self::TRANSPORT_SHORT_NAME), $definitionDecorator)
            ->setArguments(array(
                new Reference(sprintf('swiftmailer.mailer.%s.transport.buffer', self::TRANSPORT_SHORT_NAME)),
                array(new Reference(sprintf('swiftmailer.mailer.%s.transport.authhandler', self::TRANSPORT_SHORT_NAME))),
                new Reference(sprintf('swiftmailer.mailer.%s.transport.eventdispatcher', 'default')),
            ))
            ->addMethodCall('setTimeout', array('%swiftmailer.mailer.' . 'default' . '.transport.smtp.timeout%'))
            ->addMethodCall('setSourceIp', array('%swiftmailer.mailer.' . 'default' . '.transport.smtp.source_ip%'));
        $container->setAlias(sprintf('swiftmailer.mailer.%s.transport', self::TRANSPORT_SHORT_NAME), sprintf('swiftmailer.mailer.%s.transport.%s', self::TRANSPORT_SHORT_NAME, 'smtp'));
    }
}
