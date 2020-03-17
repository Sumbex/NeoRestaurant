<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected function login($request)
    {
        try {
            $limpiar = $this->limpiarRut($request->rut);
            $validarRut = $this->validarRut($limpiar);
            if ($validarRut == true) {
                $user = User::where('rut', $limpiar)->first();
                if (!is_null($user)) {
                    if (Hash::check($request->password, $user->password)) {
                        if (!$token = JWTAuth::fromUser($user)) {
                            return response([
                                'status' => 'error',
                                'error' => 'invalid.credentials',
                                'msg' => 'Invalid Credentials.'
                            ], 400);
                        }
                        return response([
                            'status' => 'success',
                            'token' => $token,
                        ])
                            ->header('Authorization', $token);
                    } else {
                        return response(['status' => 'failed', 'mensaje' => 'La contrasena ingresada no es valida.']);
                    }
                } else {
                    return response(['status' => 'failed', 'mensaje' => 'El usuario que estas ingresando no existe.']);
                }
            } else {
                return ['estado' => 'failed', 'mensaje' => 'El rut ingresado no es valido.'];
            }
        } catch (\ErrorException $e) {
            return ['status' => 'failed', 'Se ha producido un error, verifique si el rut es correcto o existe en la base de datos'];
        }
    }

    protected function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    protected function validarRut($rut)
    {
        try {
            $rut = preg_replace('/[^k0-9]/i', '', $rut);
            $dv  = substr($rut, -1);
            $numero = substr($rut, 0, strlen($rut) - 1);
            $i = 2;
            $suma = 0;
            foreach (array_reverse(str_split($numero)) as $v) {
                if ($i == 8)
                    $i = 2;
                $suma += $v * $i;
                ++$i;
            }
            $dvr = 11 - ($suma % 11);

            if ($dvr == 11)
                $dvr = 0;
            if ($dvr == 10)
                $dvr = 'K';
            if ($dvr == strtoupper($dv))
                return true;
            else
                return false;
        } catch (\Exception $e) {
            return ['status' => 'failed', 'Se ha producido un error, verifique si el rut es correcto o existe en la base de datos'];
        }
    }

    protected function limpiarRut($rut)
    {
        $rut = str_replace('á', 'a', $rut);
        $rut = str_replace('Á', 'A', $rut);
        $rut = str_replace('é', 'e', $rut);
        $rut = str_replace('É', 'E', $rut);
        $rut = str_replace('í', 'i', $rut);
        $rut = str_replace('Í', 'I', $rut);
        $rut = str_replace('ó', 'o', $rut);
        $rut = str_replace('Ó', 'O', $rut);
        $rut = str_replace('Ú', 'U', $rut);
        $rut = str_replace('ú', 'u', $rut);
        $rut = str_replace('k', 'K', $rut);

        //Quitando Caracteres Especiales 
        $rut = str_replace('"', '', $rut);
        $rut = str_replace(':', '', $rut);
        $rut = str_replace('.', '', $rut);
        $rut = str_replace(',', '', $rut);
        $rut = str_replace(';', '', $rut);
        $rut = str_replace('-', '', $rut);
        return $rut;
    }

    protected function crearUsuario($rut, $nombre, $rol)
    {
        $usuario = new User;
        $usuario->rut = $rut;
        $usuario->nombre = $nombre;
        $usuario->password = bcrypt(substr($rut, -5, 4));
        $usuario->rol_id = $rol;
        $usuario->creada_por = Auth::user()->id;
        $usuario->estado_id = 1;
        $usuario->activo = 'S';
        if ($usuario->save()) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }

    protected function traerUser()
    {
        $user = DB::table('users')
            ->select([
                'id',
                'rut',
                'nombre',
                'rol_id'
            ])
            ->where([
                'id' => Auth::user()->id
            ])
            ->first();

        if (!is_null($user)) {
            return ['estado' => 'success', 'user' => $user];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'Usuario no encontrado.'];
        }
    }

}
