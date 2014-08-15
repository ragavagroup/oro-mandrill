<?php

namespace Atwix\Bundle\MandrillBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/*
 * @author    Atwix Core Team
 * @copyright Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MailerLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $configuration = $container->findDefinition('oro_email.direct_mailer');
        $ref = new Reference('atwix_mandrill.atwix_mailer');
        $configuration->replaceArgument(0, $ref);
    }
}
