<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'easyadmin.filter.type.text' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/form/FormTypeInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/form/AbstractType.php';
include_once $this->targetDirs[3].'/vendor/easycorp/easyadmin-bundle/src/Form/Filter/Type/TextFilterType.php';

return $this->privates['easyadmin.filter.type.text'] = new \EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\TextFilterType();
