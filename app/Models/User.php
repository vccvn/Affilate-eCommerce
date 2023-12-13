<?php

namespace App\Models;

use Gomee\Models\CommonMethods;
use Gomee\Models\ModelEventMethods;
use Gomee\Models\ModelFileMethods;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ModelEventMethods, ModelFileMethods, CommonMethods;
    const MODEL_TYPE = 'default';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'username',
        'email',
        'password',
        'phone_number',
        'type', 
        'level', 
        'avatar', 
        'status',
        'secret_id',
        'google2fa_secret',
        'trashed_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
        'secret_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $role_levels = [];

    protected $_meta = [];
    protected $_roles = [];
    protected $isCheckRoles = false;
    /**
     * các giá trị mặc định
     *
     * @var array
     */
    protected $defaultValues = [];

    
    public function __getModelType__()
    {
        return static::MODEL_TYPE;
    }


    /**
     * lấy về giá trị mặc định khi muốn fill để create data
     *
     * @return array<string, mixed>
     */
    public function getDefaultValues()
    {
        return $this->defaultValues;
    }
    
    
    public function setGoogle2faSecretAttribute($value)
    {
        // $this->attributes['google2fa_secret'] = encrypt($value);
        $this->attributes['google2fa_secret'] = $value;
    }

    public function getGoogle2faSecretAttribute($value)
    {
        // return $value ? decrypt($value) : null;
        return $value ? $value : null;
    }



    /**
     * ket noi voi bang metadata
     * @return queryBuilder
     */
    public function metadatas()
    {
        return $this->hasMany(Metadata::class, 'ref_id', 'id')->where('ref', 'user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'author_id', 'id');
    }

    

    public function userRole()
    {
        return $this->hasMany(PermissionUserRole::class, 'user_id', 'id');
    }

    public function getUserRoles()
    {
        if($this->isCheckRoles) return $this->_roles;
        $data = [];
        if($this->userRole && count($this->userRole)){
            foreach ($this->userRole as $r) {
                $data[] = $r->role_id;
            }
        }
        $this->isCheckRoles = true;
        $this->_roles = $data;
        return $this->_roles;
    }

    public function getRoleIdListAttribute()
    {
        return $this->getUserRoles();
    }

    /**
     * lấy ra danh sách role
     */
    public function roles()
    {
        return $this->userRole()
            ->join('permission_roles', 'permission_roles.id', '=', 'permission_user_roles.role_id')
            ->select('permission_roles.id', 'permission_roles.name', 'permission_roles.level', 'permission_roles.description')
            ->orderBy('permission_roles.level', 'DESC');
    }

    public function roleLevels()
    {
        if ($this->role_levels) return $this->role_levels;
        $data = ['admin' => [], 'mod' => [], 'access' => [], 'list' => [], 'roles' => []];
        $level = [3 => 'admin', 2 => 'mod', 1 => 'access'];
        if (count($this->roles)) {
            foreach ($this->roles as $role) {
                $data[$level[$role->level]][] = $role->id;
                $data['list'][] = $role->id;
                $data['roles'][$role->id] = $role;
            }
        }
        $this->role_levels = $data;
        return $data;
    }

    public function inGroup($level = 'mod')
    {
        if (!in_array($lv = strtolower($level), ['admin', 'mod'])) return false;
        $data = $this->roleLevels();
        return count($data[$lv]);
    }

    public function hasRoles($roles = [])
    {
        if (!is_array($roles) || !count($roles)) return false;
        $data = $this->roleLevels();
        foreach ($roles as $role_id) {
            if (!in_array($role_id, $data['list'])) return false;
        }
        return true;
    }

    public function hasOnly($roles = [])
    {
        if (!is_array($roles) || !count($roles)) return false;
        $data = $this->roleLevels();
        if (count($roles) != count($data['list'])) return false;
        foreach ($roles as $role_id) {
            if (!in_array($role_id, $data['list'])) return false;
        }
        return true;
    }


    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getAvatar($urlencode=false)
    {

        if($this->avatar){
            $avatar = content_path('users/' . $this->secret_id .'/avatar/' . $this->avatar);

        }else{
            $avatar = 'static/images/default/avatar.png';
        }
        $url = url($avatar);
        if($urlencode) return urlencode($url);
        return $url;
    }

    /**
     * xoa avatar
     */
    public function deleteAvatar()
    {
        if ($this->avatar && file_exists($path = public_path(content_path('users/' . $this->secret_id .'/avatar/' . $this->avatar)))) {
            unlink($path);
        }
    }



    /**
     * ham xóa file cũ
     * @param int $id
     *
     * @return boolean
     */
    public function deleteAttachFile()
    {
        return $this->deleteAvatar();
    }


    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename()
    {
        return $this->avatar;
    }
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $a = $this->getAvatar();
        $data = $this->toArray();
        if ($this->avatar) $data['avatar'] = $a;

        return $data;
    }



    public function __get_table()
    {
        return 'users';
    }



    public function canDelete()
    {
        if($this->type == 'admin') return false;
        return true;
    }



    /**
     * kiểm tra có thể xóa hay không
     * @return boolean
     */
    public function canMoveToTrash()
    {
        if($this->type == 'admin') return false;
        return true;
    }

    public function beforeDelete()
    {
        $this->metadatas()->delete();
        // $this->userRole()->delete();
        $this->deleteAvatar();
        
    }


    // ham get username khong dung hang

    public function getUsername($str = null, $id = null)
    {
        if (!$str && !isset($this->id) && !$id) return null;
        elseif ($id) {
            if ($u = self::find($id)) {
                if (!$str) $str = $u->name;
            }
        } elseif (isset($this->id) && $this->id) {
            $id = $this->id;
        }
        $aslug = str_slug($str, '');
        $slug = null;
        $i = 1;
        $c = '';
        $s = true;
        do {
            $sl = $aslug . $c;
            if ($item = self::where('username', $sl)->first()) {
                if ($id && $item->id == $id) {
                    $slug = $sl;
                    $s = false;
                }
                $c = '-' . $i;
            } else {
                $slug = $sl;
                $s = false;
            }

            $i++;
        } while ($s);

        return $slug;
    }

}
