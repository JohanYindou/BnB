<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
            ;
    }
    
    // Method that configurers the actions available for this entity (show, Edit, Delete)
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addFieldset('Identification')
            ->setIcon('user')->addCssClass('optional')
                ->setHelp('All information about the user'),
            ImageField::new('image', 'Profile picture')
            ->setBasePath('uploads/users/')
            ->setUploadDir('public/uploads/users/'),
            TextField::new('email', 'Email address'),
            TextField::new('firstname', 'First name'),
            TextField::new('lastname', 'Last name'),
            IntegerField::new('birthyear', 'Birth year'),
            TextField::new('job', 'Job')->hideOnIndex(),
            TextField::new('address', 'Address')->hideOnIndex(),
            TextField::new('city', 'City')->hideOnIndex(),
            TextField::new('country', 'Country')->hideOnIndex(),
        ];
    }
    
}
