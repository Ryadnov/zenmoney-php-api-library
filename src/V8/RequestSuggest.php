<?php

namespace Ryadnov\ZenMoney\Api\V8;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RequestSuggest
 *
 * @package Ryadnov\ZenMoney\Api\V8
 */
class RequestSuggest extends Request
{
    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'url' => 'https://api.zenmoney.ru/v8/suggest/',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureRequestParams(OptionsResolver $resolver)
    {
        parent::configureRequestParams($resolver);

        $resolver->setDefined([
            // for array
            '0',
            // transaction fields
            'id',
            'changed',
            'created',
            'user',
            'deleted',
            'incomeInstrument',
            'incomeAccount',
            'income',
            'outcomeInstrument',
            'outcomeAccount',
            'outcome',
            'tag',
            'merchant',
            'payee',
            'originalPayee',
            'comment',
            'date',
            'mcc',
            'reminderMarker',
            'opIncome',
            'opIncomeInstrument',
            'opOutcome',
            'opOutcomeInstrument',
            'latitude',
            'longitude',
        ]);
    }
}
