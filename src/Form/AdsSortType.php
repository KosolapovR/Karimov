<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;




class AdsSortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
           $builder->add('pattern', TextType::class, [
                        'label' => 'Ваше поиск:', 
                        'required' => false
                        ])
                   ->add('onlyImg', CheckboxType::class, [
                        'label' => 'Объявления с фотографиями',
                        'required' => false
                        ])
                   ->add('min_price', TextType::class, ['label' => 'Min:'])
                   ->add('max_price', TextType::class, ['label' => 'Max:'])
                   ->getForm()
                ;
    }
}
