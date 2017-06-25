<?php

namespace Ryadnov\ZenMoney\Api\V8;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RequestDiff
 *
 * @package Ryadnov\ZenMoney\Api\V8
 */
class RequestDiff extends Request
{
    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'url' => 'https://api.zenmoney.ru/v8/diff/',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureRequestParams(OptionsResolver $resolver)
    {
        parent::configureRequestParams($resolver);

        $resolver->setDefaults([
            'currentClientTimestamp' => time(),
            'serverTimestamp'        => time() - 10 * 60,
        ]);

        $resolver->setDefined([
            'forceFetch',
            'instrument',
            'company',
            'user',
            'account',
            'tag',
            'merchant',
            'budget',
            'reminder',
            'reminderMarker',
            'transaction',
            'deletion',
        ]);
    }
}
