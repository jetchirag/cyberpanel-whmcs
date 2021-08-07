<?php
/**
 *
 * CyberPanel whmcs module
 * @jetchirag
 *
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

// Include API Class
include("api.php");

function cyberpanel_MetaData()
{
    return array(
        'DisplayName' => 'CyberPanel',
        'APIVersion' => '1.0',
        'RequiresServer' => true,
        'DefaultNonSSLPort' => '8090',
        'DefaultSSLPort' => '8090',
        'ServiceSingleSignOnLabel' => 'Login as User',
        'AdminSingleSignOnLabel' => 'Login as Admin',
    );
}

function cyberpanel_ConfigOptions()
{
    return array(
        'Package Name' => array(
            'Type' => 'text',
            'Default' => 'Default',
            'Description' => 'Enter package name for this product',
        ),
        'ACL' => array(
            'Type' => 'text',
            'Default' => 'user',
            'Description' => 'ACL to be assigned to the new user',
        )
    );
}


function cyberpanel_CreateAccount(array $params)
{
    try {
        
        $api = new CyberApi();
        $response = $api->create_new_account($params);
        
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $response
        );

        // Checking for errors
        if (!$response["createWebSiteStatus"]){
        	return $response["error_message"];
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function cyberpanel_SuspendAccount(array $params)
{
    try {
        
        $params['status'] = "Suspend";
        $api = new CyberApi();
        $response = $api->change_account_status($params);
        
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $response
        );

        // Checking for errors
        if (!$response["websiteStatus"]){
        	return $response["error_message"];
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function cyberpanel_UnsuspendAccount(array $params)
{
    try {
        $status = "Unsuspend";

        $api = new CyberApi();
        $response = $api->change_account_status($params, $status);
        
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $response
        );

        // Checking for errors
        if (!$response["websiteStatus"]){
        	return $response["error_message"];
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}
function cyberpanel_TerminateAccount(array $params)
{
    try {
        
        $api = new CyberApi();
        $response = $api->terminate_account($params);
        
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $response
        );

        // Checking for errors
        if (!$response["websiteDeleteStatus"]){
        	return $response["error_message"];
        }        
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function cyberpanel_ChangePassword(array $params)
{
    try {

        $api = new CyberApi();
        $response = $api->change_account_password($params);
        
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $response
        );

        // Checking for errors
        if (!$response["changeStatus"]){
        	return $response["error_message"];
        }        
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}


function cyberpanel_ChangePackage(array $params)
{
    try {

        $api = new CyberApi();
        $response = $api->change_account_package($params);
        
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $response
        );

        // Checking for errors
        if (!$response["changePackage"]){
        	return $response["error_message"];
        }        
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function cyberpanel_TestConnection(array $params)
{
    try {

        $api = new CyberApi();
        $response = $api->verify_connection($params);
        
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $response
        );

        // Checking for errors
        $errorMsg = '';
        if (!$response["verifyConn"]){
        	$errorMsg =  $response["error_message"];
        	$success = false;
        }
        else {
        	$success = true;
        	$errorMsg = '';
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        $success = false;
        $errorMsg = $e->getMessage();
    }

    return array(
        'success' => $success,
        'error' => $errorMsg,
    );
}


function cyberpanel_ClientArea($params) {

    $loginform = '<form class="cyberpanel" action="' . (($params["serversecure"]) ? "https" : "http") . '://'.$params["serverhostname"].':'.$params['serverport'].'/api/loginAPI" method="post" target="_blank">
<input type="hidden" name="username" value="'.$params["username"].'" />
<input type="hidden" name="password" value="'.$params["password"].'" />
<input type="submit" value="Login to Control Panel" />
</form>';
    return $loginform;

}

function cyberpanel_AdminLink($params) {

    $loginform = '<form class="cyberpanel" action="' . (($params["serversecure"]) ? "https" : "http") . '://'.$params["serverhostname"].':'.$params['serverport'].'/api/loginAPI" method="post" target="_blank">
<input type="hidden" name="username" value="'.$params["serverusername"].'" />
<input type="hidden" name="password" value="'.$params["serverpassword"].'" />
<input type="submit" value="Login to Control Panel" />
</form>';
    return $loginform;

}
