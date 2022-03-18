<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 5/27/2021
 * Time: 11:20 AM
 */

namespace Absoft\Line\App\Administration;


use Absoft\Line\App\Security\Auth;
use Absoft\Line\App\Security\AuthorizationManagement;
use Absoft\Line\Core\FaultHandling\Exceptions\BuildersFolderNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\ClassNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\ControllersFolderNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\FileNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\ForbiddenAccess;
use Absoft\Line\Core\FaultHandling\Exceptions\ModelsFolderNotFound;
use Absoft\Line\Core\FaultHandling\Exceptions\OperationFailed;
use Absoft\Line\Core\FaultHandling\Exceptions\RouteNotFound;
use Absoft\Line\Core\HTTP\Request;
use Absoft\Line\Core\HTTP\Route;
use Absoft\Line\Core\Modeling\Controller;
use Absoft\Line\Core\Modeling\Models\Model;
use Application\conf\Configuration;

class AdminController extends Controller
{

    /**
     * @param $name
     * @param $parameter
     * @return mixed|string
     * @throws RouteNotFound
     * @throws BuildersFolderNotFound
     * @throws ControllersFolderNotFound
     * @throws FileNotFound
     * @throws ModelsFolderNotFound
     * @throws OperationFailed
     * @throws ForbiddenAccess
     * @throws ClassNotFound
     */
    public function route($name, $parameter){

        switch ($name){
            case "all_controllers":
                $response = $this->allControllers($parameter);
                break;
            case "all_builders":
                $response = $this->allBuilders($parameter);
                break;
            case "all_models":
                $response = $this->allModels($parameter);
                break;
            case "new_controller":
                $response = $this->newController($parameter);
                break;
            case "new_builder":
                $response = $this->newBuilder($parameter);
                break;
            case "new_model":
                $response = $this->newModel($parameter);
                break;
            case "delete_controller":
                $response = $this->deleteController($parameter);
                break;
            case "delete_model":
                $response = $this->deleteModel($parameter);
                break;
            case "delete_builder":
                $response = $this->deleteBuilder($parameter);
                break;
            case "schema":
                $response = $this->schema($parameter);
                break;
            case "records":
                $response = $this->records($parameter);
                break;
            case "export":
                $response = $this->exportTable($parameter);
                break;
            case "drop":
                $response = $this->dropTable($parameter);
                break;
            case "insertData":
                $response = $this->insertData($parameter);
                break;
            case "about":
                $response = $this->about();
                break;
            case "info":
                $response = $this->info($parameter);
                break;
            case "initiate":
                $response = $this->initiate($parameter);
                break;
            case "login":
                $response = $this->login($parameter);
                break;
            case "login_update":
                $response = $this->updateLogin($parameter);
                break;
            case "authorization":
                $response = $this->authorization($parameter);
                break;
            case "change_password":
                $response = $this->changePassword($parameter);
                break;
            case "view_token":
                $response = $this->viewAuth($parameter);
                break;
            case "logout":
                $response = $this->logout($parameter);
                break;
            case "create_route":
                $response = $this->createRoute($parameter);
                break;
            case "delete_route":
                $response = $this->deleteRoute($parameter);
                break;
            case "update_route":
                $response = $this->editRoute($parameter);
                break;
            case "get_routes":
                $response = $this->getRoutes($parameter);
                break;
            default:
                throw new RouteNotFound("AdminController.$name");
        }

        return $response;

    }

