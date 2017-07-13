<?php

namespace CtEye\InvoiceBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Plugin for the Contao Manager.
 *
 * @author Tom Ganske <https://github.com/tomganske>
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(CtEyeInvoiceBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['invoice']),
        ];
    }
}
