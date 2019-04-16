<?php

use artsoft\db\SourceMessagesMigration;

class m190416_083559_i18n_art_media_source extends SourceMessagesMigration
{
     public function getCategory()
    {
        return 'art/media';
    }

    public function getMessages()
    {
        return [
            'To keep order' => 1,
            'Photo not found.' => 1,
            'Your photo has been removed.' => 1,
            'Sort data saved.' => 1,
        ];
    }
}