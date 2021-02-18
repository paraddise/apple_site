<?php


namespace common\models;

use yii\base\Model;

class CreateAppleForm extends Model
{

    public $eaten;
    public $created_at;
    public $color;
    public $state;

    protected $_apple;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['eaten', 'default', 'value' => 0],
            ['eaten', 'integer', 'max' => 100, 'min' => 0],
            ['state', 'default', 'value' => Apple::STATUS_CREATED],
            ['created_at', 'default', 'value' => fn($model, $attributes) => rand(0, time())],
            ['color', 'default', 'value' => function ($model, $attributes) {
                return Apple::COLORS[ (rand(0, count(Apple::COLORS)-1)) ];
            }],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $this->_apple = new Apple();
        $this->_apple->eaten = $this->eaten;
        $this->_apple->created_at = $this->created_at;
        $this->_apple->state = $this->state;
        $this->_apple->color = $this->color;
        return $this->_apple->save();

    }

    public function getApple()
    {
        return $this->_apple;
    }
}