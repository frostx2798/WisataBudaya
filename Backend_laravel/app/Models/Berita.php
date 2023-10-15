<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Mutator\GenUid2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Berita extends Model
{
    use HasFactory, GenUid2;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'judul', 'slug', 'user_id', 'isi', 'image'
    ];
 
    /**
     * user
     *
     * @return void
     */
    public function getImageAttribute($image)
    {
        return url('storage/beritas/' . $image);
    }
}
