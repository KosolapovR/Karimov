<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\Ad;

class NewAdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Заголовок', 'attr' => ['placeholder' => 'Ваш товар']])
            ->add('price', TextType::class, ['label' => 'Цена'])
            ->add('description', TextareaType::class, ['label' => 'Описание', 'attr' => ['placeholder' => 'Описание товара']])
            ->add('photos', FileType::class, [
                'label' => 'Фото',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Пожалуйста загрузите подходящее изображение',
                    ])
                ],
                ])
            ->add('location', TextType::class, ['label' => 'Месторасположение'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
