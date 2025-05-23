<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'gender',
        'name',
        'surname',
        'email',
        'password',
        'plan',
        'description',
        'status',
        'specialization',
        'years_of_experience',
        'clinic_name',
        'city',
        'district',
        'address',
        'consultation_price',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    public function getPermissionGroupIdsAttribute()
    {
        return $this->roles()->first()?->permissionGroups->pluck('id')->toArray();
    }

    public function sexuallyDiseases()
    {
        return $this->hasMany(SexuallyDisease::class);
    }

    public function womenDiseases()
    {
        return $this->hasMany(WomenDisease::class);
    }

    public function helpsAsPatient()
    {
        return $this->hasMany(Help::class, 'patient_id');
    }

    // Doktor olarak yardım ettiklerim
    public function helpsAsDoctor()
    {
        return $this->hasMany(Help::class, 'doctor_id');
    }
}
