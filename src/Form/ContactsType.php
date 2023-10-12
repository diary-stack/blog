<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Full name"
                ],
                "row_attr" => [
                    "class" => "mb-3"
                ]
            ])
            ->add('email', EmailType::class, [
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "your@company.com"
                ],
                "row_attr" => [
                    "class" => "mb-3"
                ]
            ])
            ->add('subject', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "row_attr" => [
                    "class" => "mb-3"
                ]
            ])
            ->add('massage', TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "row_attr" => [
                    "class" => "mb-3"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
