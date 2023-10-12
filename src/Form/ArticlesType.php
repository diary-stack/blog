<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Title :",
                "attr" => [
                    "class" => "form-control mb-2"
                ]
            ])
            ->add("readTime", NumberType::class, [
                "label" => "readTime :",
                "attr" => [
                    "placeholder" => "Please enter a number",
                    "class" => "form-control mb-2"

                ]
            ])
            ->add('content', TextareaType::class, [
                "attr" => [
                    "class" => "form-control mb-2"
                ]
            ])
            ->add('image', FileType::class, [
                "mapped" => false,
                "required" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "1024k",
                        "mimeTypes" => [
                            "image/jpg",
                            "image/jpeg",
                            "image/png"
                        ],
                        "mimeTypesMessage" => "Invalid image extension"
                    ])
                ],
                "attr" => [
                    "class" => "form-control mb-2"
                ]
            ])
            ->add("newCategory", TextType::class, [
                "mapped" => false,
                "required" => false,
                "attr" => [
                    "class" => "form-control mb-2",
                    "placeholder" => "If new category write here else choise in category"
                ]

            ])
            ->add('category', EntityType::class, [
                "class" => Categories::class,
                "choice_label" => "name",
                "attr" => [
                    "class" => "form-control"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
