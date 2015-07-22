<?php

namespace Jag\Common\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    /**
     * @type array
     */
    protected $fillable = [ 'type', 'key', 'value' ];

    /**
     * @type array
     */
    protected $hidden = [ 'updated_at', 'created_at' ];

    /**
     * @param $value
     *
     * @return null|string
     */
    public function setValueAttribute($value)
    {
        if (is_null($value)) {
            return $this->whereId($this->id)->delete();
        } else {
            return $this->attributes['value'] = serialize($value);
        }
    }

    /**
     * @param $value
     *
     * @return mixed|null
     */
    public function getValueAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        $value = unserialize($value);
        if (is_array(json_decode($value))) {
            return json_decode($value);
        }

        return $value;
    }

    /**
     * @param      $query
     * @param      $key
     * @param null $default
     *
     * @throws \Exception
     */
    public function scopeGetValue($query, $key, $default = null)
    {
        if (! is_null($default)) {
            $find = $query->whereKey($key);
            if (! $find->exists()) {
                return $default;
            } else {
                return $find->first();
            }
        } else {
            throw new \Exception('No option exists, ' . $key);
        }
    }

    /**
     * Option::set('key', 'value', 'type[config]')
     *
     * @param         $query
     * @param         $key   Option key
     * @param         $value Option value
     * @param  string $type  Type of the option
     *
     * @return static
     */
    public function scopeSet($query, $key, $value)
    {
        return $this->updateOrCreate(
            [
                'type' => 'config',
                'key'  => $key,
            ],
            [
                'key'   => $key,
                'value' => $value
            ]);
    }

}
