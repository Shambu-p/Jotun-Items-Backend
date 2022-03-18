<?php
namespace Application\Controllers;

use Absoft\Line\App\Security\Auth;
use Absoft\Line\App\Security\AuthorizationManagement;
use Absoft\Line\Core\FaultHandling\Exceptions\ForbiddenAccess;
use Absoft\Line\Core\FaultHandling\FaultHandler;
use Absoft\Line\Core\HTTP\Request;
use Absoft\Line\Core\Modeling\Controller;

class AuthController extends Controller {


    /**
     * @param $request
     * @return string
     * @throws ForbiddenAccess
     */
    public function index($request){

        $auth = Auth::Authenticate("user_auth", [$request->username, $request->password]);

        if(sizeof($auth)){
            $token = AuthorizationManagement::set($auth, "user_auth");
            $cre = AuthorizationManagement::getAuth($token, "user_auth");
            $cre["token"] = $token;
            return $this->respond($cre, 1);
        }

        throw new ForbiddenAccess();

    }

    /**
     * @param $request
     * @return Request
     * @throws ForbiddenAccess
     */
    public function view($request){

        $saved = AuthorizationManagement::viewAuth($request->token, "user_auth");
        if(sizeof($saved) == 0){
            throw new ForbiddenAccess();
        }

        return $this->respond($saved, 1);

    }

    /**
     * @param $request
     * @return Request
     * @throws ForbiddenAccess
     */
    private function authorization($request){

//        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
//            throw new ForbiddenAccess();
//        }

        $saved = AuthorizationManagement::getAuth($request->token, "user_auth");

        if(sizeof($saved) == 0){
            throw new ForbiddenAccess();
        }

        return $this->respond($saved, 1);

    }

    /**
     * @param $request
     * @return Request
     * @throws ForbiddenAccess
     */
    private function updateLogin($request){

        $auths = AuthorizationManagement::viewAuth($request->token, "user_auth");
        $auth = Auth::Authenticate("user_auth", [$auths["username"], md5($request->password)]);

        if(!sizeof($auth)){
            throw new ForbiddenAccess();
        }

        $saved = AuthorizationManagement::update($request->token, "user_auth");
        if(sizeof($saved) == 0){
            throw new ForbiddenAccess();
        }

        return $this->respond($saved, 1);

    }

    public function logout($request){

        if(AuthorizationManagement::delete($request->token, "user_auth")){
            return $this->respond([], 1);
        }

        FaultHandler::reportError("Logout Failure", "logout is Failed.", __File__, "immediate");

        return "";
    }

}
?>
