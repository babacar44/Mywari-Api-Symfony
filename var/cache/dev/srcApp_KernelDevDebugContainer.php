<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerGU7jsdX\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerGU7jsdX/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerGU7jsdX.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerGU7jsdX\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerGU7jsdX\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'GU7jsdX',
    'container.build_id' => 'de88361a',
    'container.build_time' => 1565201796,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerGU7jsdX');
