<?php

namespace ScoutUnitsList\Form;

use ScoutUnitsList\Form\Field\IntegerAutocompleteType;
use ScoutUnitsList\Form\Field\SelectType;
use ScoutUnitsList\Form\Field\StringHiddenType;
use ScoutUnitsList\Form\Field\StringType;
use ScoutUnitsList\Form\Field\SubmitType;
use ScoutUnitsList\Model\Attachment;
use ScoutUnitsList\Model\Config;
use ScoutUnitsList\Model\User;
use ScoutUnitsList\Validator\PersonValidator;

/**
 * Person form
 */
class PersonForm extends Form
{
    /**
     * Set fields
     *
     * @param array $settings settings
     */
    protected function setFields(array $settings)
    {
        /** @var Config $config */
        $config = $settings['config'];

        $this
            ->addField('userId', IntegerAutocompleteType::class, [
                'action' => 'sul_users',
                'attr' => [
                    'class' => 'regular-text',
                ],
                'label' => __('User', 'scout-units-list'),
                'required' => true,
                'valueLabel' => is_object($settings['user']) && $settings['user'] instanceof User ?
                    $settings['user']->getNiceName() . ' (' . $settings['user']->getLogin() . ')' : null,
            ])
            ->addField('positionId', SelectType::class, [
                'attr' => [
                    'style' => 'width:15em',
                ],
                'label' => __('Position', 'scout-units-list'),
                'options' => $settings['positions'],
                'required' => true,
            ]);
        if ($config->areOrderCategoriesDefined()) {
            $this
                ->addField('orderId', IntegerAutocompleteType::class, [
                    'action' => 'sul_orders',
                    'attr' => [
                        'class' => 'regular-text',
                    ],
                    'label' => __('Order number', 'scout-units-list'),
                    'required' => true,
                    'valueField' => 'input[name="orderNo"]',
                    'valueLabel' => array_key_exists('order', $settings) && is_object($settings['order']) &&
                        $settings['order'] instanceof Attachment ? $settings['order']->getTitle() : null,
                ])
                ->addField('orderNo', StringHiddenType::class, [
                    'required' => true,
                ]);
        } else {
            $this
                ->addField('orderNo', StringType::class, [
                    'attr' => [
                        'class' => 'regular-text',
                        'pattern' => $config->getOrderNoFormat(),
                        'placeholder' => $config->getOrderNoPlaceholder(),
                    ],
                    'label' => __('Order number', 'scout-units-list'),
                    'required' => true,
                ]);
        }
        $this
            ->addField('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'button button-primary',
                ],
                'label' => __('Save', 'scout-units-list'),
            ])
        ;
    }

    /**
     * Get validator class
     *
     * @return string
     */
    protected function getValidatorClass()
    {
        return PersonValidator::class;
    }
}
