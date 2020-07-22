<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/customers', function (Request $request, Response $response, array $args) use ($container) {
        $sth = $this->db->prepare("SELECT * FROM customer order by customer_id DESC");
        $sth->execute();
        $tom = $sth->fetchAll();
        return json_encode ($tom,JSON_UNESCAPED_UNICODE ) ;
        
    });

    
    $app->delete('/customers/[{id}]', function (Request $request, Response $response, array $args) use ($container) {
        $sth = $this->db->prepare("DELETE FROM customer WHERE customer_id =:id ");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        return json_encode ($response,JSON_UNESCAPED_UNICODE ) ;
        
    });

    $app->post('/customers', function (Request $request, Response $response, array $args) use ($container) {
        $_input = $request->getParsedBody();

        $_data_1 = $_input['firstname'];
        $_data_2 = $_input['lastname'];
        $_data_3 = $_input['tel'];
        $rsp = array();
    
        if(!empty($_data_1 && !empty($_data_2) && !empty($_data_3))){
            $sth = $this->db->prepare('INSERT INTO customer SET first_name="'.$_data_1.'", last_name="'.$_data_2.'", tel_no="'.$_data_3.'"');
            $sth->execute();
            $rsp["success"] = true;
            $rsp['message'] = "Insert my name is ".$_data_1." and my lastname is ".$_data_2." and my tel is ".$_data_3;
        }else{
    
            $rsp["error"] = false;
            $rsp['message'] = "invalid request parameters error" ;
        }
    
        return json_encode ($rsp,JSON_UNESCAPED_UNICODE ) ;
        
    });

    $app->put('/customers/{id}', function (Request $request, Response $response, array $args) use ($container) {

        $get_id = $request->getAttribute('id');
        $_input = $request->getParsedBody();

        $_data_1 = $_input['firstname'];
        $_data_2 = $_input['lastname'];
        $_data_3 = $_input['tel'];
        $rsp = array();
    
        if(!empty($_data_1 && !empty($_data_2) && !empty($_data_3))){
            $sth = $this->db->prepare('UPDATE customer SET  first_name="'.$_data_1.'", last_name="'.$_data_2.'", tel_no="'.$_data_3.'" WHERE customer_id = "'.$get_id.'"');
            $sth->execute();
            $rsp["success"] = true;
            $rsp['message'] = "UPDATE my name is ".$_data_1." and my lastname is ".$_data_2." and my tel is ".$_data_3;
        }else{
    
            $rsp["error"] = false;
            $rsp['message'] = "invalid request parameters error" ;
        }
    
        return json_encode ($rsp,JSON_UNESCAPED_UNICODE ) ;
        
    });




};



