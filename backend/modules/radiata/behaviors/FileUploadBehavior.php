<?php
namespace backend\modules\radiata\behaviors;

use Yii;
use yii\base\Exception;
use yii\base\InvalidCallException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * Class FileUploadBehavior
 *
 * @property ActiveRecord $owner
 */
class FileUploadBehavior extends \yii\base\Behavior
{
    const EVENT_AFTER_FILE_SAVE = 'afterFileSave';
    const DELETED_PREFIX = '_deleted';
    /** @var string Name of attribute which holds the attachment. */
    public $attribute = 'upload';
    /** @var string Name of attribute which holds the attachment (tabular mode). */
    public $tabularAttribute = '';
    /** @var string Name of source variable. */
    public $source = '';
    /** @var string Path template to use in storing files.5 */
    public $filePath = '@webroot/uploads/[[pk]].[[extension]]';
    /** @var string Where to store images. */
    public $fileUrl = '/uploads/[[pk]].[[extension]]';
    /**
     * @var string Attribute used to link owner model with it's parent
     * @deprecated Use attribute_xxx placeholder instead
     */
    public $parentRelationAttribute;
    /** @var \yii\web\UploadedFile */
    protected $file;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT  => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * Before validate event.
     */
    public function beforeValidate()
    {
        $source = Yii::$app->getRequest()->post($this->source, []);
        if(!empty($source) && !empty($source[$this->owner->{$this->tabularAttribute}])) {
            list($filename, $type, $data) = explode(';', $source[$this->owner->{$this->tabularAttribute}]);
            list(, $data) = explode(',', $data);
            $this->file = base64_decode($data);
            $this->owner->{$this->attribute} = $filename;
        } else {
            $attribute = $this->tabularAttribute ? '[' . $this->owner->{$this->tabularAttribute} . ']' . $this->attribute : $this->attribute;

            if($this->owner->{$this->attribute} instanceof UploadedFile) {
                $this->file = $this->owner->{$this->attribute};

                return;
            }
            $this->file = UploadedFile::getInstance($this->owner, $attribute);

            if(empty($this->file)) {
                $this->file = UploadedFile::getInstanceByName($this->attribute);
            }

            if($this->file instanceof UploadedFile) {
                $this->owner->{$this->attribute} = $this->file;
            }
        }
    }

    /**
     * Before save event.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave()
    {
        if($this->file instanceof UploadedFile) {
            if(!$this->owner->isNewRecord) {
                $this->cleanFiles();
            }
            $this->owner->{$this->attribute} = $this->file->baseName . '.' . $this->file->extension;
        } else { // Fix html forms bug, when we have empty file field
            if(!$this->owner->isNewRecord && empty($this->owner->{$this->attribute})) {
                if(empty($this->tabularAttribute) && Yii::$app->getRequest()->post($this->attribute . self::DELETED_PREFIX)) {
                    $this->cleanFiles();
                    $this->owner->{$this->attribute} = null;
                } else {
                    $this->owner->{$this->attribute} = ArrayHelper::getValue($this->owner->oldAttributes, $this->attribute, null);
                }
            } elseif(empty($this->tabularAttribute) && Yii::$app->getRequest()->post($this->attribute . self::DELETED_PREFIX)) {
                $this->cleanFiles();
                $this->owner->{$this->attribute} = null;
            }
        }
    }

    /**
     * Removes files associated with attribute
     */
    public function cleanFiles()
    {
        $path = $this->resolvePath($this->filePath);
        @unlink($path);
    }

    /**
     * Replaces all placeholders in path variable with corresponding values
     *
     * @param string $path
     * @return string
     */
    public function resolvePath($path)
    {
        $path = Yii::getAlias($path);

        $pi = pathinfo($this->owner->{$this->attribute});
        $fileName = ArrayHelper::getValue($pi, 'filename');
        $extension = strtolower(ArrayHelper::getValue($pi, 'extension'));

        return preg_replace_callback('|\[\[([\w\_/]+)\]\]|', function ($matches) use ($fileName, $extension) {
            $name = $matches[1];
            switch ($name) {
                case 'extension':
                    return $extension;
                case 'filename':
                    return $fileName;
                case 'basename':
                    return $fileName . '.' . $extension;
                case 'app_root':
                    return Yii::getAlias('@app');
                case 'web_root':
                    return Yii::getAlias('@webroot');
                case 'base_url':
                    return Yii::getAlias('@web');
                case 'model':
                    $r = new \ReflectionClass($this->owner->className());

                    return lcfirst($r->getShortName());
                case 'attribute':
                    return lcfirst($this->attribute);
                case 'id':
                case 'pk':
                    $pk = implode('_', $this->owner->getPrimaryKey(true));

                    return lcfirst($pk);
                case 'id_path':
                    return static::makeIdPath($this->owner->getPrimaryKey());
                case 'parent_id':
                    return $this->owner->{$this->parentRelationAttribute};
            }
            if(preg_match('|^attribute_(\w+)$|', $name, $am)) {
                $attribute = $am[1];

                return $this->owner->{$attribute};
            }

            return '[[' . $name . ']]';
        }, $path);
    }

    /**
     * @param integer $id
     * @return string
     */
    protected static function makeIdPath($id)
    {
        $id = is_array($id) ? implode('', $id) : $id;
        $result = [];
        $result[] = substr($id, 0, 2);
        if(strlen($id) > 2) {
            $result[] = substr($id, 2);
        }

        return implode('/', $result);
    }

    /**
     * After save event.
     */
    public function afterSave()
    {
        if($this->file instanceof UploadedFile || is_string($this->file)) {
            $path = $this->getUploadedFilePath($this->attribute);
            FileHelper::createDirectory(pathinfo($path, PATHINFO_DIRNAME), 0775, true);
            if($this->file instanceof UploadedFile) {
                if(!$this->file->saveAs($path, true)) {
                    throw new Exception('File saving error. ' . $path . ' / ' . $this->file->error);
                }
            } else {
                file_put_contents($path, $this->file);
            }
            $this->owner->trigger(static::EVENT_AFTER_FILE_SAVE);
        }
    }

    /**
     * Returns file path for attribute.
     *
     * @param string $attribute
     * @return string
     */
    public function getUploadedFilePath($attribute)
    {
        $behavior = static::getInstance($this->owner, $attribute);
        if(!$this->owner->{$attribute}) {
            return '';
        }

        return $behavior->resolvePath($behavior->filePath);
    }

    /**
     * Returns behavior instance for specified class and attribute
     *
     * @param ActiveRecord $model
     * @param string $attribute
     * @return static
     */
    public static function getInstance(ActiveRecord $model, $attribute)
    {
        foreach ($model->behaviors as $behavior) {
            if($behavior instanceof self && $behavior->attribute == $attribute) {
                return $behavior;
            }
        }

        throw new InvalidCallException('Missing behavior for attribute ' . VarDumper::dumpAsString($attribute));
    }

    /**
     * Before delete event.
     */
    public function beforeDelete()
    {
        $this->cleanFiles();
    }

    /**
     * Returns file url for the attribute.
     *
     * @param string $attribute
     * @return string|null
     */
    public function getUploadedFileUrl($attribute)
    {
        if(!$this->owner->{$attribute}) {
            return null;
        }

        $behavior = static::getInstance($this->owner, $attribute);

        return $behavior->resolvePath($behavior->fileUrl);
    }
}
