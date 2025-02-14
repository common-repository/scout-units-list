<?php

namespace ScoutUnitsList\Form;

use ScoutUnitsList\Form\Field\BooleanType;
use ScoutUnitsList\Form\Field\SelectType;
use ScoutUnitsList\Form\Field\StringMultilineType;
use ScoutUnitsList\Form\Field\StringType;
use ScoutUnitsList\Form\Field\SubmitType;
use ScoutUnitsList\Validator\PositionValidator;

/**
 * Position form
 */
class PositionForm extends Form
{
    /**
     * Set fields
     *
     * @param array $settings settings
     */
    protected function setFields(array $settings)
    {
        unset($settings);

        $this
            ->addField('type', SelectType::class, [
                'attr' => [
                    'style' => 'width:15em',
                ],
                'label' => __('Type', 'scout-units-list'),
                'options' => UnitAdminForm::getTypes(),
                'required' => true,
            ])
            ->addField('nameMale', StringType::class, [
                'attr' => [
                    'class' => 'regular-text',
                ],
                'label' => __('Name male', 'scout-units-list'),
                'required' => true,
            ])
            ->addField('nameFemale', StringType::class, [
                'attr' => [
                    'class' => 'regular-text',
                ],
                'label' => __('Name female', 'scout-units-list'),
                'required' => true,
            ])
            ->addField('description', StringType::class, [
                'attr' => [
                    'class' => 'regular-text',
                ],
                'label' => __('Description', 'scout-units-list'),
            ])
            ->addField('responsibilities', StringMultilineType::class, [
                'attr' => [
                    'class' => 'regular-text',
                    'cols' => 50,
                    'rows' => 5,
                ],
                'label' => __('Responsibilities', 'scout-units-list'),
            ])
            ->addField('leader', BooleanType::class, [
                'attr' => [
                    'style' => 'width:15em',
                ],
                'label' => __('Is unit leader', 'scout-units-list'),
            ])
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
        return PositionValidator::class;
    }
}
