<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Message;


class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
           $builder->add('author', TextType::class, ['label' => 'Ваше имя:'])
                   ->add('email', EmailType::class, ['label' => 'Адрес вашей электронной почты:'])
                   ->add('phone', TextType::class, [
                       'label' => 'Номер телефона (Опционально):',
                        'required' => false,
                       ])
                   ->add('text', TextareaType::class, ['label' => 'Сообщение:'])
                   ->add('user', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }

}
