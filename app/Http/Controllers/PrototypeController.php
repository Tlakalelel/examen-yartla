<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\Types\Self_;

class PrototypeController extends Controller
{
     /**
     * Llave base
     *
     * @var string
     */
    static private $key = null;
    
    /**
     * string
     *
     * @var string
     */
    static private $StringEncrypted = null;
    
    /**
     * string
     *
     * @var string
     */
    static private $StringDecrypted = null;
   
    /**
     * string
     *
     * @var array
     */
    static protected $Config_SSL = array(
        "digest_alg" => null,
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
      
    /**
     * string
     *
     * @var string
     */
    protected $ResponseKey;
      

    /**
     * Show the form
     *
     * @param  void
     * @return \Illuminate\View\View
     */
    final private function generateNewKey($method = null)
    {
        self::$Config_SSL['digest_alg']=$method;
 
        $this->ResponseKey = openssl_pkey_new(self::$Config_SSL);
       
        // Get private and pubic key
        openssl_pkey_export($this->ResponseKey, $privkey);
        $pubKey=openssl_pkey_get_details($this->ResponseKey);
        
        return str_replace(['-----BEGIN PUBLIC KEY-----','-----END PUBLIC KEY-----'],"",$pubKey['key']);

    }

    /**
     * Show the form
     *
     * @param  void
     * @return \Illuminate\View\View
     */
    final static private function encryptString($string = null)
    {
      
        $encrypt_method = "AES-128-ECB";
        Self::$StringEncrypted = openssl_encrypt($string,$encrypt_method, Self::$key);
        

    }
 
    /**
     * Show the form
     *
     * @param  void
     * @return \Illuminate\View\View
     */
    final static private function decryptString($string = null)
    {
        $encrypt_method = "AES-128-ECB";

        Self::$StringDecrypted = openssl_decrypt($string,$encrypt_method,self::$key);
        
    }
   
    /**
     * Show the form
     *
     * @param  void
     * @return \Illuminate\View\View
     */
     public function index()
     {
         return view('prototype.index');
     }

    /**
     * Show the form
     *
     * @param  void
     * @return \Illuminate\View\View
     */
    public function generateKey(Request $request)
    {
        //1.- Validar existen los parametros en el request
        //2.- Mostrar mensajes flash de los errores

        // Tareas el metodo y generar una LLAVE NUEVA

                //Validar
                
                
        try{
            //Logica de las tareas
            $request->validate([
                'method'=>'required'
            ]);
           
            return back()->with("key",$this->generateNewKey($request->get('method')))
                         ->with('successGK',"SE GENERO LA LLAVE");
        }catch(\Exception $error){
            return back()->with('errorGK',"Error:".$error->getMessage());
        }
    }

    
    /**
     * Show the form
     *
     * @param  Request
     * @return \Illuminate\View\View
     */
    public function encrypt(Request $request)
    {
        //1.- Validar existen los parametros en el request
        
        //2.- Mostrar mensajes flash de los errores
        
        // Tareas recibir una llave y una cadena 
        // La llave tendrá que ser la misma que la seteada como propiedad
        // La cadena puede ser encriptada con OPEN SSL solamente con AES de 128bits
        // Se tiene que generar otro formulario(view) para DESENCRIPTAR una cadena privamente encriptada
        //
        

        //validar
        // $this->encryptString();
        try{
            //Logica de las tareas
            $request->validate([
                'key'=>'required',
                'encript'=> 'required'
            ]);
            // echo $request->get('key');
            // echo $request->get('encript');
            Self::$key=$request->get('key');
            $this->encryptString($request->get('encript'));
            
            return back()->with('successME','Se ha encriptado el texto')
                         ->with('successGK',"SE GENERO LA LLAVE")
                         ->with('encrypt',Self::$StringEncrypted)
                         ->with('key',Self::$key);
        }catch(\Exception $error){
            return back()->with('errorME',"Error:".$error->getMessage());
            // echo $error->getMessage();
        }
    }
    
    /**
     * Show the form
     *
     * @param  Request
     * @return \Illuminate\View\View
     */
    public function decrypt(Request $request)
    {
        //1.- Validar existen los parametros en el request
        //2.- Mostrar mensajes flash de los errores

        // Tareas recibir una llave y una cadena 
        // La llave tendrá que ser la misma que la seteada como propiedad
        // La cadena puede ser encriptada con OPEN SSL solamente con AES de 128bits
        // Se tiene que generar otro formulario(view) para DESENCRIPTAR una cadena privamente encriptada
        //

        //validar
        
        try{
            $request->validate([
                'key'=>'required',
                'encript'=> 'required'
            ]);
            Self::$key=$request->get('key');
            $this->decryptString($request->get('encript'));
            return back()->with('successMDE','Se ha encriptado el texto')
                         ->with('successGK',"SE GENERO LA LLAVE")
                         ->with('decrypt',Self::$StringDecrypted)
                         ->with('key',Self::$key);
            //Logica de las tareas
        }catch(\Exception $error){
            //Control de mensajes
            return back()->with('errorMDE',"Error:".$error->getMessage());
        }
    }
}