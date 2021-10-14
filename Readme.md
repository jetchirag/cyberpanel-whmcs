# CyberPanel WHMCS Module 

Using WHMCS module for CyberPanel, you can sell or automate basic functions of CyberPanel for your customers. You can install this module by following WHMCS server module installation steps. Here they are again:-

### Option 1 (Recommended)
1. Login to SSH for whmcs server
2. Navigate to path_to_whmcs/modules/servers
3. Clone this repo into cyberpanel folder
```
git clone https://github.com/jetchirag/cyberpanel-whmcs.git cyberpanel
```
### Option 2
1. Download this repo as zip file
2. Navigate to path_to_whmcs/modules/servers
3. Upload and extract the file in cyberpanel folder (create new)

# Functions of this module are:

- Create new website or user account
- Terminate website
- Suspend or un-suspend website
- Change package 
- Change user password
- Auto-login for Customer or Admin user

# Common Errors
##### Error: 

```
 Data supplied is not accepted, following characters are not allowed in the input ` $ & ( ) [ ] { } ; : ‘ < >.
 ```
 **Solution**: Remove those special character from service's password
 
 ##### Error:
 ```
 API Access Disabled.
 ```
 **Solution**: Enable API Access from CyberPanel for user
 
 ##### Error:
 ```
 Unknown Error Occurred
 ```
 **Solution**: Usually means WHMCS is unable to reach api. Ensure hostname/ipaddress is correct and CyberPanel access port is open i.e. 8090 in firewall. 