    /**
     * @param $request
     * @return Request
     * @throws ClassNotFound
     */
    private function initiate($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "amin_auth")){
            throw new ForbiddenAccess();
        }

        $model = new Initializers();
        $result = $model->init($request->name);
        Administration::changeVariable($request->name, "initiated", true);
        return $this->respond($result, 1);

    }

    private function about(){

        $conf = Configuration::$conf;
        $conf["line_version"] = "2.1.4";
        $conf["admin_panel_version"] = "2.0";
        $conf["variables"] = (Array) Administration::variables();

        return $this->respond($conf, 1);

    }

    /**
     * @throws ControllersFolderNotFound
     */
    private function allControllers($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Controllers();

        $result = $cont->all();

        return $this->respond($result, 1);

    }

    /**
     * @return Request
     * @throws BuildersFolderNotFound
     * @throws FileNotFound
     */
    private function allBuilders($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Builders();

        $result = $cont->all();

        return $this->respond($result, 1);

    }

    /**
     * @param $request
     * @return Request
     * @throws ControllersFolderNotFound
     * @throws OperationFailed
     */
    private function newController($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Controllers();

        if($cont->create($request->name)){
            Administration::changeVariable($request->name, "controller", true);
            return $this->respond([], 1);
        }else{
            throw new OperationFailed("Unknown Error");
        }

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     * @throws ModelsFolderNotFound
     */
    private function newModel($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Models();

        if($cont->create($request->name)){
            Administration::changeVariable($request->name, "model", true);
            return $this->respond([], 1);
        }else{
            throw new OperationFailed("Unknown Error");
        }

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     * @throws BuildersFolderNotFound
     */
    private function newBuilder($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Builders();

        if($cont->create($request->name)){
            Administration::changeVariable($request->name, "builder", true);
            return $this->respond([], 1);
        }else{
            throw new OperationFailed("Unknown Error");
        }

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     * @throws FileNotFound
     */
    private function deleteBuilder($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Builders();

        if($cont->delete($request->name)){
            Administration::changeVariable($request->name, "builder", false);
            return $this->respond([], 1);
        }else{
            throw new OperationFailed("Unknown Error");
        }

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     * @throws FileNotFound
     */
    private function deleteController($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Controllers();

        if($cont->delete($request->name)){
            
            $all_routes = Route::allRoutes();

            foreach($all_routes as $route_name => $parameters){
                
                if(strpos($route_name, "/".$request->name."/") !== false){
                    RouteAdministration::deleteRoute($route_name);
                }

            }

            Administration::changeVariable($request->name, "controller", false);
            return $this->respond([], 1);
        }else{
            throw new OperationFailed("Unknown Error");
        }

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     * @throws FileNotFound
     */
    private function deleteModel($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $cont = new Models();

        if($cont->delete($request->name)){
            Administration::changeVariable($request->name, "model", false);
            return $this->respond([], 1);
        }else{
            throw new OperationFailed("Unknown Error");
        }

    }

    /**
     * @throws ModelsFolderNotFound
     */
    private function allModels($request){
        
        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $md = new Models();

        $result = $md->all();
        return $this->respond($result, 1);

    }

    /**
     * @param $request
     * @return Request
     */
    private function schema($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        try {

            $table = new Table();
            $result = $table->schema($request->name);
            return $this->respond($result, 1);

        } catch (ClassNotFound $e) {
            return $this->respond([], 1);
        }

    }

    private function records($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        try {
            $table = new Table();
            $result = $table->record($request->name);
            return $this->respond($result, 1);
        } catch (ClassNotFound $e) {
            return $this->respond([], 1);
        }

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     */
    private function dropTable($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $builders = new Builders();
        try {

            if($builders->drop($request->name)){
                Administration::changeVariable($request->name, "exported", false);
                Administration::changeVariable($request->name, "initiated", false);
                return $this->respond([], 1);
            }else{
                throw new OperationFailed("Operation failed!");
            }

        } catch (ClassNotFound $e) {
            return $this->respond([], 1);
        }


    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     */
    private function exportTable($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $builders = new Builders();
        try {

            if($builders->execute($request->name)){
                Administration::changeVariable($request->name, "exported", true);
                return $this->respond([], 1);
            }else{
                throw new OperationFailed("Operation failed!");
            }

        } catch (ClassNotFound $e) {
            return $this->respond([], 1);
        }

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     */
    private function insertData($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $full_name = "Application\\Models\\$request->name"."Model";

        try {

            $data = (array) json_decode($request->data);
            $insert = [];

            $builders = new Table();
            $schema = $builders->schema($request->name);

            /** @var $model Model */
            if($model = new $full_name){

                foreach ($schema["attributes"] as $item) {

                    if(!$item["auto_increment"]){

                        $insert[$item["name"]] = $data[$item["name"]];

                    }

                }

                foreach ($schema["hidden"] as $item) {

                    if(!$item["auto_increment"]){

                        $insert[$item["name"]] = $data[$item["name"]];

                    }

                }

                if($model->addRecord($insert)){
                    return $this->respond([], 1);
                }else{
                    throw new OperationFailed("Record were not inserted. Operation failed");
                }

            }else{
                throw new ClassNotFound($full_name, "Administration controller file.", __LINE__);
            }

        } catch (ClassNotFound $e) {
            return $this->respond([], 1);
        }

    }

    private function info($request){
        return $this->respond( Administration::see($request->name), 1);
    }

// Route administrations

    private function createRoute($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        RouteAdministration::createRoute($request->route_name, $request->parameters);
        return $this->respond([], 1);

    }

    private function getRoutes($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $all_routes = Route::allRoutes();
        $ret = [];

        foreach($all_routes as $route_name => $parameters){
            
            if(strpos($route_name, "/".$request->controller."/") !== false){
                $ret[$route_name] = $parameters;
            }

        }

        return $this->respond($ret, 1);

    }

    private function editRoute($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $changed = (array) json_decode($request->changed);
        
        if(sizeof($changed) == 0){
            throw new OperationFailed("in correct new attributes! attributes array should contain route name as name and route parameters as parameters!");
        }

        RouteAdministration::change($request->route_name, $changed);
        return $this->respond([], 1);

    }

    private function deleteRoute($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        RouteAdministration::deleteRoute($request->route_name);
        return $this->respond([], 1);

    }

    /**
     * @param $request
     * @return Request
     * @throws ForbiddenAccess
     */
    private function login($request){

        $auth = Auth::Authenticate("admin_auth", [$request->username, $request->password]);

        if(sizeof($auth) && $auth["status"] == "active" && $auth["role"] == "super_user"){
            $token = AuthorizationManagement::set($auth, "admin_auth");
            $cre = AuthorizationManagement::getAuth($token, "admin_auth");
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
    private function updateLogin($request){

        $auths = AuthorizationManagement::viewAuth($request->token, "admin_auth");
        $auth = Auth::Authenticate("admin_auth", [$auths["username"], $request->password]);

        if(!sizeof($auth) || $auth["status"] != "active" || $auth["role"] != "super_user"){
            throw new ForbiddenAccess();
        }

        $saved = AuthorizationManagement::update($request->token, "admin_auth");
        if(sizeof($saved) == 0){
            throw new ForbiddenAccess();
        }

        return $this->respond($saved, 1);

    }

    private function viewAuth($request){
        
        $saved = AuthorizationManagement::viewAuth($request->token, "admin_auth");
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

        $saved = AuthorizationManagement::getAuth($request->token, "admin_auth");
        if(sizeof($saved) == 0){
            throw new ForbiddenAccess();
        }

        return $this->respond($saved, 1);

    }

    /**
     * @param $request
     * @return Request
     * @throws ForbiddenAccess
     * @throws OperationFailed
     */
    private function changePassword($request){

        if(!AuthorizationManagement::checkAuthorization($request->token, "admin_auth")){
            throw new ForbiddenAccess();
        }

        $auth = AuthorizationManagement::getAuth($request->token, "admin_auth");

        if($auth["username"] != $request->username){
            throw new ForbiddenAccess();
        }

        $model = new AdminModel();

        $result = $model->findRecord($auth["id"]);

        if(!password_verify($request->old_password, $result["password"])){

            header("Content-type: application/json");

            return $this->respond(json_encode([
                "header" => [
                    "error" => "true",
                    "message" => "current password is not correct"
                ],
                "data" => []
            ]));

        }

        $model->changePassword($request->username, $request->new_password);
        return $this->respond([], 1);

    }

    /**
     * @param $request
     * @return Request
     * @throws OperationFailed
     */
    private function logout($request){
        
        if(!AuthorizationManagement::delete($request->token, "admin_auth")){
            throw new OperationFailed("logout is Failed.");
        }

        return $this->respond([], 1);

    }

}
