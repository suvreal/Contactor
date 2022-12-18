<?php

// src/Form/Type/TaskType.php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ContactNew extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Name: ',
            ])
            ->add('secondname', TextType::class, [
                'required' => true,
                'label' => 'Secondname: ',
            ])
            ->add('phone', null, [
                'required' => false,
                'label' => 'Phone: ',
            ])
            ->add('email', TextType::class, [
                'required' => true,
                'label' => 'Email: ',
            ])
            ->add('note', null, [
                'required' => false,
                'label' => 'Note: ',
            ])

            ->add('save', SubmitType::class, ['label' => $options['label']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'require_Name' => true,
            'require_Secondname' => true,
            'require_Phone' => false,
            'require_Email' => true,
            'require_Note' => false,
            'label' => 'Create record',
        ]);

    }
}
