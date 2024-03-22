<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $id_user
 * @property int|null $id_category
 * @property string $name
 * @property string $description
 * @property string|null $photo_before
 * @property string|null $photo_after
 * @property int|null $status
 * @property string $datetime
 * @property string|null $description_denied
 *
 * @property Category $category
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'imageFile'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['id_user', 'id_category', 'status'], 'integer'],
            ['id_user', 'default', 'value' => Yii::$app->user->identity->getId()],
            [['description', 'description_denied'], 'string'],
            [['datetime'], 'safe'],
            [['name', 'photo_before', 'photo_after'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'jpeg']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_category' => 'Id Category',
            'name' => 'Name',
            'description' => 'Description',
            'photo_before' => 'Photo Before',
            'photo_after' => 'Photo After',
            'status' => 'Status',
            'datetime' => 'Datetime',
            'description_denied' => 'Description Denied',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'id_category']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function upload()
    {
        $rand = Yii::$app->security->generateRandomString(8);
        if ($this->validate()) {
            $file_name = 'uploads/' . $this->imageFile->baseName . $rand . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($file_name);
            $this->photo_before = '../../web/' . $file_name;
            return true;
        } else {
            return false;
        }
    }
}
