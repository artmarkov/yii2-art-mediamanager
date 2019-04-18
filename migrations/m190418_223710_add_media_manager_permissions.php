<?php

use artsoft\db\PermissionsMigration;

class m190418_223710_add_media_manager_permissions extends PermissionsMigration
{

    public function beforeUp()
    {
        $this->addPermissionsGroup('mediaManagerManagement', 'Media Manager Management');
    }

    public function afterDown()
    {
        $this->deletePermissionsGroup('mediaManagerManagement');
    }

    public function getPermissions()
    {
        return [
            'mediaManagerManagement' => [
                'links' => [
                    '/admin/mediamanager/*',
                ],
                'sortMediaManager' => [
                    'title' => 'Sort Media',
                    'links' => [
                       '/admin/mediamanager/default/sort-media',
                    ],                    
                ],                
                'addMediaManager' => [
                    'title' => 'Add Media',
                    'links' => [
                        '/admin/mediamanager/default/add-media',
                    ],
                    'roles' => [
                        self::ROLE_AUTHOR,
                    ],
                    'childs' => [
                        'sortMediaManager',
                    ],
                ],         
                'removeMediaManager' => [
                    'title' => 'Remove Media',
                    'links' => [
                        '/admin/mediamanager/default/remove-media',
                    ],     
                    'roles' => [
                        self::ROLE_MODERATOR,
                    ],
                ],
            ],
        ];
    }
}
