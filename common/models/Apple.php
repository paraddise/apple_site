<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property int $color
 * @property int $created_at
 * @property int|null $fell_at
 * @property int $state
 * @property int $eaten
 */
class Apple extends \yii\db\ActiveRecord
{

    const COLORS = ['gray', 'green', 'red', 'blue', 'white', 'darkred'];

    const STATUS_CREATED = 1;

    const STATUS_FALLEN = 2;

    const STATUS_ROTTEN = 3;

    const STATUS_LABELS = [
        self::STATUS_CREATED => 'Выросло',
        self::STATUS_FALLEN => 'Упало',
        self::STATUS_ROTTEN  => 'Сгнило'
    ];



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fell_at', 'created_at'], 'integer', 'min' => 0, 'max' => time()],
            ['eaten', 'integer', 'max' => 100, 'min' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'created_at' => 'Выросло',
            'fell_at' => 'Упало',
            'state' => 'Состояние',
            'eaten' => 'Съедено',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AppleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleQuery(get_called_class());
    }

    public function getStateLabel()
    {
        return self::STATUS_LABELS[$this->state];
    }

    /**
     * Eats some piece of an apple, if the apple is eaten, then deletes the model, otherwise just saves it
     *
     * @param $procent
     * @return bool|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function eat($procent) :bool
    {
        $this->eaten  += $procent;
        if ($this->eaten >= 100) {
            return $this->delete();
        }
        return $this->update();
    }

    /**
     * Changes apple status to fallen
     *
     * @return bool
     */
    public function fall()
    {
        $this->state = self::STATUS_FALLEN;
        $this->fell_at = time();
        return $this->update();
    }

    public function rot()
    {
        $this->state = self::STATUS_ROTTEN;
        return $this->update();
    }

    public function canEat()
    {
        return $this->state === self::STATUS_FALLEN;
    }

    public function isRotten()
    {
        return $this->state === self::STATUS_ROTTEN;
    }

    public function isFallen()
    {
        return $this->state === self::STATUS_FALLEN;
    }

    public function isCreated()
    {
        return $this->state === self::STATUS_CREATED;
    }
}
