<?php

namespace App;

use App\User;
use Parsedown;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = [
        'title', 'body'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //mutator accesor??
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    //accesor para la prop que no exite pero ecesitamos
    public function getUrlAttribute()
    {
        //se cambia ID por slug
        // return route("questions.show", $this->id);
        return route("questions.show", $this->slug);
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->format("d/m/Y");
    }

    public function getStatusAttribute()
    {
        //que estatus de respuesta tiene
        if ($this->answers > 0) {
            if ($this->best_answer_id) {
                return "answered_accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        #devuelve el html body de la pregunta
        return Parsedown::instance()->text($this->body);
    }
}
