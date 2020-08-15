<?php 
/*
* API Wrapper for Cyberpanel
* by @jetchirag
*/


class CyberApi
{
	private function callUrl($params, $url)
	{
        return (($params["serversecure"]) ? "https" : "http"). "://".$params["serverhostname"].":". $params['serverport'] ."/api/".$url;
	}
	
	private function call_cyberpanel($params,$url,$post = array())
	{
		$call = curl_init();
		curl_setopt($call, CURLOPT_URL, $this->callUrl($params,$url));	
		curl_setopt($call, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($call, CURLOPT_RETURNTRANSFER, true);	
		curl_setopt($call, CURLOPT_POST, true);
		curl_setopt($call, CURLOPT_POSTFIELDS, json_encode($post));
		curl_setopt($call, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);

		// Fire api
		$result = curl_exec($call);
		$info = curl_getinfo($call);
		curl_close($call);
		$result = json_decode($result,true);

		// Return data
		return $result;
	}
	
    public function create_new_account($params)
    {
        $url = "createWebsite";
        $postParams =
            [
                "adminUser" => $params["serverusername"],
                "adminPass" => $params["serverpassword"],
                "domainName" => $params["domain"],
                "ownerEmail" => $params["clientsdetails"]["email"],
                "packageName" => $params['configoption1'],
                "websiteOwner" => $params["username"],
                "ownerPassword" => $params["password"],
                "acl" => $params['configoption2'],
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }

    public function change_account_status($params)
    {
        $url = "submitWebsiteStatus";
        $postParams =
            [
                "adminUser" => $params["serverusername"],
                "adminPass" => $params["serverpassword"],
                "websiteName" => $params["domain"],
                "state" => $params["status"],
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }

    // Test connection
    public function verify_connection($params)
    {
        $url = "verifyConn";
        $postParams =
            [
                "adminUser" => $params["serverusername"],
                "adminPass" => $params["serverpassword"],
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
	
    public function terminate_account($params)
    {
        $url = "deleteWebsite";
        $postParams =
            [
                "adminUser" => $params["serverusername"],
                "adminPass" => $params["serverpassword"],
                "domainName"=> $params["domain"]
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
	
    public function change_account_password($params)
    {
        $url = "changeUserPassAPI";
        $postParams =
            [
                "adminUser" => $params["serverusername"],
                "adminPass" => $params["serverpassword"],
                "websiteOwner"=> $params["username"],
                "ownerPassword"=> $params["password"]
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
	
    public function change_account_package($params)
    {
        $url = "changePackageAPI";
        $postParams =
            [
                "adminUser" => $params["serverusername"],
                "adminPass" => $params["serverpassword"],
                "websiteName"=> $params["domain"],
                "packageName"=> $params['configoption1']
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
}
?>
