<?php
namespace backend\modules\radiata\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * GalleryBehavior
 *
 * @property ActiveRecord $owner
 */
class GalleryBehavior extends Behavior
{
    public $galleryClass;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * @return void
     */
    public function saveGallery()
    {
        $fileIndex = 0;
        $position = 1;
        $activeLocale = Yii::$app->getModule('radiata')->activeLanguage['locale'];
        $galleryDeletedItems = Yii::$app->request->post('GalleryDeletedItems', []);
        $formPrefix = (new \ReflectionClass($this->galleryClass))->getShortName();;
        $galleryClass = $this->galleryClass;

        $newsGalleryTranslation = Yii::$app->request->post($formPrefix . 'Translation', []);
        if(isset($newsGalleryTranslation[$activeLocale])) {
            foreach ($newsGalleryTranslation[$activeLocale] as $galId => $data) {
                if(in_array($galId, $galleryDeletedItems)) {
                    if($galId < 0) {
                        $fileIndex++;
                    }
                    continue;
                }

                if($galId < 0) {
                    $galleryModel = new $galleryClass();
                } else {
                    $galleryModel = $galleryClass::findOne($galId);
                }

                if(!$galleryModel) {
                    $this->owner->addError('gallery', Yii::t('b/radiata/gallery', 'Failed to load gallery'));

                    return false;
                }

                if($galId < 0) {
                    $galleryModel->gallery_id = $fileIndex++;
                } else {
                    $galleryModel->gallery_id = -1;
                }

                foreach (Yii::$app->request->post($formPrefix . 'Translation', []) as $language => $translateData) {
                    $translateData = $translateData[$galId];
                    foreach ($translateData as $attribute => $translation) {
                        if($translation) {
                            $galleryModel->translate($language)->$attribute = $translation;
                        }
                    }
                }

                $galleryModel->load($data);
                $galleryModel->position = $position++;
                $galleryModel->parent_id = $this->owner->id;

                if(!$galleryModel->save()) {
                    foreach ($galleryModel->getErrors() as $error) {
                        $this->owner->addError('gallery', $error[0]);
                    }

                    return false;
                }
            }
        }

        if($galleryDeletedItems) {
            foreach ($galleryDeletedItems as $galId) {
                if($galId > 0) {
                    $galleryModel = $galleryClass::findOne($galId);
                    if(!$galleryModel->delete()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function beforeDelete()
    {
        if(!empty($this->owner->gallery)) {
            foreach ($this->owner->gallery as $gallery) {
                $gallery->delete();
            }
        }
    }
}
