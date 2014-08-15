<?php

namespace Atwix\Bundle\MandrillBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Atwix\Bundle\MandrillBundle\DependencyInjection\Compiler\MailerLoaderPass;

/*
 * @author    Atwix Core Team
 * @copyright Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class AtwixMandrillBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MailerLoaderPass());
    }
}
