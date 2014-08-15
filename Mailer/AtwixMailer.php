<?php

namespace Atwix\Bundle\MandrillBundle\Mailer;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oro\Bundle\EmailBundle\Mailer\DirectMailer;

/*
 * @author    Atwix Core Team
 * @copyright Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class AtwixMailer extends DirectMailer
{
    public function __construct(\Swift_Transport_EsmtpTransport $transport, ConfigManager $config, ContainerInterface $container)
    {
        $mandrillApiKey = $config->get('atwix_mandrill.api_key');
        $mandrillApiUsername = $config->get('atwix_mandrill.api_username');
        if ($config->get('atwix_mandrill.enable_mandrill_integration') &&
            !empty($mandrillApiKey) && !empty($mandrillApiUsername)) {

            $handlers = $transport->getExtensionHandlers();
            /** @var \Swift_Transport_Esmtp_AuthHandler $handler */
            $handler = reset($handlers);
            $transport->setHost($config->get('atwix_mandrill.smtp_host'));
            $transport->setPort($config->get('atwix_mandrill.smtp_port'));
            $handler->setPassword($mandrillApiKey);
            $handler->setUsername($mandrillApiUsername);
            \Swift_Mailer::__construct($transport);
        } else {
            $mailer = $container->get('mailer');
            parent::__construct($mailer, $container);
        }
    }
}